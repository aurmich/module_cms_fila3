# Regole per l'Utilizzo degli Enum in SaluteOra (Windsurf)

## Indice
1. [Introduzione](#introduzione)
2. [Struttura degli Enum](#struttura-degli-enum)
3. [Configurazione del Progetto](#configurazione-del-progetto)
4. [Workflow di Sviluppo](#workflow-di-sviluppo)
5. [Code Review](#code-review)
6. [Risoluzione dei Problemi](#risoluzione-dei-problemi)
7. [Riferimenti](#riferimenti)

## Introduzione

Questo documento definisce le linee guida per l'utilizzo degli enum nel progetto SaluteOra, con particolare attenzione all'integrazione con Windsurf e Cursor.

## Struttura degli Enum

### Posizione dei File

Tutti gli enum devono essere posizionati nella directory `app/Enums/` con il seguente formato di nome:

```
app/
  Enums/
    UserType.php
    AppointmentStatus.php
    PaymentStatus.php
```

### Formato del Nome del File

- Usa il nome dell'enum in PascalCase
- Usa il suffisso appropriato (Type, Status, ecc.)
- Mantieni i nomi descrittivi e coerenti

### Struttura dell'Enum

Ogni enum deve seguire questa struttura base:

```php
<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    
    public function getLabel(): ?string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
    
    // Altri metodi utili...
}
```

## Configurazione del Progetto

### Configurazione di PHPStan

Aggiungi questa configurazione a `phpstan.neon`:

```neon
parameters:
    level: 8
    paths:
        - app
        - config
        - database
        - routes
        - tests
    
    # Ignora gli errori per i metodi magici
    excludePaths:
        - vendor/*
    
    # Aggiungi i percorsi degli enum
    scanDirectories:
        - app/Enums

    # Abilita le estensioni di Laravel
    includes:
        - vendor/nunomaduro/larastan/extension.neon

    # Configurazione specifica per gli enum
    checkMissingIterableValueType: false
```

### Configurazione di PHP_CodeSniffer

Aggiungi queste regole a `phpcs.xml`:

```xml
<?xml version="1.0"?>
<ruleset name="SaluteOra">
    <!-- ... altre regole ... -->
    
    <!-- Regole specifiche per gli enum -->
    <rule ref="PSR12.Classes.ClassDeclaration">
        <exclude name="PSR12.Classes.ClassDeclaration.SpaceAfterClassBrace" />
    </rule>
    
    <rule ref="SlevomatCodingStandard.TypeHints">
        <properties>
            <property name="traversableTypeHints" type="array">
                <element value="array"/>
                <element value="\Traversable"/>
                <element value="\Generator"/>
                <element value="\Iterator"/>
                <element value="\IteratorAggregate"/>
            </property>
        </properties>
    </rule>
    
    <!-- ... altre regole ... -->
</ruleset>
```

## Workflow di Sviluppo

### Creazione di un Nuovo Enum

1. Crea un nuovo file nella directory `app/Enums/`
2. Definisci i casi dell'enum
3. Implementa i metodi necessari (getLabel, getColor, ecc.)
4. Aggiungi i test unitari
5. Aggiorna la documentazione

### Aggiornamento di un Enum Esistente

1. Aggiungi nuovi casi alla fine dell'enum
2. Non modificare i valori esistenti (romperebbe la compatibilità)
3. Aggiorna tutti i metodi che usano l'enum (match, switch, ecc.)
4. Aggiorna i test
5. Aggiorna la documentazione

## Code Review

Durante la code review, verifica che:

1. L'enum implementi l'interfaccia `HasLabel` di Filament
2. Tutti i casi siano documentati
3. I metodi di utilità siano presenti e testati
4. Non ci siano riferimenti a valori letterali delle costanti
5. I test coprano tutti i casi d'uso

## Risoluzione dei Problemi

### Problema: L'enum non viene riconosciuto da Filament

**Soluzione:**
1. Verifica che l'enum implementi `Filament\Support\Contracts\HasLabel`
2. Assicurati che il metodo `getLabel()` sia implementato correttamente
3. Controlla che il namespace sia corretto

### Problema: Errore di tipizzazione in PHPStan

**Soluzione:**
1. Verifica che il tipo di ritorno sia corretto
2. Aggiungi i PHPDoc mancanti
3. Aggiorna la configurazione di PHPStan se necessario

## Riferimenti

- [Documentazione Ufficiale PHP sugli Enum](https://www.php.net/manual/en/language.enumerations.php)
- [Documentazione di Filament sugli Enum](https://filamentphp.com/docs/3.x/support/enums)
- [Best Practice per gli Enum in Laravel](https://laravel-news.com/php-enums-laravel)
- [PHPStan e Enum](https://phpstan.org/writing-php-code/php-enums)

# Regola Directory Obbligatoria (Windsurf)

Tutte le classi PHP (Models, Enums, Actions, Providers, View/Components, ecc.) DEVONO essere in `app/`.

- ❌ Sbagliato: `Modules/SaluteOra/Enums/UserType.php`
- ✅ Corretto: `Modules/SaluteOra/app/Enums/UserType.php`

Windsurf deve segnalare e bloccare errori di struttura.

Consulta sempre:
- [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md)
- [CURSOR_RULES.md](./CURSOR_RULES.md)
