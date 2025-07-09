#!/bin/bash

# Dry-run version of the script to preview filename changes
# This script will only show what would be renamed, without making any actual changes

# Function to process each docs directory
process_directory() {
    local dir="$1"
    cd "$dir" || return 1
    
    echo "  - Processing files and directories in: $dir"

    # First, process directories (depth-first to handle nested directories)
    find . -depth -mindepth 1 -type d -print0 | while IFS= read -r -d $'\0' dir; do
        # Skip if already lowercase
        if [[ "$dir" =~ [A-Z] ]]; then
            # Get the directory name and its parent
            dirname=$(basename -- "$dir")
            parentdir=$(dirname -- "$dir")
            
            # Convert to lowercase
            newname=$(echo "$dirname" | tr '[:upper:]' '[:lower:]')
            
            # Only rename if the new name is different
            if [ "$dirname" != "$newname" ]; then
                # Create the new directory path
                newpath="$parentdir/$newname"
                
                # Check if the target already exists
                if [ -e "$newpath" ] && [ "$dir" != "$newpath" ]; then
                    echo "  [SKIP] Directory already exists: $newpath (would rename from: $dir)"
                else
                    echo "  [DRY RUN] Would rename directory: $dir -> $newpath"
                fi
            fi
        fi
    done

    # Then, process files (excluding README.md)
    export LANG=C  # For consistent character handling
    find . -type f -not -path "*/node_modules/*" -not -path "*/vendor/*" -not -path "*/.git/*" -print0 | while IFS= read -r -d $'\0' file; do
        # Skip README.md files
        if [[ "$file" =~ /[^/]*README\.md$ ]]; then
            continue
        fi
        
        # Get the filename and its directory
        filename=$(basename -- "$file")
        dirpath=$(dirname -- "$file")
        
        # Skip if already lowercase
        if [[ "$filename" =~ [A-Z] ]]; then
            # Convert to lowercase
            newfilename=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
            
            # Only rename if the new name is different
            if [ "$filename" != "$newfilename" ]; then
                # Create the new file path
                newfilepath="$dirpath/$newfilename"
                
                # Check if the target already exists
                if [ -e "$newfilepath" ] && [ "$file" != "$newfilepath" ]; then
                    echo "  [SKIP] File already exists: $newfilepath (would rename from: $file)"
                else
                    echo "  [DRY RUN] Would rename file: $file -> $newfilepath"
                fi
            fi
        fi
    done
    
    echo "  Completed dry run for: $dir"
    echo ""
}

# Set the base directory
PROJECT_ROOT="/var/www/html/_bases/base_saluteora"

echo "=== DRY RUN MODE ==="
echo "This is a preview of the changes that would be made."
echo "No actual files or directories will be modified.\n"

# Find all docs and _docs directories
find "$PROJECT_ROOT" -type d \( -name "docs" -o -name "_docs" \) | while read -r docs_dir; do
    echo "Processing directory: $docs_dir"
    process_directory "$docs_dir"
done

echo "=== DRY RUN COMPLETE ==="
echo "To apply these changes, run: bash rename_docs_to_lowercase.sh"
