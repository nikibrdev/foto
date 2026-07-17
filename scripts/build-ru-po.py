#!/usr/bin/env python3
"""Build languages/ru_RU.po from languages/studio-frame.pot using the
translation dictionary in scripts/translations-ru.py, then compile it to
languages/ru_RU.mo (no msgfmt available in this environment, so this
implements the minimal GNU MO binary format by hand).
"""
import os
import re
import struct
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from translations_ru import TRANSLATIONS, CONTEXTUAL, PLURALS  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
POT_PATH = os.path.join(ROOT, 'languages', 'studio-frame.pot')
PO_PATH = os.path.join(ROOT, 'languages', 'ru_RU.po')
MO_PATH = os.path.join(ROOT, 'languages', 'ru_RU.mo')


def parse_pot(path):
    with open(path, encoding='utf-8') as f:
        content = f.read()

    blocks = content.split('\n\n')
    entries = []
    for block in blocks:
        lines = block.splitlines()
        if not lines:
            continue
        refs = []
        comment = None
        context = None
        msgid = None
        plural = None
        i = 0
        while i < len(lines):
            line = lines[i]
            if line.startswith('#:'):
                refs.append(line[2:].strip())
            elif line.startswith('#.'):
                comment = line[2:].strip()
            elif line.startswith('msgctxt '):
                context = php_like_unquote(line[len('msgctxt '):])
            elif line.startswith('msgid_plural '):
                plural = php_like_unquote(line[len('msgid_plural '):])
            elif line.startswith('msgid '):
                msgid = php_like_unquote(line[len('msgid '):])
            i += 1
        if msgid is None:
            continue
        entries.append({
            'context': context,
            'msgid': msgid,
            'plural': plural,
            'refs': refs,
            'comment': comment,
        })
    return entries


def php_like_unquote(s):
    s = s.strip()
    if not s.startswith('"'):
        return s
    return s[1:-1].replace('\\n', '\n').replace('\\"', '"').replace('\\\\', '\\')


def po_escape(s):
    return s.replace('\\', '\\\\').replace('"', '\\"').replace('\n', '\\n"\n"')


def translate(entry):
    if entry['msgid'] == '':
        return None
    if entry['context'] and (entry['context'], entry['msgid']) in CONTEXTUAL:
        return CONTEXTUAL[(entry['context'], entry['msgid'])]
    if entry['msgid'] in TRANSLATIONS:
        return TRANSLATIONS[entry['msgid']]
    return None


def write_po(entries, path):
    lines = []
    lines.append('msgid ""')
    lines.append('msgstr ""')
    lines.append('"Project-Id-Version: Studio Frame 1.0.0\\n"')
    lines.append('"Report-Msgid-Bugs-To: \\n"')
    lines.append('"MIME-Version: 1.0\\n"')
    lines.append('"Content-Type: text/plain; charset=UTF-8\\n"')
    lines.append('"Content-Transfer-Encoding: 8bit\\n"')
    lines.append('"Language: ru_RU\\n"')
    lines.append('"Plural-Forms: nplurals=3; plural=(n%10==1 && n%100!=11) ? 0 : ((n%10>=2 && n%10<=4 && (n%100<12 || n%100>14)) ? 1 : 2);\\n"')
    lines.append('"X-Domain: studio-frame\\n"')
    lines.append('')

    translated_count = 0
    untranslated = []

    for e in entries:
        if e['msgid'] == '':
            continue
        translation = translate(e)
        if e['plural'] and e['msgid'] in PLURALS:
            translation = True  # counted as translated below; see msgstr[n] handling
        if e['refs']:
            lines.append('#: ' + ' '.join(e['refs']))
        if e['comment']:
            lines.append('#. translators: ' + e['comment'])
        if e['context']:
            lines.append(f'msgctxt "{po_escape(e["context"])}"')
        lines.append(f'msgid "{po_escape(e["msgid"])}"')
        if e['plural']:
            lines.append(f'msgid_plural "{po_escape(e["plural"])}"')
            forms = PLURALS.get(e['msgid'])
            if forms:
                for i, form in enumerate(forms):
                    lines.append(f'msgstr[{i}] "{po_escape(form)}"')
            else:
                lines.append('msgstr[0] ""')
                lines.append('msgstr[1] ""')
                lines.append('msgstr[2] ""')
        else:
            lines.append(f'msgstr "{po_escape(translation) if translation else ""}"')
        lines.append('')

        if translation:
            translated_count += 1
        else:
            untranslated.append(e['msgid'])

    with open(path, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))

    return translated_count, len(entries) - 1, untranslated  # -1 for header block skipped above? entries excludes header already


