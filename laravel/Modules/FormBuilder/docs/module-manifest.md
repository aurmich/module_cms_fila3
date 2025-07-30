# Module Manifest Configuration - FormBuilder

## Data: 2025-07-29

## Panoramica

Il modulo FormBuilder utilizza due file di configurazione principali per la gestione del modulo: `module.json` e `composer.json`. Questi file devono seguire le convenzioni Laraxot per garantire il corretto funzionamento e l'integrazione con il sistema.

## module.json - Configurazione Modulo

### Struttura Corretta

Il file `module.json` deve contenere tutte le proprietà obbligatorie seguendo il pattern degli altri moduli:

```json
{
    "name": "FormBuilder",
    "alias": "formbuilder",
    "description": "Modulo per la gestione dinamica di form personalizzabili con integrazione Filament",
    "keywords": ["forms", "form-builder", "dynamic-forms", "filament", "validation"],
    "priority": 0,
    "active": 1,
    "order": 0,
    "providers": [
        "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
        "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": []
}
```

### Proprietà Obbligatorie

#### 1. **active** (MANCANTE)
- **Tipo**: `integer` (0 o 1)
- **Valore**: `1` per moduli attivi
- **Motivazione**: Necessario per il controllo dello stato del modulo

#### 2. **order** (MANCANTE)
- **Tipo**: `integer`
- **Valore**: Ordine di caricamento del modulo
- **Motivazione**: Gestisce la sequenza di inizializzazione

#### 3. **aliases** (MANCANTE)
- **Tipo**: `object`
- **Valore**: Oggetto vuoto `{}` se non ci sono alias
- **Motivazione**: Definisce alias per il modulo

#### 4. **requires** (MANCANTE)
- **Tipo**: `array`
- **Valore**: Array vuoto `[]` se non ci sono dipendenze
- **Motivazione**: Specifica dipendenze da altri moduli

### Confronto con Altri Moduli

#### SaluteMo (Riferimento)
```json
{
    "name": "SaluteMo",
    "alias": "salutemo",
    "description": "Gestione dei pazienti per il comune di Modena",
    "keywords": ["pazienti", "cartelle cliniche", "modena"],
    "priority": 10,
    "active": 1,        // ✅ Presente
    "order": 10,        // ✅ Presente
    "providers": [...],
    "aliases": {},      // ✅ Presente
    "files": []
}
```

#### Cms (Riferimento)
```json
{
    "name": "Cms",
    "alias": "cms",
    "description": "",
    "keywords": [],
    "priority": 3,
    "active": 1,        // ✅ Presente
    "order": 3,         // ✅ Presente
    "providers": [...],
    "aliases": [],      // ✅ Presente
    "files": [],
    "requires": []      // ✅ Presente
}
```

## composer.json - Configurazione Composer

### Problemi Identificati

#### 1. **Nome Package Inconsistente**
- **Attuale**: `"laraxot/module_formbuilder"`
- **Pattern corretto**: `"formbuilder/module"` (seguendo SaluteMo)
- **Motivazione**: Coerenza con naming convention degli altri moduli

#### 2. **Homepage URL**
- **Attuale**: `"https://github.com/laraxot/module_formbuilder"`
- **Problema**: URL potenzialmente inesistente
- **Soluzione**: Rimuovere o aggiornare con URL valido

#### 3. **Keywords Ridondanti**
- **Problema**: Parole chiave duplicate e inconsistenti
- **Soluzione**: Semplificare e standardizzare

### Struttura Corretta

