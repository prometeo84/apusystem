#!/usr/bin/env python3
import re
from pathlib import Path

pattern = re.compile(
    "<a\\s+href=\\\"\\{\\{\\s*(path\([^\)]+\))\\s*\\}\\}\\\"\\s+class=\\\"btn\\s+btn-([^\"\\s]+)\\\"[^>]*>\\s*<i\\s+class=\\\"bi\\s+([^\\\"]+)\\\"\\></i>\\s*\\{\\{\\s*'([^']+)'\\s*\\|\\s*trans\\s*\\}\\}\\s*</a>",
    re.DOTALL,
)

pattern_btn = re.compile(
    r"<button([^>]*)class=\"btn\s+btn-([^\"\s]+)\"([^>]*)>\s*<i\s+class=\"bi\s+([^\"]+)\"\></i>\s*\{\{\s*'([^']+)'\s*\|\s*trans\s*\}\}\s*</button>",
    re.DOTALL,
)

pattern_anchor_text = re.compile(
    r"<a\s+href=\"\{\{\s*(path\([^\)]+\))\s*\}\}\"\s+class=\"btn\s+btn-([^\"\s]+)\"[^>]*>\s*\{\{\s*'([^']+)'\s*\|\s*trans\s*\}\}\s*</a>",
    re.DOTALL,
)

pattern_button_text = re.compile(
    r"<button([^>]*)class=\"btn\s+btn-([^\"\s]+)\"([^>]*)>\s*\{\{\s*'([^']+)'\s*\|\s*trans\s*\}\}\s*</button>",
    re.DOTALL,
)

pattern_anchor_icon_title = re.compile(
    r"<a\s+href=\"\{\{\s*(path\([^\)]+\))\s*\}\}\"\s+class=\"btn\s+btn-([^\"\s]+)\"[^>]*title=\"\{\{\s*'([^']+)'\s*\|\s*trans\s*\}\}\"[^>]*>\s*<i\s+class=\"bi\s+([^\"]+)\"\s*>\s*</i>\s*</a>",
    re.DOTALL,
)

files = list(Path('templates').rglob('*.twig'))
count = 0
def _replace_button(m):
    before_attrs = (m.group(1) or '') + (m.group(3) or '')
    attrs = {}
    if 'type="submit"' in before_attrs:
        attrs['type'] = 'submit'
    # build attrs string
    if attrs:
        attrs_str = ", ".join([f"'{k}':'{v}'" for k, v in attrs.items()])
        attrs_str = '{' + attrs_str + '}'
    else:
        attrs_str = '{}'
    return "{{ btn.button('%s'|trans, '%s', 'bi-%s', %s) }}" % (m.group(5), m.group(2), m.group(4), attrs_str)

def _replace_button_text(m):
    before_attrs = (m.group(1) or '') + (m.group(3) or '')
    attrs = {}
    if 'type="submit"' in before_attrs:
        attrs['type'] = 'submit'
    if attrs:
        attrs_str = ", ".join([f"'{k}':'{v}'" for k, v in attrs.items()])
        attrs_str = '{' + attrs_str + '}'
    else:
        attrs_str = '{}'
    return "{{ btn.button('%s'|trans, '%s', null, %s) }}" % (m.group(4), m.group(2), attrs_str)

def _process_anchor_aggressive(p, s):
    """Process any <a ... class='... btn ...'>...</a> occurrence in the file content and replace conservatively."""
    anchor_any = re.compile(r"<a\s+([^>]*\bclass=[\"'][^\"']*\bbtn\b[^\"']*[\"'][^>]*)>(.*?)</a>", re.DOTALL)
    def repl(m):
        attrs_raw = m.group(1)
        inner = m.group(2).strip()
        # parse attributes into dict: key -> (type, value)
        attrs = {}
        for am in re.finditer(r"(\w+)=(?:\"([^\"]*)\"|'([^']*)'|\{\{\s*(.*?)\s*\}\})", attrs_raw):
            k = am.group(1)
            v = am.group(2) or am.group(3) or am.group(4)
            is_twig = bool(am.group(4))
            attrs[k] = (is_twig, v)

        # determine variant from class attribute
        cls_match = re.search(r"class=[\"']([^\"']*)[\"']", attrs_raw)
        variant = 'primary'
        extras = []
        variant_class = None
        if cls_match:
            classes = cls_match.group(1).split()
            for c in classes:
                if c.startswith('btn-') and c not in ('btn-sm','btn-lg','btn-block'):
                    variant_class = c
                    variant = c.replace('btn-','')
                    break
            extras = [c for c in classes if c != 'btn' and c != variant_class]

        # extract icon if present
        icon = None
        icon_m = re.search(r"<i\s+class=[\"'][^\"']*bi-([^\"'\s]*)", inner)
        if icon_m:
            icon = 'bi-' + icon_m.group(1)

        # extract label: prefer a Twig trans expression inside inner
        label_expr = "''"
        twig_label_m = re.search(r"\{\{\s*(.*?)\s*\}\}", inner)
        if twig_label_m:
            label_expr = twig_label_m.group(1)
        else:
            # strip tags
            text_only = re.sub(r'<[^>]+>', '', inner).strip()
            if text_only:
                label_expr = repr(text_only)

        # build attrs dict for macro
        macro_attrs_items = []
        for k, (is_twig, v) in attrs.items():
            if k == 'class':
                continue
            if k == 'href':
                # href value may be a twig expression or literal; if literal keep quoted
                if is_twig:
                    macro_attrs_items.append(f"'{k}': {v}")
                else:
                    macro_attrs_items.append(f"'{k}': '{v}'")
            else:
                if is_twig:
                    macro_attrs_items.append(f"'{k}': {v}")
                else:
                    macro_attrs_items.append(f"'{k}': '{v}'")

        if macro_attrs_items:
            macro_attrs = '{' + ', '.join(macro_attrs_items) + '}'
        else:
            macro_attrs = '{}'
        # include extras classes (btn-sm, active, etc.) so macro can merge them into final classes
        if extras:
            extras_str = ' '.join(extras)
            if macro_attrs == '{}':
                macro_attrs = "{" + f"'class':'{extras_str}'" + "}"
            else:
                # insert before the closing '}'
                macro_attrs = macro_attrs[:-1] + f", 'class':'{extras_str}'}}"

        icon_param = f"'{icon}'" if icon else 'null'
        replacement = "{{ btn.button(%s, '%s', %s, %s) }}" % (label_expr, variant, icon_param, macro_attrs)
        return replacement

    new_s, n = anchor_any.subn(repl, s)
    if n:
        backup = p.with_suffix(p.suffix + '.bak')
        if not backup.exists():
            backup.write_text(s, encoding='utf-8')
        p.write_text(new_s, encoding='utf-8')
    return n
