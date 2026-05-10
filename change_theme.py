import os
import re

dir_path = r'd:\TaniPintarHITech\resources\views'
files_changed = 0

for root, dirs, files in os.walk(dir_path):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            new_content = content
            
            # Replace tailwind green utilities with blue
            new_content = re.sub(r'green-(\d{2,3})', r'blue-\1', new_content)
            
            # Replace custom MD3 config colors (login, index, register, app)
            new_content = new_content.replace('"primary": "#0280F9"', '"primary": "#0280F9"')
            new_content = new_content.replace('"primary-container": "#2e8534"', '"primary-container": "#d0e4ff"')
            new_content = new_content.replace('"on-primary-container": "#f7fff1"', '"on-primary-container": "#001d36"')
            
            new_content = new_content.replace('"primary-fixed": "#9df898"', '"primary-fixed": "#d0e4ff"')
            new_content = new_content.replace('"on-primary-fixed": "#002204"', '"on-primary-fixed": "#001d36"')
            new_content = new_content.replace('"primary-fixed-dim": "#82db7e"', '"primary-fixed-dim": "#9bcaea"')
            new_content = new_content.replace('"on-primary-fixed-variant": "#005312"', '"on-primary-fixed-variant": "#00497b"')
            new_content = new_content.replace('"inverse-primary": "#82db7e"', '"inverse-primary": "#9bcaea"')
            new_content = new_content.replace('"surface-tint": "#106d20"', '"surface-tint": "#0280F9"')
            
            new_content = new_content.replace('"background": "#f6fbf0"', '"background": "#fdfbff"')
            new_content = new_content.replace('"surface": "#f6fbf0"', '"surface": "#fdfbff"')
            new_content = new_content.replace('"surface-bright": "#f6fbf0"', '"surface-bright": "#fdfbff"')
            
            new_content = new_content.replace('"surface-container-low": "#f0f5ea"', '"surface-container-low": "#f3f3fa"')
            new_content = new_content.replace('"surface-container": "#ebf0e5"', '"surface-container": "#edf0f7"')
            new_content = new_content.replace('"surface-container-high": "#e5eadf"', '"surface-container-high": "#e7eaef"')
            new_content = new_content.replace('"surface-container-highest": "#dfe4d9"', '"surface-container-highest": "#e1e4e9"')
            new_content = new_content.replace('"surface-variant": "#dfe4d9"', '"surface-variant": "#dfe2eb"')
            new_content = new_content.replace('"surface-dim": "#d7dcd1"', '"surface-dim": "#d8dae0"')

            if new_content != content:
                with open(path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                files_changed += 1

print(f"Changed theme colors in {files_changed} files.")
