#!/bin/bash

# Script to rename files and directories to lowercase in all docs directories
# Excludes README.md files as they are allowed to have uppercase letters

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
                    echo "  Warning: $newpath already exists. Skipping rename of $dir"
                else
                    # Rename the directory
                    echo "  Renaming directory: $dir -> $newpath"
                    mv -n -- "$dir" "$newpath" || echo "  Failed to rename $dir to $newpath"
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
                    echo "  Warning: $newfilepath already exists. Skipping rename of $file"
                else
                    # Rename the file
                    echo "  Renaming file: $file -> $newfilepath"
                    mv -n -- "$file" "$newfilepath" || echo "  Failed to rename $file to $newfilepath"
                fi
            fi
        fi
    done
    
    echo "  Completed processing: $dir"
    echo ""
}

# Set the base directory
PROJECT_ROOT="/var/www/html/_bases/base_saluteora"

# Find all docs and _docs directories
find "$PROJECT_ROOT" -type d \( -name "docs" -o -name "_docs" \) | while read -r docs_dir; do
    echo "Processing directory: $docs_dir"
    process_directory "$docs_dir"
done

echo "Renaming complete across all docs directories!"
