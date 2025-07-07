#!/bin/bash

# Script per verificare la sintassi di tutti i file di traduzione

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🔍 Verifica sintassi file di traduzione...${NC}"

# Trova tutti i file di traduzione e verifica sintassi
find laravel/Modules -name "*.php" -path "*/lang/*" | while read -r file; do
    filename=$(basename "$file")
    echo -e "${BLUE}📄 Verificando: $filename${NC}"
    
    if php -l "$file" > /dev/null 2>&1; then
        echo -e "${GREEN}✅ $filename - Sintassi OK${NC}"
    else
        echo -e "${RED}❌ $filename - Errore di sintassi${NC}"
    fi
done

echo -e "${GREEN}🎉 Verifica completata!${NC}"

# Pulisci cache Laravel
echo -e "${YELLOW}🧹 Pulizia cache Laravel...${NC}"
cd laravel
php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
echo -e "${GREEN}✅ Cache pulita${NC}"
