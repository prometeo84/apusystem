#!/usr/bin/env python3
"""
Scan codebase for translation key usage and compare against defined keys in translations/*.yaml
Reports missing keys used in templates/code and unused keys defined in translation files.

Usage: python3 scripts/check_translations.py
"""
import re
import yaml
from pathlib import Path
from collections import defaultdict

ROOT = Path(__file__).resolve().parents[1]
SEARCH_EXTS = ['.twig', '.php', '.js']
TRANSLATION_FILES = list((ROOT / 'translations').glob('messages.*.yaml'))

def load_defined_keys():
    keys = set()
    for f in TRANSLATION_FILES:
        try:
            data = yaml.safe_load(f.read_text(encoding='utf-8')) or {}
            for k in data.keys():
                keys.add(k)
        except Exception:
            continue
    return keys

def find_used_keys():
    # patterns: trans('key'), ->trans('key'), {{ 'key'|trans }}, t('key') etc.
    patterns = [
        re.compile(r"trans\(\s*'([a-zA-Z0-9_.-]+)'\s*\)"),
        re.compile(r"trans\(\s*\"([a-zA-Z0-9_.-]+)\"\s*\)"),
        re.compile(r"\|trans"),
        re.compile(r"\{\{\s*'([a-zA-Z0-9_.-]+)'\s*\|\s*trans"),
        re.compile(r"__\(\s*'([a-zA-Z0-9_.-]+)'\s*\)"),
    ]

    used = set()
    files_with_pipe_trans = []
    for p in ROOT.rglob('*'):
        if p.suffix.lower() in SEARCH_EXTS:
            try:
                txt = p.read_text(encoding='utf-8', errors='ignore')
            except Exception:
                continue
            for pat in patterns:
                for m in pat.finditer(txt):
                    if pat.pattern == "\\|trans":
                        files_with_pipe_trans.append(str(p.relative_to(ROOT)))
                    else:
                        used.add(m.group(1))
    # For pipe trans usages, we cannot always recover key (dynamic), so report files
    return used, files_with_pipe_trans

def main():
    print('Loading defined translation keys...')
    defined = load_defined_keys()
    print(f'Found {len(defined)} defined keys across {len(TRANSLATION_FILES)} files.')

    print('Scanning source for used translation keys...')
    used, pipe_files = find_used_keys()
    print(f'Found {len(used)} literal keys used and {len(pipe_files)} files using pipe-trans.')

    missing = sorted([k for k in used if k not in defined])
    unused = sorted([k for k in defined if k not in used])

    if missing:
        print('\nMissing translation keys (used but not defined):')
        for k in missing:
            print(' -', k)
    else:
        print('\nNo missing literal keys found.')

    print('\nFiles using pipe |trans (requires manual check):')
    for f in pipe_files[:200]:
        print(' -', f)

    print('\nDefined keys not observed as literal usage (possible unused or only dynamic):')
    for k in unused[:200]:
        print(' -', k)

if __name__ == '__main__':
    main()
#!/usr/bin/env python3
import re
import os
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SEARCH_EXTS = ['.twig', '.php', '.js', '.jsx', '.ts', '.vue', '.html']

KEY_PATTERNS = [
    re.compile(r"['\"]([A-Za-z0-9_.:-]+)['\"]\s*\|\s*trans"),
    re.compile(r"trans\(\s*['\"]([A-Za-z0-9_.:-]+)['\"]"),
    re.compile(r"__\(\s*['\"]([A-Za-z0-9_.:-]+)['\"]"),
    re.compile(r"t\(\s*['\"]([A-Za-z0-9_.:-]+)['\"]"),
]

def find_keys():
    keys = set()
    for p in ROOT.rglob('*'):
        if p.suffix.lower() in SEARCH_EXTS:
            try:
                text = p.read_text(encoding='utf-8')
            except Exception:
                continue
            for pat in KEY_PATTERNS:
                for m in pat.findall(text):
                    keys.add(m)
    return keys

def read_yaml(path: Path):
    try:
        return path.read_text(encoding='utf-8')
    except Exception:
        return ''

def nested_exists(dotkey: str, content: str) -> bool:
    # fast path: dotted key literal
    if dotkey in content:
        return True
    parts = dotkey.split('.')
    lines = content.splitlines()
    for i, line in enumerate(lines):
        if line.strip().startswith(parts[0] + ':'):
            indent = len(line) - len(line.lstrip())
            # search subsequent lines for nested parts
            j = i + 1
            found = True
            for part in parts[1:]:
                found_part = False
                while j < len(lines):
                    linej = lines[j]
                    indentj = len(linej) - len(linej.lstrip())
                    if indentj <= indent:
                        break
                    if linej.strip().startswith(part + ':'):
                        # go deeper
                        indent = indentj
                        j += 1
                        found_part = True
                        break
                    j += 1
                if not found_part:
                    found = False
                    break
            if found:
                return True
    return False

def main():
    keys = sorted(find_keys())
    print(f"Found {len(keys)} translation-like keys in code/templates")
    en = read_yaml(ROOT / 'translations' / 'messages.en.yaml')
    es = read_yaml(ROOT / 'translations' / 'messages.es.yaml')

    missing_en = []
    missing_es = []
    for k in keys:
        if not nested_exists(k, en):
            missing_en.append(k)
        if not nested_exists(k, es):
            missing_es.append(k)

    print('\nMissing in English (messages.en.yaml):')
    for k in missing_en:
        print('  -', k)

    print('\nMissing in Spanish (messages.es.yaml):')
    for k in missing_es:
        print('  -', k)

    # Show whether our target keys are present
    targets = ['new-item-link', 'auth.reauth', 'auth.reauth_prompt', 'auth.confirm']
    print('\nTarget keys check:')
    for t in targets:
        print(f"  {t}: EN={'yes' if nested_exists(t,en) else 'NO'}; ES={'yes' if nested_exists(t,es) else 'NO'}")

if __name__ == '__main__':
    main()
