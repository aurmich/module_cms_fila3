# Filament Best Practices - XotBasePage Extension

## Regola Fondamentale

**MAI** estendere direttamente le classi Filament. **SEMPRE** estendere le classi base Xot con prefisso `XotBase`.

## Pattern Corretto

### ✅ DO - Estendere XotBasePage

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class MyPage extends XotBasePage
{
    // Implementazione specifica
}
```

### ❌ DON'T - Estendere Filament direttamente

```php
<?php

// ❌ MAI fare questo
use Filament\Pages\Page;

class MyPage extends Page
{
    // Implementazione
}
```

## XotBasePage - Funzionalità Già Implementate

La classe `XotBasePage` già implementa:

1. **HasForms** interface
2. **InteractsWithForms** trait  
3. **TransTrait** trait
4. Sistema di traduzioni integrato
5. Gestione autorizzazioni
6. Metodi helper comuni

## DRY + KISS Principles

### ✅ DO - Non duplicare trait già presenti

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class MyPage extends XotBasePage
{
    // NIENTE implements HasForms (già implementato in XotBasePage)
    // NIENTE use InteractsWithForms (già implementato in XotBasePage)
    
    // Solo implementazione specifica
}
```

### ❌ DON'T - Duplicare trait già implementati

```php
<?php

// ❌ MAI fare questo
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class MyPage extends Page implements HasForms
{
    use InteractsWithForms; // ❌ ERRORE: già presente in XotBasePage
    
    // Implementazione
}
```

## Mappatura Classi Base

| Classe Filament | Classe XotBase Corrispondente |
|-----------------|-------------------------------|
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |

## Motivazione

1. **DRY (Don't Repeat Yourself)**: Evita duplicazione di trait e interfacce
2. **KISS (Keep It Simple, Stupid)**: Semplifica l'implementazione
3. **Coerenza**: Uniformità nel progetto
4. **Manutenibilità**: Funzionalità comuni centralizzate
5. **Estendibilità**: Facile aggiungere funzionalità comuni

## Checklist Pre-Implementazione

Prima di creare una nuova classe Filament:

- [ ] Verificare che estenda la classe XotBase appropriata
- [ ] Non implementare interfacce già presenti nella base
- [ ] Non usare trait già presenti nella base
- [ ] Documentare eventuali personalizzazioni specifiche
- [ ] Aggiornare la documentazione del modulo

## Esempi di Refactoring

### Prima (❌ ERRATO)

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class S3Test extends Page implements HasForms
{
    use InteractsWithForms;
    
    // Implementazione...
}
```

### Dopo (✅ CORRETTO)

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class S3Test extends XotBasePage
{
    // Solo implementazione specifica
    // HasForms e InteractsWithForms già ereditati
}
```

## Regola Fondamentale: MAI ->label(), ->placeholder(), ->helperText()

**MAI usare `->label()`, `->placeholder()` e `->helperText()` nei form components Filament. Le traduzioni sono gestite automaticamente dal LangServiceProvider.**

### ❌ ERRATO - MAI Fare Questo
```php
Forms\Components\TextInput::make('email')
    ->label('Email')
    ->placeholder('Inserisci la tua email')
    ->helperText('Email per contatti')
```

### ✅ CORRETTO - Solo Chiavi Campo
```php
Forms\Components\TextInput::make('email')
    ->email()
    ->required(),
```

## Documentazione Correlata

- [XotBasePage Implementation](../xotbasepage_implementation.md)
- [Filament Resources Best Practices](./filament_resources_best_practices.md)
- [DRY + KISS Principles](./dry_kiss_principles.md)
- [Form Components Rules](../../../.cursor/rules/filament-form-components.mdc)

*Ultimo aggiornamento: giugno 2025*
