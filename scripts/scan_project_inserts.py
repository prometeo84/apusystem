#!/usr/bin/env python3
"""
Scan repository folders for SQL/JS/PHP scripts that contain INSERT statements
targeting the projects/proyectos table. Helps identify fixture or import files
that could have created projects bypassing application limits.
"""
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SEARCH_PATHS = ['database', 'migrations', 'scripts']
PATTERNS = [re.compile(r"INSERT\s+INTO\s+`?(proyectos|projects)`?", re.I),
            re.compile(r"INSERT\s+INTO\s+.*\bproyectos\b", re.I),
            re.compile(r"INSERT\s+INTO\s+.*\bprojects\b", re.I)]

def scan():
    hits = []
    for sub in SEARCH_PATHS:
        folder = ROOT / sub
        if not folder.exists():
            continue
        for p in folder.rglob('*'):
            if p.is_file():
                try:
                    text = p.read_text(encoding='utf-8', errors='ignore')
                except Exception:
                    continue
                for pat in PATTERNS:
                    if pat.search(text):
                        hits.append(str(p.relative_to(ROOT)))
                        break
    return sorted(hits)

def main():
    hits = scan()
    if not hits:
        print('No candidate insert files found in database/migrations/scripts.')
        return
    print('Potential files inserting projects:')
    for h in hits:
        print(' -', h)
    print('\nReview these files and confirm whether they were executed in target environments.')

if __name__ == '__main__':
    main()
