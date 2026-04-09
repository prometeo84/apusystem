#!/usr/bin/env python3
import re
from pathlib import Path

TEMPLATES = list(Path('templates').rglob('*.twig'))
modified = []
for p in TEMPLATES:
    s = p.read_text(encoding='utf-8')
    orig = s
    changed = False
    # fix href: '{{ path(...) }}' -> href: path(...)
    def href_repl(m):
        key_quote = m.group('kq')
        key = m.group('k')
        expr = m.group('expr')
        return f"{key_quote}{key}{key_quote}: {expr}"

    s = re.sub(r"(?P<kq>['\"]) (?P<k>href) (?P=kq) \s*:\s*(?P<vq>['\"])\s*\{\{\s*(?P<expr>path\([^}]+\))\s*\}\}\s*(?P=vq)", href_repl, s, flags=re.VERBOSE)

    # if still exists different quote spacing, try looser pattern
    s = re.sub(r"(href)\s*:\s*['\"]\s*\{\{\s*(path\([^}]+\))\s*\}\}\s*['\"]", lambda m: f"'href': {m.group(2)}", s)

    # add import if btn.button used but import missing
    if 'btn.button(' in s and "import 'partials/_button.html.twig' as btn" not in s and '{% import ' not in s:
        # prefer inserting after {% block body %}
        if '{% block body %}' in s:
            s = s.replace('{% block body %}', "{% block body %}\n{% import 'partials/_button.html.twig' as btn %}")
            changed = True
        else:
            # fallback: after the first extends or at top
            if s.startswith('{% extends'):
                parts = s.split('\n', 1)
                s = parts[0] + '\n' + "{% import 'partials/_button.html.twig' as btn %}\n" + parts[1]
                changed = True
    # also handle cases where import exists but commented or uses different path - skip

    if s != orig:
        backup = p.with_suffix(p.suffix + '.bak')
        if not backup.exists():
            backup.write_text(orig, encoding='utf-8')
        p.write_text(s, encoding='utf-8')
        modified.append(str(p))

print('Modified files:', len(modified))
for m in modified:
    print(m)
