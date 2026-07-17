#!/usr/bin/env python3
"""
Minimal WordPress i18n string extractor (no gettext/wp-cli available in this
environment). Scans theme PHP files for __()/_e()/esc_html__()/esc_html_e()/
esc_attr__()/esc_attr_e()/_x()/_ex()/_n() calls with the 'studio-frame' text
domain and writes languages/studio-frame.pot.

Not a full PHP parser — good enough for this theme's straightforward,
single-line-ish translation calls. Re-run after adding new __()/_e() calls.
"""
import os
import re
import sys
from datetime import datetime, timezone

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
EXCLUDE_DIRS = {'legacy-verstka', '.git', 'node_modules'}
EXCLUDE_PATH_PARTS = {os.path.join('inc', 'cmb2', 'vendor')}

STR = r"'(?:[^'\\]|\\.)*'|\"(?:[^\"\\]|\\.)*\""

CALL_RE = re.compile(
    r"\b(__|_e|esc_html__|esc_html_e|esc_attr__|esc_attr_e|_x|_ex|_n)\s*\(\s*"
    r"(" + STR + r")"
    r"(?:\s*,\s*(" + STR + r"))?"
    r"(?:\s*,\s*(" + STR + r"))?"
    r"(?:\s*,\s*(" + STR + r"))?"
    r"\s*\)",
    re.DOTALL,
)

COMMENT_RE = re.compile(r"/\*\s*translators:\s*(.*?)\*/", re.DOTALL)

# _n( singular, plural, <count expression, not a string literal>, domain )
NGETTEXT_RE = re.compile(
    r"\b_n\s*\(\s*(" + STR + r")\s*,\s*(" + STR + r")\s*,\s*[^,()]+\s*,\s*(" + STR + r")\s*\)",
    re.DOTALL,
)


def php_unquote(raw):
    raw = raw.strip()
    quote = raw[0]
    body = raw[1:-1]
    if quote == "'":
        return body.replace("\\'", "'").replace('\\\\', '\\')
    # double-quoted: unescape common sequences conservatively
    return (
        body.replace('\\"', '"')
        .replace('\\n', '\n')
        .replace('\\t', '\t')
        .replace('\\\\', '\\')
    )


def find_translator_comment(content, call_start):
    # Look backwards up to 300 chars for a preceding /* translators: ... */
    window = content[max(0, call_start - 400):call_start]
    matches = list(COMMENT_RE.finditer(window))
    if matches:
        return ' '.join(matches[-1].group(1).split())
    return None


