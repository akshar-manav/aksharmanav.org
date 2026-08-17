[CmdletBinding()]
param()

$ErrorActionPreference = 'Stop'
Set-StrictMode -Version Latest

$repositoryRoot = Split-Path -Parent $PSScriptRoot
$phpScript = Join-Path $PSScriptRoot 'bootstrap-local-homepage.php'
$templateSource = Join-Path $repositoryRoot 'src\templates\aksharmanav'
$backupDirectory = Join-Path $repositoryRoot 'backups\local-homepage-bootstrap'
$timestamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$backupFile = Join-Path $backupDirectory "before-homepage-$timestamp.sql"
$containerBackupFile = "/tmp/aksharmanav-before-homepage-$timestamp.sql"
$containerScript = '/tmp/aksharmanav-bootstrap-local-homepage.php'

Set-Location $repositoryRoot

if (-not (Test-Path $phpScript -PathType Leaf)) {
    throw "Bootstrap PHP script not found: $phpScript"
}

if (-not (Test-Path (Join-Path $templateSource 'index.php') -PathType Leaf)) {
    throw "Template source not found: $templateSource"
}

Write-Host 'Checking the local Joomla stack...'
& docker compose exec -T joomla test -f /var/www/html/configuration.php
if ($LASTEXITCODE -ne 0) {
    throw 'Joomla is not ready. Run docker compose up -d and try again.'
}

New-Item -ItemType Directory -Force -Path $backupDirectory | Out-Null
Write-Host "Creating a recoverable database backup at $backupFile ..."

$dumpCommand = 'exec mysqldump --single-transaction --no-tablespaces --default-character-set=utf8mb4 --user="$MYSQL_USER" --password="$MYSQL_PASSWORD" "$MYSQL_DATABASE" > ' + $containerBackupFile

try {
    & docker compose exec -T db sh -lc $dumpCommand
    if ($LASTEXITCODE -ne 0) {
        throw 'The database container could not create the pre-change backup.'
    }

    & docker compose cp "db:$containerBackupFile" $backupFile
    if ($LASTEXITCODE -ne 0 -or -not (Test-Path $backupFile -PathType Leaf)) {
        throw 'The pre-change database backup could not be copied to the repository backup directory.'
    }
}
catch {
    throw "The pre-change database backup failed. No homepage changes were applied. $($_.Exception.Message)"
}
finally {
    & docker compose exec -T db rm -f $containerBackupFile | Out-Null
}

Write-Host 'Synchronizing the reviewed template source into local Joomla...'
$templateCopySource = $templateSource + '\.'
& docker compose cp $templateCopySource 'joomla:/var/www/html/templates/tpl_aksharmanav/'
if ($LASTEXITCODE -ne 0) {
    throw 'Could not synchronize the template source into local Joomla.'
}

Write-Host 'Checking the installed template PHP...'
& docker compose exec -T joomla php -l /var/www/html/templates/tpl_aksharmanav/index.php
if ($LASTEXITCODE -ne 0) {
    throw 'The synchronized template failed PHP linting. No database changes were applied.'
}

Write-Host 'Applying the editable homepage bootstrap...'
& docker compose cp $phpScript "joomla:$containerScript"
if ($LASTEXITCODE -ne 0) {
    throw 'Could not copy the bootstrap script into the Joomla container.'
}

try {
    & docker compose exec -T joomla php $containerScript
    if ($LASTEXITCODE -ne 0) {
        throw 'The homepage bootstrap did not complete.'
    }
}
finally {
    & docker compose exec -T joomla rm -f $containerScript | Out-Null
}

Write-Host ''
Write-Host 'Done. Refresh http://127.0.0.1:8080/ to inspect the editable homepage.'
