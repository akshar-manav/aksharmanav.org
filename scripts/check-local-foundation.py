#!/usr/bin/env python3
"""Static safety checks for the local Joomla container foundation."""

from __future__ import annotations

import shutil
import subprocess
import sys
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
COMPOSE = ROOT / "compose.yaml"
ENV_EXAMPLE = ROOT / ".env.example"
GITIGNORE = ROOT / ".gitignore"


def require(condition: bool, message: str) -> None:
    if not condition:
        raise AssertionError(message)


def run() -> int:
    compose = COMPOSE.read_text(encoding="utf-8")
    env_example = ENV_EXAMPLE.read_text(encoding="utf-8")
    gitignore = GITIGNORE.read_text(encoding="utf-8")

    require("image: joomla:6.1.2-php8.4-apache" in compose, "Joomla image is not pinned")
    require("image: mysql:8.4.11" in compose, "MySQL image is not pinned")
    require(":latest" not in compose, "An ambiguous latest image tag is present")
    require(compose.count("healthcheck:") == 2, "Both services need health checks")
    require("test -f /var/www/html/configuration.php" in compose, "Joomla health must require installation")
    require("127.0.0.1:${JOOMLA_HTTP_PORT:-8080}:80" in compose, "Joomla must bind to loopback")
    require("/var/www/html" in compose and "/var/lib/mysql" in compose, "Runtime volumes are incomplete")
    require("JOOMLA_EXTENSIONS_URLS" not in compose, "Unapproved Joomla extensions are configured")
    require("replace-with-a-" in env_example, "Example credentials must be obvious placeholders")
    require(env_example.count("replace-with-a-") == 3, "All three example passwords must be placeholders")
    require("admin@example.test" in env_example, "Example administrator email must be non-routable")
    require(".env\n" in gitignore and "!.env.example" in gitignore, ".env ignore rules are incomplete")
    require("**/configuration.php" in gitignore, "Joomla configuration.php must be ignored")

    print("PASS: static local-foundation safety checks")

    docker = shutil.which("docker")
    if docker is None:
        print("SKIP: Docker is unavailable; Compose parsing and runtime checks were not executed")
        return 0

    result = subprocess.run(
        [docker, "compose", "--env-file", str(ENV_EXAMPLE), "config", "--quiet"],
        cwd=ROOT,
        check=False,
    )
    if result.returncode != 0:
        print("FAIL: docker compose config --quiet", file=sys.stderr)
        return result.returncode

    print("PASS: docker compose config --quiet")
    return 0


if __name__ == "__main__":
    try:
        raise SystemExit(run())
    except AssertionError as error:
        print(f"FAIL: {error}", file=sys.stderr)
        raise SystemExit(1) from error
