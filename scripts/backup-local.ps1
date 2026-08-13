[CmdletBinding()]
param(
    [string]$BackupRoot = "backups"
)

$ErrorActionPreference = "Stop"
$repoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $repoRoot

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    throw "Docker is required. Start Docker Desktop and try again."
}

& docker compose ps --status running | Out-Null
if ($LASTEXITCODE -ne 0) {
    throw "docker compose is unavailable or the local project cannot be read."
}

$timestamp = Get-Date -Format "yyyyMMdd-HHmmss"
$backupDir = Join-Path $repoRoot (Join-Path $BackupRoot $timestamp)
New-Item -ItemType Directory -Path $backupDir -Force | Out-Null

$dbFile = Join-Path $backupDir "database.sql"
$mediaFile = Join-Path $backupDir "media.tar.gz"
$manifestFile = Join-Path $backupDir "manifest.txt"

Write-Host "Creating database backup..."
& docker compose exec -T db sh -lc 'mysqldump --single-transaction --quick --lock-tables=false --no-tablespaces -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" > /tmp/akshar-manav-database.sql'
if ($LASTEXITCODE -ne 0) { throw "Database dump failed." }

& docker compose cp db:/tmp/akshar-manav-database.sql $dbFile
if ($LASTEXITCODE -ne 0) { throw "Copying the database dump failed." }
& docker compose exec -T db rm -f /tmp/akshar-manav-database.sql

if ((Get-Item $dbFile).Length -le 0) { throw "Database backup is empty." }
if (-not (Select-String -Path $dbFile -Pattern '^-- Dump completed on ' -Quiet)) {
    throw "Database backup does not contain mysqldump's completion marker; refusing to accept it as complete."
}

Write-Host "Creating uploaded-media backup..."
& docker compose exec -T joomla sh -lc 'tar -C /var/www/html -czf /tmp/akshar-manav-media.tar.gz images'
if ($LASTEXITCODE -ne 0) { throw "Media archive failed." }

& docker compose cp joomla:/tmp/akshar-manav-media.tar.gz $mediaFile
if ($LASTEXITCODE -ne 0) { throw "Copying the media archive failed." }
& docker compose exec -T joomla rm -f /tmp/akshar-manav-media.tar.gz

if ((Get-Item $mediaFile).Length -le 0) { throw "Media backup is empty." }

$joomlaVersion = (& docker compose exec -T joomla php cli/joomla.php --version 2>&1 | Out-String).Trim()
$mysqlVersion = (& docker compose exec -T db mysql --version 2>&1 | Out-String).Trim()

@(
    "Akshar Manav local backup"
    "Created: $(Get-Date -Format o)"
    "Joomla: $joomlaVersion"
    "MySQL: $mysqlVersion"
    "Database: database.sql"
    "Media: media.tar.gz"
    "Scope: local development database and Joomla images directory"
    "Warning: backup contents are intentionally Git-ignored and may contain sensitive data."
) | Set-Content -Path $manifestFile -Encoding UTF8

Write-Host "Backup created successfully: $backupDir"
Write-Host "Do not commit this directory or its contents."
