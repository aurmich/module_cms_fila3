#!/bin/bash

# Script to rename files and directories to lowercase in the docs directory
# Handles spaces and special characters in filenames

# Set the base directory
BASE_DIR="/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs"

# Change to the base directory
cd "$BASE_DIR" || exit 1

# Function to rename a single file/directory to lowercase
rename_to_lowercase() {
    local path="$1"
    local dirname=$(dirname "$path")
    local basename=$(basename "$path")
    
    # Skip if already lowercase or is README.md
    if [[ "$basename" == "README.md" ]] || [[ ! "$basename" =~ [A-Z] ]]; then
        return 0
    fi
    
    # Convert to lowercase
    local newname=$(echo "$basename" | tr '[:upper:]' '[:lower:]')
    
    # Only rename if the new name is different
    if [ "$basename" != "$newname" ]; then
        local newpath="${dirname}/${newname}"
        
        # Check if the target already exists
        if [ -e "$newpath" ] && [ "$path" != "$newpath" ]; then
            echo "Warning: $newpath already exists. Skipping rename of $path"
        else
            # Rename the file/directory
            mv -v "$path" "$newpath"
        fi
    fi
}

export -f rename_to_lowercase

# First, process directories (depth-first to handle nested directories)
find . -depth -type d -print0 | while IFS= read -r -d $'\0' dir; do
    # Skip the current directory
    [ "$dir" = "." ] && continue
    
    # Rename the directory
    rename_to_lowercase "$dir"
done

# Then, process files
find . -type f -print0 | while IFS= read -r -d $'\0' file; do
    # Skip README.md files
    [[ "$(basename "$file")" == "README.md" ]] && continue
    
    # Rename the file
    rename_to_lowercase "$file"
done

echo "Renaming complete!"

# Verify the results
echo "\nVerifying results..."
UPPERCASE_COUNT=$(find . -type f -o -type d | grep -v "README\.md$" | grep -E '[A-Z]' | wc -l)

echo "Found $UPPERCASE_COUNT files/directories with uppercase letters (excluding README.md)"

if [ "$UPPERCASE_COUNT" -gt 0 ]; then
    echo "\nFiles/directories with uppercase letters:"
    find . -type f -o -type d | grep -v "README\.md$" | grep -E '[A-Z]' | head -n 10
    
    if [ "$UPPERCASE_COUNT" -gt 10 ]; then
        echo "... and $((UPPERCASE_COUNT - 10)) more"
    fi
else
    echo "All files and directories are now lowercase!"
fi
