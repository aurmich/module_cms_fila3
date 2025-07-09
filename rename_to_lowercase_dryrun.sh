#!/bin/bash

# Dry-run version of the script to preview filename changes
# This script will only show what would be renamed, without making any actual changes

# Function to process each file or directory
dry_run_rename() {
    local path="$1"
    
    # Get the directory and base name
    local dirname=$(dirname -- "$path")
    local basename=$(basename -- "$path")
    
    # Skip if already lowercase or is README.md
    if [[ "$basename" =~ [A-Z] ]] && [[ "$basename" != "README.md" ]]; then
        # Convert to lowercase
        local newname=$(echo "$basename" | tr '[:upper:]' '[:lower:]')
        local newpath="$dirname/$newname"
        
        # Only show if the new name is different
        if [ "$path" != "$newpath" ]; then
            # Check if target already exists
            if [ -e "$newpath" ] && [ "$path" != "$newpath" ]; then
                echo "[SKIP] Would skip: $path -> $newpath (already exists)"
            else
                echo "[RENAME] Would rename: $path -> $newpath"
            fi
        fi
    fi
}

export -f dry_run_rename

echo "=== DRY RUN MODE ==="
echo "This is a preview of the changes that would be made."
echo "No actual files or directories will be modified.\n"

# First, process directories (depth-first)
find . -depth -type d -exec bash -c 'dry_run_rename "$0"' {} \;

# Then, process files
find . -type f -not -path "*/node_modules/*" -not -path "*/vendor/*" -not -path "*/.git/*" | while read -r file; do
    dry_run_rename "$file"
done

echo "\n=== DRY RUN COMPLETE ==="
echo "To apply these changes, run: ./rename_to_lowercase.sh"
