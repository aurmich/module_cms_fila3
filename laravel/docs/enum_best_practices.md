# Enum Best Practices

## Data: 2025-01-06

## REGOLA CRITICA: SEMPRE usa transClass() negli Enum

### ✅ CORRETTO - Implementazione Enum con TransTrait

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value . '.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value . '.description');
    }

    public function getTooltip(): string
    {
        return $this->transClass(self::class, $this->value . '.tooltip');
    }

    public function getHelperText(): string
    {
        return $this->transClass(self::class, $this->value . '.helper_text');
    }
}
```

### ❌ ERRORE - Non fare mai questo

```php
// ❌ ERRORE - Non usare mai match() per traduzioni
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}

// ❌ ERRORE - Non hardcodare valori
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

## Sistema Traduzioni Automatico

### Come Funziona
- Il `TransTrait` fornisce il metodo `transClass()`
- Le traduzioni vengono caricate automaticamente dai file `lang/`
- Struttura: `Modules\EnumClass\lang\it\enum_name.php`

### Implementazione Corretta

#### 1. Import TransTrait
```php
use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    case VALUE1 = 'value1';
    case VALUE2 = 'value2';
}
```

#### 2. Metodi Standard
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}

public function getTooltip(): string
{
    return $this->transClass(self::class, $this->value . '.tooltip');
}

public function getHelperText(): string
{
    return $this->transClass(self::class, $this->value . '.helper_text');
}
```

#### 3. Struttura Traduzioni
```php
// File: Modules/ModuleName/lang/it/enum_name.php
return [
    'value1' => [
        'label' => 'Etichetta 1',
        'description' => 'Descrizione 1',
        'tooltip' => 'Tooltip 1',
        'helper_text' => 'Helper text 1',
        'color' => 'primary',
        'icon' => 'heroicon-o-icon1',
    ],
    'value2' => [
        'label' => 'Etichetta 2',
        'description' => 'Descrizione 2',
        'tooltip' => 'Tooltip 2',
        'helper_text' => 'Helper text 2',
        'color' => 'secondary',
        'icon' => 'heroicon-o-icon2',
    ],
];
```

## Struttura Traduzioni Obbligatoria

### Struttura Espansa Completa
```php
'value_name' => [
    'label' => 'Etichetta',
    'description' => 'Descrizione',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => 'Testo di aiuto',
    'color' => 'primary',
    'icon' => 'heroicon-o-icon',
],
```

### Regole Specifiche
- **SEMPRE** usare `TransTrait` negli enum
- **SEMPRE** usare `transClass()` per traduzioni
- **MAI** usare `match()` per traduzioni
- **SEMPRE** struttura espansa completa
- **SEMPRE** `declare(strict_types=1);`
- **SEMPRE** sintassi moderna `[]` invece di `array()`

## Sincronizzazione Lingue

### Regola Critica
- **TUTTI** i file `lang/en/` devono avere le stesse voci di `lang/it/`
- **SEMPRE** confrontare file IT e EN prima di modifiche
- **SEMPRE** aggiungere nuove voci in entrambe le lingue
- **NUOVO**: Aggiungere sempre anche traduzioni tedesche (DE)

### Esempio Sincronizzazione
```php
// File: Modules/User/lang/it/status.php
'active' => [
    'label' => 'Attivo',
    'description' => 'Stato attivo',
    'tooltip' => 'Elemento attivo',
    'helper_text' => 'Stato attivo dell\'elemento',
    'color' => 'success',
    'icon' => 'heroicon-o-check-circle',
],

// File: Modules/User/lang/en/status.php
'active' => [
    'label' => 'Active',
    'description' => 'Active status',
    'tooltip' => 'Active element',
    'helper_text' => 'Element active status',
    'color' => 'success',
    'icon' => 'heroicon-o-check-circle',
],

// File: Modules/User/lang/de/status.php
'active' => [
    'label' => 'Aktiv',
    'description' => 'Aktiver Status',
    'tooltip' => 'Aktives Element',
    'helper_text' => 'Element aktiver Status',
    'color' => 'success',
    'icon' => 'heroicon-o-check-circle',
],
```

## Esempi di Errori Comuni

### ❌ ERRORE - Match per traduzioni
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

### ✅ CORRETTO - transClass()
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}
```

### ❌ ERRORE - Valori hardcoded
```php
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

### ✅ CORRETTO - transClass()
```php
public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}
```

## Checklist Pre-Implementazione

Prima di creare un nuovo Enum:

- [ ] Importare `TransTrait`
- [ ] Implementare tutti i metodi standard con `transClass()`
- [ ] Creare file traduzioni in `lang/it/`, `lang/en/`, `lang/de/`
- [ ] Struttura espansa completa per ogni valore
- [ ] Sincronizzazione IT/EN/DE
- [ ] Testare traduzioni in ambiente di sviluppo

## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare match() in enum
// Implementare in phpstan.neon
rules:
    - rule: Never use match() for translations in enums
```

### Code Review Checklist
- [ ] TransTrait importato
- [ ] Tutti i metodi usano `transClass()`
- [ ] Nessun `match()` per traduzioni
- [ ] Traduzioni implementate in tutte le lingue
- [ ] Struttura espansa completa

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](translation_standards.md)
- [Filament Best Practices](filament_best_practices.md)
- [UI Module Enum Rules](../Modules/UI/docs/transclass_rule.md)

## Memoria Permanente

**RICORDA SEMPRE**: 
- SEMPRE `TransTrait` negli enum
- SEMPRE `transClass()` per traduzioni
- MAI `match()` per traduzioni
- SEMPRE struttura espansa nelle traduzioni
- SEMPRE sincronizzazione IT/EN/DE

*Ultimo aggiornamento: 2025-01-06* 