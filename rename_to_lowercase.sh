#!/bin/bash

# Script to rename files and directories to lowercase in the current directory
# Excludes README.md files as they are allowed to have uppercase letters

# Function to process each file or directory
rename_to_lowercase() {
    local path="$1"
    
    # Get the directory and base name
    local dirname=$(dirname -- "$path")
    local basename=$(basename -- "$path")
    
    # Skip if already lowercase or is README.md
    if [[ "$basename" =~ [A-Z] ]] && [[ "$basename" != "README.md" ]]; then
        # Convert to lowercase
        local newname=$(echo "$basename" | tr '[:upper:]' '[:lower:]')
        local newpath="$dirname/$newname"
        
        # Only rename if the new name is different
        if [ "$path" != "$newpath" ]; then
            # Check if target already exists
            if [ -e "$newpath" ] && [ "$path" != "$newpath" ]; then
                echo "Skipping: $path -> $newpath (already exists)"
            else
                echo "Renaming: $path -> $newpath"
                mv -n -- "$path" "$newpath"
            fi
        fi
    fi
}

export -f rename_to_lowercase

# First, process directories (depth-first)
find . -depth -type d -exec bash -c 'rename_to_lowercase "$0"' {} \;

# Then, process files
find . -type f -not -path "*/node_modules/*" -not -path "*/vendor/*" -not -path "*/.git/*" | while read -r file; do
    rename_to_lowercase "$file"
done

echo "Renaming complete!"
