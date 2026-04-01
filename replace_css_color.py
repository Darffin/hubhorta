#!/usr/bin/env python3

import sys
from pathlib import Path


def replace_color(file_path: Path, old_color: str, new_color: str, backup=True):
    if not file_path.exists():
        raise FileNotFoundError(f"File not found: {file_path}")

    text = file_path.read_text(encoding="utf-8")

    if old_color not in text:
        print(f"WARNING: '{old_color}' not found in {file_path}")

    replaced = text.replace(old_color, new_color)

    if backup:
        backup_path = file_path.with_suffix(file_path.suffix + ".bak")
        backup_path.write_text(text, encoding="utf-8")
        print(f"Backup written: {backup_path}")

    file_path.write_text(replaced, encoding="utf-8")
    print(f"Replaced {old_color} -> {new_color} in {file_path}")


if __name__ == "__main__":
    if len(sys.argv) != 4:
        print(__doc__)
        sys.exit(1)

    css_path = Path(sys.argv[1])
    old = sys.argv[2].strip()
    new = sys.argv[3].strip()

    if not old.startswith("#") or not new.startswith("#"):
        raise ValueError("Colors must start with '#', e.g. #f5f5f5")

    replace_color(css_path, old, new)