def compile_mo(po_path, mo_path):
    """Minimal PO -> MO compiler (GNU gettext binary MO format)."""
    with open(po_path, encoding='utf-8') as f:
        content = f.read()

    # Split into entry blocks separated by blank lines.
    raw_blocks = re.split(r'\n\s*\n', content)
    catalog = {}
    for block in raw_blocks:
        if not block.strip():
            continue
        context = None
        msgid_parts = []
        msgstr_parts = []
        plural_parts = {}
        mode = None
        for line in block.splitlines():
            line = line.rstrip()
            if line.startswith('#'):
                continue
            m = re.match(r'^msgctxt\s+"(.*)"$', line)
            if m:
                context = decode_po_string(m.group(1))
                continue
            m = re.match(r'^msgid\s+"(.*)"$', line)
            if m:
                mode = 'msgid'
                msgid_parts = [decode_po_string(m.group(1))]
                continue
            m = re.match(r'^msgid_plural\s+"(.*)"$', line)
            if m:
                mode = 'msgid_plural'
                msgid_parts.append('\x00' + decode_po_string(m.group(1)))
                continue
            m = re.match(r'^msgstr\s+"(.*)"$', line)
            if m:
                mode = 'msgstr'
                msgstr_parts = [decode_po_string(m.group(1))]
                continue
            m = re.match(r'^msgstr\[(\d+)\]\s+"(.*)"$', line)
            if m:
                idx = int(m.group(1))
                mode = f'msgstr[{idx}]'
                plural_parts[idx] = decode_po_string(m.group(2))
                continue
            m = re.match(r'^"(.*)"$', line)
            if m:
                text = decode_po_string(m.group(1))
                if mode == 'msgid':
                    msgid_parts[-1] += text
                elif mode == 'msgid_plural':
                    msgid_parts[-1] += text
                elif mode == 'msgstr':
                    msgstr_parts[-1] += text
                elif mode and mode.startswith('msgstr['):
                    idx = int(mode[len('msgstr['):-1])
                    plural_parts[idx] += text
                continue

        if not msgid_parts:
            continue

        key = ''.join(msgid_parts)
        if context:
            key = context + '\x04' + key

        if plural_parts:
            value = '\x00'.join(plural_parts[i] for i in sorted(plural_parts))
        else:
            value = ''.join(msgstr_parts)

        if key == '':
            # header block
            catalog[''] = value
            continue

        if value:
            catalog[key] = value

    keys = sorted(catalog.keys())
    offsets = []
    ids = b''
    strs = b''
    for key in keys:
        value = catalog[key]
        key_b = key.encode('utf-8')
        value_b = value.encode('utf-8')
        offsets.append((len(ids), len(key_b), len(strs), len(value_b)))
        ids += key_b + b'\x00'
        strs += value_b + b'\x00'

    keystart = 7 * 4 + 16 * len(keys)
    valuestart = keystart + len(ids)

    koffsets = []
    voffsets = []
    for o1, l1, o2, l2 in offsets:
        koffsets.append((l1, o1 + keystart))
        voffsets.append((l2, o2 + valuestart))

    output = struct.pack('Iiiiiii',
                          0x950412de,  # magic
                          0,  # version
                          len(keys),  # number of entries
                          7 * 4,  # start of key index
                          7 * 4 + len(keys) * 8,  # start of value index
                          0, 0)  # hash table size, offset (unused)

    output_koffsets = b''.join(struct.pack('Ii', l, o) for l, o in koffsets)
    output_voffsets = b''.join(struct.pack('Ii', l, o) for l, o in voffsets)

    output += output_koffsets + output_voffsets + ids + strs

    with open(mo_path, 'wb') as f:
        f.write(output)


def decode_po_string(s):
    return (
        s.replace('\\n', '\n')
        .replace('\\t', '\t')
        .replace('\\"', '"')
        .replace('\\\\', '\\')
    )


if __name__ == '__main__':
    entries = parse_pot(POT_PATH)
    translated, total, missing = write_po(entries, PO_PATH)
    compile_mo(PO_PATH, MO_PATH)
    print(f'ru_RU.po: {translated}/{total} strings translated')
    if missing:
        print(f'{len(missing)} untranslated (fall back to English on ru_RU):')
        for m in missing[:50]:
            print('  -', m[:80])
