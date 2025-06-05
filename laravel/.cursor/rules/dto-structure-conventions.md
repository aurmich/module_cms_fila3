# Regole per la Struttura dei DTO

## Struttura delle Directory

I Data Transfer Objects (DTO) devono essere collocati nella directory corretta in base al modulo:

```
/Modules/<ModuleName>/app/Datas/
```

**MAI utilizzare** le seguenti directory per i DTO:
- `/Modules/<ModuleName>/app/Data/`
- `/Modules/<ModuleName>/app/DTOs/`
- `/Modules/<ModuleName>/app/Dto/`

## Convenzioni di Nomenclatura

### Naming dei File

I file DTO devono seguire la convenzione di nomenclatura PascalCase con il suffisso `Data`:

✅ **Corretto**:
```
NetfunSmsData.php
EmailData.php
NotificationData.php
```

❌ **Errato**:
```
netfun_sms_data.php
NetfunSMS.php
Netfun.php
```

### Namespace

Il namespace dei DTO deve essere:

```php
namespace Modules\<ModuleName>\Datas;
```

**MAI utilizzare** i seguenti namespace:
- `Modules\<ModuleName>\Data`
- `Modules\<ModuleName>\DTOs`
- `Modules\<ModuleName>\Dto`

## Implementazione

### Proprietà Readonly

Utilizzare sempre proprietà readonly per i DTO in PHP 8.2+:

```php
readonly class ExampleData
{
    public function __construct(
        public string $requiredProperty,
        public ?string $optionalProperty = null,
    ) {}
}
```

### Tipi Rigorosi

Specificare sempre i tipi per tutte le proprietà e utilizzare tipi nullable quando appropriato.

### Documentazione

Ogni DTO deve includere PHPDoc completo con descrizione delle proprietà.

## Organizzazione dei File

I DTO devono essere posizionati direttamente nella directory `Datas/` e non in sottodirectory, a meno che non sia assolutamente necessario per ragioni di organizzazione.

## Esempio Completo

```php
<?php

namespace Modules\Notify\Datas;

/**
 * DTO per i dati di esempio
 */
readonly class ExampleData
{
    /**
     * @param string $requiredProperty Proprietà obbligatoria
     * @param string|null $optionalProperty Proprietà opzionale
     */
    public function __construct(
        public string $requiredProperty,
        public ?string $optionalProperty = null,
    ) {}
}
```
