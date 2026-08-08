# Local Joomla development

This foundation runs Joomla and MySQL locally with Docker Compose. It does not depend on Railway or any other host, create external resources, or contain production configuration.

## Pinned baseline

| Component | Local image or setting |
|---|---|
| Joomla | `joomla:6.1.2-php8.4-apache` |
| PHP | `8.4`, supplied by the Joomla image |
| MySQL | `mysql:8.4.11` |
| PHP memory limit | `256M` |

These are exact release tags rather than moving `latest` tags. Image publishers may rebuild an existing tag to deliver operating-system or base-image fixes. Record the resolved image digests during executable verification when strict byte-for-byte reproduction is required.

## What is tracked

Git tracks the Compose definition, safe example variables, local PHP settings, validation script, documentation, and future reviewed custom code.

Docker named volumes hold the Joomla runtime tree and MySQL data:

- `joomla_data` at `/var/www/html`, including Joomla core, `configuration.php`, runtime uploads, caches, logs and temporary files;
- `mysql_data` at `/var/lib/mysql`, including all local database files.

These named volumes are outside the repository. Do not copy them, `configuration.php`, database exports, private media or real `.env` files into Git. Future custom templates or extensions will be tracked separately from this runtime tree.

## Prerequisites

- Docker Desktop with the Compose v2 plugin;
- at least 4 GB of memory available to Docker Desktop;
- free local port `8080`, or another port selected in `.env`.

The examples below use Windows PowerShell and the canonical clone location.

## First start on Windows

1. Start Docker Desktop and wait until it reports that the engine is running.
2. Open PowerShell.
3. Move to the repository and confirm its state:

   ```powershell
   Set-Location 'D:\Work\Akshar Manav\aksharmanav-website\aksharmanav.org'
   git status --short --branch
   git fetch origin
   git switch main
   git pull --ff-only origin main
   ```

4. When testing a draft branch, switch to the branch named in its pull request after updating `main`.
5. Create the local configuration:

   ```powershell
   Copy-Item .env.example .env
   notepad .env
   ```

6. Replace all three `replace-with-*` password values with different, unique local passwords. Keep `.env` on this computer and never commit it. Values containing `#` should be enclosed in double quotes.
7. Validate and start the environment:

   ```powershell
   docker compose config --quiet
   docker compose pull
   docker compose up --detach --wait
   docker compose ps
   ```

8. Open `http://127.0.0.1:8080` in a browser. If `JOOMLA_HTTP_PORT` was changed, use that port instead. The official Joomla image performs the neutral local installation using the values in `.env`.

The Joomla administrator is at `http://127.0.0.1:8080/administrator`. Use the local username and password from `.env`.

## Version and health evidence

Run:

```powershell
docker compose config --images
docker compose exec joomla php --version
docker compose exec joomla php cli/joomla.php --version
docker compose exec db mysql --version
docker compose ps
$response = Invoke-WebRequest 'http://127.0.0.1:8080' -UseBasicParsing
$response.StatusCode
```

Expected results:

- the images are `joomla:6.1.2-php8.4-apache` and `mysql:8.4.11`;
- PHP reports `8.4.x`;
- the Joomla command reports `6.1.2`;
- MySQL reports `8.4.11`;
- both services become `healthy`;
- the HTTP status is `200`.

The static checker can also be run wherever Python 3 is available:

```powershell
python scripts/check-local-foundation.py
```

It performs repository-safety checks and, when Docker is present, asks Docker Compose to parse the configuration. It does not start containers.

## Stop, restart and inspect

Stop the containers while retaining the site and database:

```powershell
docker compose stop
```

Start the retained environment again:

```powershell
docker compose start
docker compose ps
```

Follow logs:

```powershell
docker compose logs --follow --tail 100
```

Shut down containers while retaining the named volumes:

```powershell
docker compose down
```

## Reset local data

This command permanently deletes only this Compose project's local Joomla and MySQL named volumes. It removes the local site, administrator account, uploads and database. It does not affect GitHub, hosting, DNS or any external system.

```powershell
docker compose down --volumes --remove-orphans
```

After confirming that the reset is intended, run the command and then repeat the first-start commands. Changing credentials in `.env` does not change an already-initialised database; reset is required for a clean reinstallation.

## Troubleshooting

### Docker is unavailable

Confirm Docker Desktop is running, then use:

```powershell
docker version
docker compose version
```

If the client is installed but the server section is missing, wait for Docker Desktop or restart it.

### Port 8080 is already in use

Set a different host port in `.env`, for example `JOOMLA_HTTP_PORT=8081`, then run `docker compose up --detach --wait` and open `http://127.0.0.1:8081`.

### A service is unhealthy

Inspect status and recent logs:

```powershell
docker compose ps
docker compose logs --tail 200 db
docker compose logs --tail 200 joomla
```

Typical causes are unchanged placeholder passwords, invalid `.env` syntax, insufficient Docker memory, a stale partially initialised volume or an occupied port. Do not paste `.env` values into public issues or pull requests.

### Installation used old values

The named volumes retain the first installation. If the data is disposable, use the documented reset command and start again. A reset is not a backup or restore procedure; recovery proof is a later checkpoint.

## Portability boundary

The local runtime uses standard Joomla files, PHP 8.4, MySQL 8.4 and Apache. It adds no page builder or third-party Joomla extension. A later migration can export the Joomla filesystem and MySQL database to an ordinary compatible PHP/MySQL host. Host-specific deployment, backup/restore automation, staging and production configuration remain separate checkpoints.
