#!/bin/bash

# Script to scan all docs directories for files and directories with uppercase letters
# Excludes README.md files as they are allowed to have uppercase letters

# Set the base directory
BASE_DIR="/var/www/html/_bases/base_saluteora"

# Output file for the report
REPORT_FILE="$BASE_DIR/docs_uppercase_report.txt"

# Clear the report file
echo "# Uppercase Naming Violations Report" > "$REPORT_FILE"
echo "Generated: $(date)" >> "$REPORT_FILE"
echo "" >> "$REPORT_FILE"

# Find all docs directories and process them
find "$BASE_DIR" -type d -name "docs" | sort | while read -r doc_dir; do
    echo "Scanning: $doc_dir"
    
    # Count uppercase files/directories (excluding README.md)
    uppercase_count=$(find "$doc_dir" -type f -o -type d | grep -v "README\.md$" | grep -E '[A-Z]' | wc -l)
    
    if [ "$uppercase_count" -gt 0 ]; then
        echo "## $doc_dir" >> "$REPORT_FILE"
        echo "Found $uppercase_count items with uppercase letters" >> "$REPORT_FILE"
        
        # List the first 10 uppercase items
        find "$doc_dir" -type f -o -type d | grep -v "README\.md$" | grep -E '[A-Z]' | head -n 10 | while read -r item; do
            echo "- $item" >> "$REPORT_FILE"
        done
        
        # Add a note if there are more items
        if [ "$uppercase_count" -gt 10 ]; then
            echo "- ... and $((uppercase_count - 10)) more items" >> "$REPORT_FILE"
        fi
        
        echo "" >> "$REPORT_FILE"
    fi
done

# Count total violations
total_violations=$(grep -c "^-" "$REPORT_FILE" 2>/dev/null || echo 0)
echo "Scan complete. Found $total_violations total violations."
echo "Report saved to: $REPORT_FILE"