```json
{
    "name": "formbuilder/module",
    "description": "FormBuilder Module - Sistema di creazione dinamica e gestione di form personalizzabili",
    "keywords": [
        "laraxot",
        "laravel",
        "filament",
        "formbuilder",
        "dynamic-forms",
        "form-templates"
    ],
    "license": "MIT",
    "authors": [
        {
            "name": "SaluteOra Team",
            "email": "team@saluteora.com"
        }
    ],
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
                "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
            ],
            "aliases": {}
        }
    },
    "autoload": {
        "psr-4": {
            "Modules\\FormBuilder\\": "app/",
            "Modules\\FormBuilder\\Database\\Factories\\": "database/factories/",
            "Modules\\FormBuilder\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Modules\\FormBuilder\\Tests\\": "tests/"
        }
    },
    "require": {
        "spatie/laravel-permission": "^6.0",
        "spatie/laravel-data": "^3.0"
    },
    "require-dev": {},
    "repositories": [
        {
            "type": "path",
            "url": "../Xot"
        },
        {
            "type": "path",
            "url": "../Tenant"
        },
        {
            "type": "path",
            "url": "../UI"
        }
    ],
    "scripts": {
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true,
            "wikimedia/composer-merge-plugin": true
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

## Convenzioni Laraxot

### 1. Naming Convention

#### module.json
- **Nome modulo**: PascalCase (es. `FormBuilder`)
- **Alias**: lowercase (es. `formbuilder`)
- **Descrizione**: Italiano, descrittiva e completa

#### composer.json
- **Package name**: `{modulename}/module` (es. `formbuilder/module`)
- **Description**: Inglese, con sottotitolo italiano
- **Keywords**: Minuscole, specifiche e rilevanti

### 2. Proprietà Obbligatorie

#### module.json
```json
{
    "name": "string",           // ✅ Obbligatorio
    "alias": "string",          // ✅ Obbligatorio
    "description": "string",    // ✅ Obbligatorio
    "keywords": ["array"],      // ✅ Obbligatorio
    "priority": "integer",      // ✅ Obbligatorio
    "active": "integer",        // ❌ MANCANTE in FormBuilder
    "order": "integer",         // ❌ MANCANTE in FormBuilder
    "providers": ["array"],     // ✅ Obbligatorio
    "aliases": "object|array",  // ❌ MANCANTE in FormBuilder
    "files": ["array"],         // ✅ Obbligatorio
    "requires": ["array"]       // ❌ MANCANTE in FormBuilder
}
```

#### composer.json
```json
{
    "name": "string",           // ✅ Obbligatorio (da correggere)
    "description": "string",    // ✅ Obbligatorio
    "keywords": ["array"],      // ✅ Obbligatorio (da semplificare)
    "license": "string",        // ✅ Obbligatorio
    "authors": ["array"],       // ✅ Obbligatorio
    "extra": "object",          // ✅ Obbligatorio
    "autoload": "object",       // ✅ Obbligatorio
    "autoload-dev": "object",   // ✅ Obbligatorio
    "require": "object",        // ✅ Obbligatorio
    "repositories": ["array"],  // ✅ Obbligatorio
    "scripts": "object",        // ✅ Obbligatorio
    "config": "object",         // ✅ Obbligatorio
    "minimum-stability": "string", // ✅ Obbligatorio
    "prefer-stable": "boolean"  // ✅ Obbligatorio
}
```

## Best Practices

### 1. Consistenza tra File

I provider devono essere identici in entrambi i file:
- `module.json` → `providers` array
- `composer.json` → `extra.laravel.providers` array

### 2. Versionamento

- **module.json**: Non include versioning (gestito da Git)
- **composer.json**: Versioning delle dipendenze specifico e aggiornato

### 3. Documentazione

- Mantenere descrizioni aggiornate e accurate
- Keywords rilevanti per la ricerca e categorizzazione
- Autori e contatti aggiornati

### 4. Dipendenze

- **require**: Solo dipendenze essenziali per il funzionamento
- **require-dev**: Dipendenze per sviluppo e testing
- **repositories**: Path ai moduli locali necessari

## Troubleshooting

### Problemi Comuni

1. **Modulo non caricato**: Verificare `active: 1` in module.json
2. **Provider non registrati**: Verificare coerenza tra module.json e composer.json
3. **Autoload non funzionante**: Verificare namespace PSR-4 in composer.json
4. **Dipendenze mancanti**: Verificare repositories e require in composer.json

### Debug

```bash
# Verificare caricamento moduli
php artisan module:list

# Verificare provider registrati
php artisan route:list | grep FormBuilder

# Rigenerare autoload
composer dump-autoload
```

## Collegamenti

- [Providers Overview](providers.md) - Documentazione provider del modulo
- [Architecture Overview](architecture.md) - Architettura generale del modulo
- [Installation Guide](../README.md#installation--setup) - Guida installazione

## Aggiornamenti

- **2025-07-29**: Creazione documentazione manifest
- **2025-07-29**: Identificazione problemi module.json e composer.json
- **2025-07-29**: Definizione convenzioni Laraxot per manifest
