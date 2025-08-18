#!/bin/bash

# Script per eseguire tutti i test con coverage
# Usage: ./scripts/run-tests.sh [options]

set -e

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzioni helper
print_header() {
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

# Configurazione
COVERAGE_DIR="coverage-html"
COVERAGE_CLOVER="coverage-clover.xml"
MEMORY_LIMIT="2G"

# Parse arguments
SKIP_PHPSTAN=false
SKIP_COVERAGE=false
FILTER=""

while [[ $# -gt 0 ]]; do
    case $1 in
        --skip-phpstan)
            SKIP_PHPSTAN=true
            shift
            ;;
        --skip-coverage)
            SKIP_COVERAGE=true
            shift
            ;;
        --filter)
            FILTER="$2"
            shift 2
            ;;
        --help)
            echo "Usage: $0 [options]"
            echo "Options:"
            echo "  --skip-phpstan    Skip PHPStan analysis"
            echo "  --skip-coverage   Skip coverage generation"
            echo "  --filter PATTERN  Run only tests matching pattern"
            echo "  --help           Show this help"
            exit 0
            ;;
        *)
            echo "Unknown option: $1"
            exit 1
            ;;
    esac
done

print_header "SaluteOra Test Suite"

# Verifica che siamo nella directory corretta
if [ ! -f "composer.json" ]; then
    print_error "Esegui questo script dalla root del progetto Laravel"
    exit 1
fi

# Cleanup precedente
print_header "Cleanup"
rm -rf $COVERAGE_DIR
rm -f $COVERAGE_CLOVER
rm -f junit.xml
print_success "Cleanup completato"

# PHPStan Analysis
if [ "$SKIP_PHPSTAN" = false ]; then
    print_header "PHPStan Analysis"
    if ./vendor/bin/phpstan analyze --level=9 --memory-limit=$MEMORY_LIMIT; then
        print_success "PHPStan analysis passed"
    else
        print_error "PHPStan analysis failed"
        exit 1
    fi
fi

# Prepare test environment
print_header "Preparazione Ambiente Test"
php artisan config:clear --env=testing
php artisan cache:clear --env=testing
print_success "Ambiente preparato"

# Run tests
print_header "Esecuzione Test"

PEST_CMD="./vendor/bin/pest"

if [ "$SKIP_COVERAGE" = false ]; then
    PEST_CMD="$PEST_CMD --coverage --coverage-html=$COVERAGE_DIR --coverage-clover=$COVERAGE_CLOVER"
fi

if [ -n "$FILTER" ]; then
    PEST_CMD="$PEST_CMD --filter=\"$FILTER\""
fi

# Aggiungi opzioni per output dettagliato
PEST_CMD="$PEST_CMD --verbose"

echo "Comando: $PEST_CMD"

if eval $PEST_CMD; then
    print_success "Tutti i test sono passati!"
else
    print_error "Alcuni test sono falliti"
    exit 1
fi

# Coverage Report
if [ "$SKIP_COVERAGE" = false ]; then
    print_header "Coverage Report"
    if [ -f "$COVERAGE_CLOVER" ]; then
        print_success "Coverage report generato: $COVERAGE_CLOVER"
    fi
    
    if [ -d "$COVERAGE_DIR" ]; then
        print_success "Coverage HTML generato: $COVERAGE_DIR/index.html"
        echo -e "${YELLOW}Apri $COVERAGE_DIR/index.html nel browser per vedere il report dettagliato${NC}"
    fi
fi

# Test Summary
print_header "Riepilogo"
echo "Test completati con successo!"
echo "Moduli testati:"
echo "  ✓ Chart"
echo "  ✓ SaluteOra"
echo "  ✓ SaluteMo"
echo "  ✓ User"
echo "  ✓ Geo"

if [ "$SKIP_COVERAGE" = false ]; then
    echo ""
    echo "Coverage disponibile in:"
    echo "  - HTML: $COVERAGE_DIR/index.html"
    echo "  - Clover: $COVERAGE_CLOVER"
fi

print_success "Test suite completata!"