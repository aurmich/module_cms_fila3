# RelationManager Implementation Standards

## Overview
I RelationManager sono componenti Filament che gestiscono le relazioni tra modelli. In SaluteOra, implementiamo RelationManager per gestire la relazione tra Studio e Doctor.

## Relazioni nel Progetto
- Studio ha una relazione hasMany con Doctor attraverso il campo `tenant_id`
- Doctor usa il trait BelongsToTenant per appartenere a uno Studio

## Standard di Implementazione

### Namespace
I RelationManager devono essere collocati in:
```
Modules\SaluteOra\Filament\Resources\[ResourceName]\RelationManagers
```

### Classi Base
- Estendere `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager`
- Non estendere direttamente le classi Filament

### Convenzioni di Naming
- Seguire il pattern: `[RelationName]RelationManager`
- Esempio: `DoctorsRelationManager`, `StudiosRelationManager`

### Traduzione
- Non utilizzare ->label() nei componenti
- Utilizzare file di traduzione in: `Modules/SaluteOra/lang/[lang]/relation-managers.php`

### Schema
- `getTableColumns()` deve restituire un array associativo con chiavi stringhe
- Le chiavi devono corrispondere ai campi del modello

## Esempio

```php
namespace Modules\SaluteOra\Filament\Resources\StudioResource\RelationManagers;

use Filament\Tables;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DoctorsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'doctors';
    
    public function getTableColumns(): array
    {
        return [
            'first_name' => Tables\Columns\TextColumn::make('first_name')
                ->searchable(),
            // altre colonne...
        ];
    }
}
```

## Implementazione
Aggiungiamo RelationManager per:
1. Studio -> Doctors
2. Doctor -> Studios