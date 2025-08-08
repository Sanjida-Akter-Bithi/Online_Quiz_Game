# save as collect_files.py
from pathlib import Path

# python collect_files.py

def collect_files(root: Path, out_file: Path):
    # Directories to skip (case-insensitive)
    SKIP_DIRS = {
        "node_modules",       # JS dependencies
        "vendor",             # PHP Composer dependencies
        "storage",            # Laravel storage (logs, uploads, etc.)
        "public/storage",     # Symlinked storage
        "bootstrap/cache",    # Laravel compiled cache files
        ".git",               # Git versioning stuff
        ".idea",              # PhpStorm IDE folder
        ".vscode",            # VSCode settings
        "__pycache__"         # Python cache, just in case
    }

    # Files to skip (case-insensitive)
    SKIP_FILES = {
        "package-lock.json",  # Node lock file
        "composer.lock",      # PHP dependency lock file
        ".env",               # Laravel environment config (sensitive)
        ".env.example",       # Sample env file
        "collect_files.py",   # This script itself
        "data.json",          # Any custom excluded data
        ".DS_Store",          # macOS file system junk
        "Thumbs.db"           # Windows file system junk
    }

    with out_file.open("w", encoding="utf-8", errors="replace") as out:
        for path in root.rglob("*"):
            # skip directories we know are useless
            if path.is_dir() and path.name.lower() in SKIP_DIRS:
                continue

            # only process files
            if not path.is_file():
                continue

            # skip files in excluded folders (defensive check)
            if any(part.lower() in SKIP_DIRS for part in path.parts):
                continue

            # skip specific files by name
            if path.name.lower() in SKIP_FILES:
                continue

            # write a readable header + file content
            rel = path.relative_to(root)
            out.write(f"\n===== FILE: {rel} =====\n")
            try:
                text = path.read_text(encoding="utf-8", errors="replace")
            except Exception as e:
                text = f"[Could not read file due to: {e}]"
            out.write(text)
            out.write("\n")  # newline for spacing between files

if __name__ == "__main__":
    project_root = Path(".").resolve()      # Laravel project root
    output_path = Path("all_files.txt")     # Output file name
    collect_files(project_root, output_path)
    print(f"Done. Wrote to {output_path}")