#!/usr/bin/env python3
"""Validate and build the installable Akshar Manav Joomla template package."""

from __future__ import annotations

import argparse
import sys
import zipfile
from pathlib import Path
from xml.etree import ElementTree


REQUIRED_FILES = {
    "templateDetails.xml",
    "index.php",
    "css/template.css",
    "js/template.js",
    "language/en-GB/tpl_aksharmanav.ini",
    "language/en-GB/tpl_aksharmanav.sys.ini",
}

REQUIRED_POSITIONS = {
    "brand",
    "primary-menu",
    "language-switcher",
    "home-identity",
    "home-featured-event",
    "home-work-areas",
    "home-initiatives",
    "home-thought",
    "home-publication",
    "home-participate",
    "footer-primary",
    "footer-secondary",
}


def validate(source: Path) -> list[Path]:
    missing = sorted(path for path in REQUIRED_FILES if not (source / path).is_file())
    if missing:
        raise ValueError(f"missing required template files: {', '.join(missing)}")

    manifest = ElementTree.parse(source / "templateDetails.xml").getroot()
    if manifest.attrib.get("type") != "template" or manifest.attrib.get("client") != "site":
        raise ValueError("manifest must describe a Joomla site template")

    parent = manifest.findtext("parent")
    if parent != "cassiopeia":
        raise ValueError("the first implementation must remain a Cassiopeia child template")

    positions = {node.text for node in manifest.findall("./positions/position") if node.text}
    absent_positions = sorted(REQUIRED_POSITIONS - positions)
    if absent_positions:
        raise ValueError(f"missing required module positions: {', '.join(absent_positions)}")

    index = (source / "index.php").read_text(encoding="utf-8")
    for position in REQUIRED_POSITIONS:
        if position not in index:
            raise ValueError(f"module position is declared but not rendered: {position}")

    forbidden = ("replace-with-", "JOOMLA_DB_PASSWORD", "MYSQL_ROOT_PASSWORD")
    files = sorted(path for path in source.rglob("*") if path.is_file())
    for path in files:
        if path.suffix.lower() in {".php", ".xml", ".css", ".js", ".ini", ".md"}:
            text = path.read_text(encoding="utf-8")
            for marker in forbidden:
                if marker in text:
                    raise ValueError(f"forbidden secret/configuration marker in {path}: {marker}")

    return files


def build(source: Path, destination: Path) -> None:
    files = validate(source)
    destination.parent.mkdir(parents=True, exist_ok=True)
    with zipfile.ZipFile(destination, "w", compression=zipfile.ZIP_DEFLATED) as archive:
        for path in files:
            archive.write(path, path.relative_to(source).as_posix())


def main() -> int:
    parser = argparse.ArgumentParser()
    parser.add_argument(
        "--source",
        type=Path,
        default=Path("src/templates/aksharmanav"),
        help="template source directory",
    )
    parser.add_argument(
        "--output",
        type=Path,
        default=Path("build/tpl_aksharmanav.zip"),
        help="package destination",
    )
    args = parser.parse_args()

    try:
        build(args.source, args.output)
    except (OSError, ValueError, ElementTree.ParseError) as error:
        print(f"template package check failed: {error}", file=sys.stderr)
        return 1

    print(f"template package ready: {args.output}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
