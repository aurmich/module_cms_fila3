#!/bin/bash

# Script per correggere automaticamente tutti i nomi di file e cartelle 
# nelle directory docs/ che violano la regola lowercase
# REGOLA: Tutti i file/cartelle in docs/ devono essere lowercase, eccetto README.md

set -e

echo "🔍 Avvio audit completo delle convenzioni di naming per cartelle docs/"
echo "📋 REGOLA: Tutti i file e cartelle in docs/ devono essere lowercase, eccetto README.md"
echo ""

# Funzione per convertire nomi in lowercase con trattini
to_lowercase_with_dashes() {
    echo "$1" | sed 's/[A-Z]/-\L&/g' | sed 's/^-//' | sed 's/_/-/g'
}

# Trova tutte le directory docs
find /var/www/html/_bases/base_saluteora/laravel -type d -name "docs" | while read docs_dir; do
    echo "📁 Controllo directory: $docs_dir"
    
    # Trova tutti i file e cartelle con caratteri maiuscoli (eccetto README.md)
    find "$docs_dir" -type f -name "*[A-Z]*" ! -name "README.md" | while read file; do
        dir=$(dirname "$file")
        filename=$(basename "$file")
        new_filename=$(to_lowercase_with_dashes "$filename")
        
        if [ "$filename" != "$new_filename" ]; then
            echo "  🔄 Rinomino: $filename → $new_filename"
            mv "$file" "$dir/$new_filename"
        fi
    done
    
    # Trova tutte le cartelle con caratteri maiuscoli
    find "$docs_dir" -type d -name "*[A-Z]*" | sort -r | while read folder; do
        parent_dir=$(dirname "$folder")
        foldername=$(basename "$folder")
        new_foldername=$(to_lowercase_with_dashes "$foldername")
        
        if [ "$foldername" != "$new_foldername" ]; then
            echo "  📂 Rinomino cartella: $foldername → $new_foldername"
            mv "$folder" "$parent_dir/$new_foldername"
        fi
    done
done

echo ""
echo "✅ Audit completato! Tutti i file e cartelle docs/ ora rispettano la convenzione lowercase."
echo "📝 Ricorda: questa regola è FONDAMENTALE e deve essere sempre rispettata."
