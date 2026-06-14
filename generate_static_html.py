from pathlib import Path
root = Path(__file__).resolve().parent
pairs = [
    ('page/utama.php', 'page/utama.html'),
    ('page/statistik.php', 'page/statistik.html'),
]
for php_name, html_name in pairs:
    src = root / php_name
    dst = root / html_name
    text = src.read_text(encoding='utf-8')
    if text.startswith('<?php'):
        lines = text.splitlines()
        idx = 0
        while idx < len(lines) and (
            lines[idx].strip().startswith('<?php') or
            lines[idx].strip().startswith('session_start') or
            lines[idx].strip() == '?>'
        ):
            idx += 1
        text = '\n'.join(lines[idx:])
    if php_name == 'page/utama.php':
        text = text.replace('href="statistik.php"', 'href="statistik.html"')
        text = text.replace('href="page/utama.php"', 'href="page/utama.html"')
    else:
        text = text.replace('href="utama.php"', 'href="utama.html"')
    dst.write_text(text, encoding='utf-8')
print('Static HTML generated:')
for _, html_name in pairs:
    print('-', html_name)