import os
import re

files = [
    "dashboard.blade.php",
    "calender_planning.blade.php",
    "pest_detection_alert.blade.php",
    "market_price.blade.php",
    "ai_reccomendation.blade.php"
]

base_path = "resources/views/pages/"

standard_class = 'class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6"'

for file in files:
    filepath = os.path.join(base_path, file)
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            content = f.read()
        
        # Replace the <main> tag class
        new_content = re.sub(
            r'<main\s+class="[^"]+"\s*>', 
            f'<main {standard_class}>', 
            content, 
            count=1
        )
        
        if new_content != content:
            with open(filepath, "w", encoding="utf-8") as f:
                f.write(new_content)
            print(f"Updated {file}")
        else:
            print(f"No changes for {file}")
