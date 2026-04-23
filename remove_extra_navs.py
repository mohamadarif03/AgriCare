import os
import glob
import re

files = glob.glob('resources/views/pages/*.blade.php')

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Remove any `<nav ...>...</nav>` block
    new_content = re.sub(r'<!-- BottomNavBar.*?-->\s*<nav\b[^>]*>.*?</nav>', '', content, flags=re.DOTALL)
    new_content = re.sub(r'<nav\b[^>]*>.*?</nav>', '', new_content, flags=re.DOTALL)
    
    if new_content != content:
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Removed nav from {file}")
