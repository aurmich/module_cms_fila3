#!/bin/bash

# This script checks for files and directories in docs/ that don't follow the lowercase naming convention
# The only exception is README.md which can have uppercase letters

BASE_DIR="/var/www/html/_bases/base_saluteora/laravel"

# Find all docs and _docs directories
find "$BASE_DIR" -type d \( -name "docs" -o -name "_docs" \) | while read -r dir; do
    echo "Checking directory: $dir"
    
    # Find files that don't follow the convention (excluding README.md)
    find "$dir" -type f -not -name "README.md" -not -name "*[a-z]*" -print
    
    # Find directories that don't follow the convention
    find "$dir" -type d -not -name "docs" -not -name "_docs" -not -name "*[a-z]*" -print
    
    # Find files with uppercase letters (excluding README.md)
    find "$dir" -type f -not -name "README.md" -name "*[A-Z]*" -print
    
    # Find directories with uppercase letters
    find "$dir" -type d -not -name "docs" -not -name "_docs" -name "*[A-Z]*" -print

done | sort -u > "$BASE_DIR/docs_naming_issues.txt"

echo "Naming issues have been written to $BASE_DIR/docs_naming_issues.txt"
