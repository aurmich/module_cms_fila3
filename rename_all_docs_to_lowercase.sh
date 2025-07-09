#!/bin/bash

# Script to rename all files and directories in docs folders to lowercase
# Excludes README.md files and vendor directories

# Set the base directory
BASE_DIR="/var/www/html/_bases/base_saluteora"

# Log file for the operation
LOG_FILE="$BASE_DIR/docs_rename_log.txt"

# Function to rename a single file/directory to lowercase
rename_to_lowercase() {
    local path="$1"
    local dirname=$(dirname "$path")
    local basename=$(basename "$path")
    
    # Skip README.md files
    if [[ "$basename" == "README.md" ]]; then
        return 0
    fi
    
    # Skip if already lowercase
    if [[ ! "$basename" =~ [A-Z] ]]; then
        return 0
    fi
    
    # Convert to lowercase
    local newname=$(echo "$basename" | tr '[:upper:]' '[:lower:]')
    
    # Only rename if the new name is different
    if [ "$basename" != "$newname" ]; then
        local newpath="${dirname}/${newname}"
        
        # Check if the target already exists
        if [ -e "$newpath" ] && [ "$path" != "$newpath" ]; then
            echo "[WARNING] $newpath already exists. Skipping rename of $path" | tee -a "$LOG_FILE"
        else
            # Rename the file/directory
            mv -v "$path" "$newpath" 2>&1 | tee -a "$LOG_FILE"
        fi
    fi
}

export -f rename_to_lowercase

echo "Starting docs renaming process at $(date)" > "$LOG_FILE"

# Find all docs directories (excluding vendor directories)
find "$BASE_DIR" -type d -name "docs" | grep -v "vendor" | while read -r doc_dir; do
    echo "\nProcessing: $doc_dir" | tee -a "$LOG_FILE"
    
    # Change to the docs directory
    pushd "$doc_dir" > /dev/null || continue
    
    # First, process directories (depth-first to handle nested directories)
    find . -depth -type d -print0 | while IFS= read -r -d $'\0' dir; do
        # Skip current directory
        [ "$dir" = "." ] && continue
        
        # Rename the directory
        rename_to_lowercase "$dir"
    done
    
    # Then, process files
    find . -type f -print0 | while IFS= read -r -d $'\0' file; do
        # Rename the file
        rename_to_lowercase "$file"
    done
    
    # Return to the original directory
    popd > /dev/null || continue
done

echo "\nRenaming process completed at $(date)" | tee -a "$LOG_FILE"

# Count remaining uppercase files/directories
echo "\nChecking for remaining uppercase files/directories..." | tee -a "$LOG_FILE"
find "$BASE_DIR" -type d -name "docs" | grep -v "vendor" | while read -r doc_dir; do
    count=$(find "$doc_dir" -type f -o -type d | grep -v "README\.md$" | grep -E '[A-Z]' | wc -l)
    if [ "$count" -gt 0 ]; then
        echo "$doc_dir: $count items with uppercase letters" | tee -a "$LOG_FILE"
    fi
done

echo "\nLog saved to: $LOG_FILE"
