# Linee Guida Risorse Xot

## Principi Fondamentali
1. Mai estendere direttamente le classi Filament
2. Utilizzare sempre le classi base Xot con prefisso `XotBase`
3. Gestire le traduzioni tramite LangServiceProvider
4. Mantenere la coerenza nella struttura dei namespace

## Struttura Base
```php
namespace Modules\SaluteOra\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    // Implementazione
}
```

## Gestione Traduzioni
- Utilizzare i file di traduzione in `lang/`
- Non usare mai `->label()` direttamente
- Struttura corretta per i campi:
```php
'source' => [
    'label' => 'Sorgente',
    'tooltip' => 'Descrizione tooltip',
    'placeholder' => 'Testo placeholder'
]
```

## Actions
```php
'actions' => [
    'edit' => [
        'label' => 'Modifica',
        'icon' => 'heroicon-o-pencil',
        'color' => 'primary'
    ]
]
```

## Collegamenti
- [Namespace Conventions](./namespace.md)
- [Filament Directory Structure](./filament-directory-structure.md)
- [Indice Documentazione Centrale](../docs/INDEX.md)
- [Regole Namespace Xot](../Modules/Xot/docs/namespace-rules.md)