def collect():
    entries = {}  # msgid (+context) -> dict(msgid, plural, context, refs, comment)
    for dirpath, dirnames, filenames in os.walk(ROOT):
        rel_dir = os.path.relpath(dirpath, ROOT)
        dirnames[:] = [d for d in dirnames if d not in EXCLUDE_DIRS]
        if any(part in rel_dir.replace('\\', '/') for part in ('inc/cmb2/vendor',)):
            dirnames[:] = []
            continue
        for fn in filenames:
            if not fn.endswith('.php'):
                continue
            path = os.path.join(dirpath, fn)
            relpath = os.path.relpath(path, ROOT).replace('\\', '/')
            if relpath.startswith('inc/cmb2/vendor/'):
                continue
            with open(path, encoding='utf-8') as f:
                content = f.read()

            for m in CALL_RE.finditer(content):
                func = m.group(1)
                arg1 = m.group(2)
                arg2 = m.group(3)
                arg3 = m.group(4)
                arg4 = m.group(5)

                args = [a for a in (arg1, arg2, arg3, arg4) if a is not None]

                if func in ('__', '_e', 'esc_html__', 'esc_html_e', 'esc_attr__', 'esc_attr_e'):
                    if len(args) < 2:
                        continue
                    domain = php_unquote(args[-1])
                    if domain != 'studio-frame':
                        continue
                    msgid = php_unquote(arg1)
                    key = ('', msgid)
                    plural = None
                    context = None
                elif func in ('_x', '_ex'):
                    if len(args) < 3:
                        continue
                    domain = php_unquote(args[-1])
                    if domain != 'studio-frame':
                        continue
                    msgid = php_unquote(arg1)
                    context = php_unquote(arg2)
                    key = (context, msgid)
                    plural = None
                elif func == '_n':
                    if len(args) < 4:
                        continue
                    domain = php_unquote(args[-1])
                    if domain != 'studio-frame':
                        continue
                    msgid = php_unquote(arg1)
                    plural = php_unquote(arg2)
                    key = ('', msgid)
                    context = None
                else:
                    continue

                line_no = content.count('\n', 0, m.start()) + 1
                comment = find_translator_comment(content, m.start())

                if key not in entries:
                    entries[key] = {
                        'msgid': msgid,
                        'plural': plural,
                        'context': context,
                        'refs': [],
                        'comment': comment,
                    }
                entries[key]['refs'].append(f'{relpath}:{line_no}')
                if comment and not entries[key]['comment']:
                    entries[key]['comment'] = comment

            # _n() with a non-literal count expression (the common case)
            # isn't matched by CALL_RE above, so handle it separately.
            for m in NGETTEXT_RE.finditer(content):
                domain = php_unquote(m.group(3))
                if domain != 'studio-frame':
                    continue
                msgid = php_unquote(m.group(1))
                plural = php_unquote(m.group(2))
                key = ('', msgid)
                line_no = content.count('\n', 0, m.start()) + 1
                comment = find_translator_comment(content, m.start())
                if key not in entries:
                    entries[key] = {
                        'msgid': msgid,
                        'plural': plural,
                        'context': None,
                        'refs': [],
                        'comment': comment,
                    }
                entries[key]['refs'].append(f'{relpath}:{line_no}')
                if comment and not entries[key]['comment']:
                    entries[key]['comment'] = comment

    return entries


def pot_escape(s):
    return s.replace('\\', '\\\\').replace('"', '\\"').replace('\n', '\\n"\n"')


def write_pot(entries, out_path):
    now = datetime.now(timezone.utc).strftime('%Y-%m-%d %H:%M+0000')
    lines = []
    lines.append('msgid ""')
    lines.append('msgstr ""')
    lines.append('"Project-Id-Version: Studio Frame 1.0.0\\n"')
    lines.append('"Report-Msgid-Bugs-To: \\n"')
    lines.append(f'"POT-Creation-Date: {now}\\n"')
    lines.append('"MIME-Version: 1.0\\n"')
    lines.append('"Content-Type: text/plain; charset=UTF-8\\n"')
    lines.append('"Content-Transfer-Encoding: 8bit\\n"')
    lines.append('"PO-Revision-Date: \\n"')
    lines.append('"Language-Team: \\n"')
    lines.append('"X-Domain: studio-frame\\n"')
    lines.append('')

    for key in sorted(entries.keys(), key=lambda k: entries[k]['refs'][0]):
        e = entries[key]
        lines.append('#: ' + ' '.join(e['refs']))
        if e['comment']:
            lines.append('#. translators: ' + e['comment'])
        if e['context']:
            lines.append(f'msgctxt "{pot_escape(e["context"])}"')
        lines.append(f'msgid "{pot_escape(e["msgid"])}"')
        if e['plural']:
            lines.append(f'msgid_plural "{pot_escape(e["plural"])}"')
            lines.append('msgstr[0] ""')
            lines.append('msgstr[1] ""')
        else:
            lines.append('msgstr ""')
        lines.append('')

    with open(out_path, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))

    return len(entries)


if __name__ == '__main__':
    entries = collect()
    out = os.path.join(ROOT, 'languages', 'studio-frame.pot')
    os.makedirs(os.path.dirname(out), exist_ok=True)
    count = write_pot(entries, out)
    print(f'Wrote {count} unique strings to {out}')
