[CmdletBinding()]
param(
    [Parameter(Mandatory = $true)]
    [string]$BackupDirectory,

    [switch]$ConfirmDestructiveRestore
)

$ErrorActionPreference = "Stop"
$repoRoot = Split-Path -Parent $PSScriptRoot
Set-Location $repoRoot

if (-not $ConfirmDestructiveRestore) {
    throw "Restore is destructive to this Compose project's LOCAL Joomla and MySQL volumes. Re-run with -ConfirmDestructiveRestore after confirming that local data may be deleted."
}

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    throw "Docker is required. Start Docker Desktop and try again."
}

$resolvedBackup = (Resolve-Path $BackupDirectory).Path
$dbFile = Join-Path $resolvedBackup "database.sql"
$mediaFile = Join-Path $resolvedBackup "media.tar.gz"

if (-not (Test-Path $dbFile -PathType Leaf)) { throw "Missing database.sql in $resolvedBackup" }
if (-not (Test-Path $mediaFile -PathType Leaf)) { throw "Missing media.tar.gz in $resolvedBackup" }
if ((Get-Item $dbFile).Length -le 0) { throw "database.sql is empty." }
if ((Get-Item $mediaFile).Length -le 0) { throw "media.tar.gz is empty." }

Write-Host "Deleting only this Compose project's LOCAL Joomla and MySQL volumes..."
& docker compose down --volumes --remove-orphans
if ($LASTEXITCODE -ne 0) { throw "docker compose down failed." }

Write-Host "Creating a clean local Joomla foundation..."
& docker compose up --detach --wait
if ($LASTEXITCODE -ne 0) { throw "Clean local startup failed." }

Write-Host "Restoring database..."
& docker compose cp $dbFile db:/tmp/akshar-manav-restore.sql
if ($LASTEXITCODE -ne 0) { throw "Copying database backup into the container failed." }

& docker compose exec -T db sh -lc 'mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < /tmp/akshar-manav-restore.sql'
if ($LASTEXITCODE -ne 0) { throw "Database restore failed." }
& docker compose exec -T db rm -f /tmp/akshar-manav-restore.sql

Write-Host "Restoring uploaded media..."
& docker compose cp $mediaFile joomla:/tmp/akshar-manav-media.tar.gz
if ($LASTEXITCODE -ne 0) { throw "Copying media backup into the container failed." }

& docker compose exec -T joomla sh -lc 'tar -C /var/www/html -xzf /tmp/akshar-manav-media.tar.gz'
if ($LASTEXITCODE -ne 0) { throw "Media restore failed." }
& docker compose exec -T joomla rm -f /tmp/akshar-manav-media.tar.gz

& docker compose restart joomla | Out-Null
& docker compose ps
if ($LASTEXITCODE -ne 0) { throw "Container health check failed after restore." }

$publishedPort = (& docker compose port joomla 80 2>&1 | Out-String).Trim()
if (-not $publishedPort) { throw "Could not resolve the local Joomla HTTP port." }
$port = ($publishedPort -split ':')[-1]
$response = Invoke-WebRequest "http://127.0.0.1:$port" -UseBasicParsing
if ($response.StatusCode -ne 200) { throw "Restored Joomla did not return HTTP 200." }

Write-Host "Restore rehearsal completed successfully."
Write-Host "Joomla responded with HTTP 200 at http://127.0.0.1:$port"
Write-Host "Manually verify at least one known article/content item and one known uploaded image before recording Gate 2 recovery proof."