for p in files:
    s = p.read_text(encoding='utf-8')
    new_s, n = pattern.subn(lambda m: "{{ btn.button('%s'|trans, '%s', 'bi-%s', {'href': path('%s')}) }}" % (m.group(4), m.group(2), m.group(3), m.group(1)), s)
    if n:
        backup = p.with_suffix(p.suffix + '.bak')
        backup.write_text(s, encoding='utf-8')
        p.write_text(new_s, encoding='utf-8')
        count += n
        print(f"Patched {p} -> {n} replacements")
    # handle <button ...> with icon + trans
    new_s2, n2 = pattern_btn.subn(lambda m: _replace_button(m), new_s)
    if n2:
        # if not already backed up above
        if not p.with_suffix(p.suffix + '.bak').exists():
            backup = p.with_suffix(p.suffix + '.bak')
            backup.write_text(s, encoding='utf-8')
        p.write_text(new_s2, encoding='utf-8')
        count += n2
        print(f"Patched {p} -> {n2} button replacements")
    # handle <a ...> with only trans text
    new_s3, n3 = pattern_anchor_text.subn(lambda m: "{{ btn.button('%s'|trans, '%s', null, {'href': path('%s')}) }}" % (m.group(3), m.group(2), m.group(1)), new_s2)
    if n3:
        if not p.with_suffix(p.suffix + '.bak').exists():
            backup = p.with_suffix(p.suffix + '.bak')
            backup.write_text(s, encoding='utf-8')
        p.write_text(new_s3, encoding='utf-8')
        count += n3
        print(f"Patched {p} -> {n3} anchor-text replacements")
    # handle <button ...> with only trans text
    new_s4, n4 = pattern_button_text.subn(lambda m: _replace_button_text(m), new_s3)
    if n4:
        if not p.with_suffix(p.suffix + '.bak').exists():
            backup = p.with_suffix(p.suffix + '.bak')
            backup.write_text(s, encoding='utf-8')
        p.write_text(new_s4, encoding='utf-8')
        count += n4
        print(f"Patched {p} -> {n4} button-text replacements")
    # handle <a ... title="{{ 'key'|trans }}"> <i class="bi ..."></i> </a>
    new_s5, n5 = pattern_anchor_icon_title.subn(lambda m: "{{ btn.button('%s'|trans, '%s', 'bi-%s', {'href': path('%s')}) }}" % (m.group(3), m.group(2), m.group(4), m.group(1)), new_s4)
    if n5:
        if not p.with_suffix(p.suffix + '.bak').exists():
            backup = p.with_suffix(p.suffix + '.bak')
            backup.write_text(s, encoding='utf-8')
        p.write_text(new_s5, encoding='utf-8')
        count += n5
        print(f"Patched {p} -> {n5} anchor-icon-title replacements")

    # aggressive pass: any <a ... class='... btn ...'>
    n6 = _process_anchor_aggressive(p, new_s5)
    if n6:
        count += n6
        print(f"Patched {p} -> {n6} aggressive anchor replacements")

print(f"Total replacements: {count}")
def _replace_button_text(m):
    before_attrs = (m.group(1) or '') + (m.group(3) or '')
    attrs = {}
    if 'type="submit"' in before_attrs:
        attrs['type'] = 'submit'
    if attrs:
        attrs_str = ", ".join([f"'{k}':'{v}'" for k, v in attrs.items()])
        attrs_str = '{' + attrs_str + '}'
    else:
        attrs_str = '{}'
    return "{{ btn.button('%s'|trans, '%s', null, %s) }}" % (m.group(4), m.group(2), attrs_str)
