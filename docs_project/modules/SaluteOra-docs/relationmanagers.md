# RelationManager in SaluteOra

## Panoramica

I RelationManager sono componenti Filament che permettono di gestire le relazioni tra diverse entità del sistema direttamente dall'interfaccia di amministrazione. Questo documento descrive l'implementazione delle relazioni tra Studio e Doctor nel modulo SaluteOra.

## Architettura Cross-Module

### Implementazioni Multiple
Le relazioni Doctor-Studio sono implementate in due moduli:
- **SaluteOra**: Contiene i modelli di dominio e RelationManager base
- **SaluteMo**: Contiene RelationManager Filament specifici per l'amministrazione

> **Nota**: Per la documentazione completa del RelationManager di amministrazione, vedere [RelationManager SaluteMo](/var/www/html/base_saluteora/laravel/Modules/SaluteMo/docs/filament/relationmanagers.md)

## Struttura dei Namespace

Tutti i RelationManager devono seguire questa struttura di namespace:

```php
namespace Modules\SaluteOra\Filament\Resources\{ResourceName}\RelationManagers;
```

## Relazione Studio-Doctor

### Modello Studio

```php
// In Studio.php
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class);
}
```

### Modello Doctor

```php
// In Doctor.php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

## Motivazione e filosofia
- La relazione molti-a-molti riflette la realtà sanitaria: un dottore può lavorare in più studi e uno studio può avere più dottori.
- Si usa belongsToManyX per massima flessibilità, DRY, e per supportare pivot custom e policy multi-tenant.
- La simmetria della relazione permette una gestione coerente, audit trail e policy di sicurezza centralizzate.
- La documentazione e la struttura del codice sono pensate per essere zen, chiare e facilmente estendibili.

## Implementazione dei RelationManager

### DoctorsRelationManager

```php
namespace Modules\SaluteOra\Filament\Resources\StudioResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

class DoctorsRelationManager extends RelationManager
{
    protected static string $relationship = 'doctors';
    
    // Configurazione della tabella e dei form...
}
```

### StudiosRelationManager

```php
namespace Modules\SaluteOra\Filament\Resources\DoctorResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

class StudiosRelationManager extends RelationManager
{
    protected static string $relationship = 'tenant';
    
    // Configurazione della tabella e dei form...
}
```

## Registrazione dei RelationManager

I RelationManager devono essere registrati nel metodo `getRelations()` della risorsa Filament corrispondente:

```php
public static function getRelations(): array
{
    return [
        'doctors' => RelationManagers\DoctorsRelationManager::class,
    ];
}
```

## Best Practices

1. Utilizzare chiavi stringa negli array associativi per tutte le configurazioni
2. Mantenere la coerenza nei nomi delle relazioni
3. Utilizzare lo stesso schema di colonne della risorsa principale dove possibile
4. Includere solo le azioni pertinenti nel contesto della relazione
5. Assicurarsi che le autorizzazioni siano configurate correttamente

## Documentazione Cross-Module

### Modulo SaluteMo
- **[RelationManager SaluteMo](/var/www/html/base_saluteora/laravel/Modules/SaluteMo/docs/filament/relationmanagers.md)** - Implementazione completa per l'interfaccia amministrativa

### Modulo SaluteOra (Corrente)
- [Studio Model](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/models/studio.md)
- [Doctor Model](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor.md)
- [DoctorStudio Pivot](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor-studio.md)

### Root Documentation  
- [Cross-Module Relations](/var/www/html/base_saluteora/docs/cross-module-relations.md)
- [Filament Best Practices](/var/www/html/base_saluteora/docs/filament_best_practices.md)

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.1*
*Compatibilità: Laraxot SaluteOra, Filament 3.x*
