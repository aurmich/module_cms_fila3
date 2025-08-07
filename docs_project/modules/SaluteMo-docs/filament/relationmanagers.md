# RelationManager in SaluteMo

## Panoramica

Il modulo SaluteMo contiene i RelationManager Filament che gestiscono le relazioni tra entità del sistema sanitario SaluteOra. I modelli effettivi risiedono nel modulo SaluteOra, mentre SaluteMo fornisce l'interfaccia amministrativa Filament.

## Architettura Cross-Module

### Separazione Responsabilità
- **SaluteOra**: Contiene i modelli di dominio (Doctor, Studio, DoctorStudio)
- **SaluteMo**: Contiene le risorse Filament e RelationManager per l'amministrazione

### Relazioni Cross-Database
La relazione Doctor-Studio attraversa multiple connessioni database:
- `Doctor`: Database 'user' 
- `Studio`: Database 'salute_ora'
- `DoctorStudio` (pivot): Database 'salute_ora'

## StudiosRelationManager

### Implementazione

```php
<?php

namespace Modules\SaluteMo\Filament\Resources\DoctorResource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\SaluteMo\Filament\Resources\StudioResource;

class StudiosRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'studios';
    public static string $resourceClass = StudioResource::class;
    
    public function getTableColumns(): array
    {
        $columns = parent::getTableColumns();
        return $columns;
    }
}
```

### Caratteristiche Chiave

1. **Estensione Base Corretta**: Estende `XotBaseRelationManager` (non direttamente Filament)
2. **Relazione**: Gestisce la relazione molti-a-molti `studios` del modello `Doctor`
3. **Risorsa Collegata**: Utilizza `StudioResource::class` per la configurazione delle colonne
4. **Colonne Ereditate**: Le colonne vengono ereditate dalla risorsa Studio tramite `parent::getTableColumns()`

### Relazione Sottostante

La relazione `studios` nel modello `Doctor` è definita come:

```php
// In Modules\SaluteOra\Models\Doctor
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

### Modello Pivot Personalizzato

La relazione utilizza il modello pivot `DoctorStudio` che contiene:
- **Orari di lavoro**: Campo `schedule` (array) con orari personalizzati per dottore/studio
- **Studio primario**: Flag `is_primary` per identificare lo studio principale
- **Metodi specializzati**: `getOpeningHours()`, `getAvailableTimeSlotsByDate()`

## Configurazioni Avanzate

### Tabella Personalizzata

Il RelationManager eredita automaticamente le colonne da `StudioResource`:
- `name`: Nome dello studio
- `phone`: Telefono
- `email`: Email
- `address`: Indirizzo (relazione con modulo Geo)

### Azioni Disponibili

Tramite `XotBaseRelationManager` sono disponibili:
- **EditAction**: Modifica dello studio
- **DetachAction**: Rimozione della relazione (non eliminazione)
- **AttachAction**: Aggiunta di nuovi studi

### Localizzazione

Le traduzioni sono gestite tramite:
- `Modules/SaluteMo/lang/{locale}/filament/relation-managers.php`
- Struttura espansa obbligatoria per tutte le label

## Best Practices Implementate

### ✅ Conformità Laraxot

1. **Namespace Corretto**: `Modules\SaluteMo\Filament\Resources\DoctorResource\RelationManagers`
2. **Estensione Base**: Usa `XotBaseRelationManager` invece di `RelationManager`
3. **No Label Hardcoded**: Nessun uso di `->label()` o stringhe hardcoded
4. **Tipizzazione Stretta**: `declare(strict_types=1)` e tipi espliciti
5. **Riuso Configurazioni**: Eredita colonne dalla risorsa invece di duplicarle

### ✅ Architettura Modulare

1. **Separazione Domini**: Modelli in SaluteOra, UI in SaluteMo
2. **Riuso Risorse**: Utilizza `StudioResource` esistente
3. **Cross-Module**: Gestisce correttamente relazioni tra moduli diversi

## Filosofia e Motivazione

### Relazione Simmetrica
- Un dottore può lavorare in più studi
- Uno studio può avere più dottori
- La relazione è bi-direzionale e flessibile

### Modello Pivot Arricchito
- `DoctorStudio` non è solo una tabella di collegamento
- Contiene logica di business specifica (orari, priorità)
- Supporta funzionalità avanzate come prenotazioni

### Cross-Database Design
- Permette scalabilità e separazione dei dati
- Mantiene coerenza tramite `belongsToManyX`
- Supporta policy multi-tenant

## Limitazioni e Considerazioni

### Performance
- Le query cross-database possono essere più lente
- Importante ottimizzare con eager loading quando necessario

### Consistenza
- Le transazioni cross-database sono limitate
- Necessario gestire l'integrità a livello applicativo

### Testing
- Richiede setup di test con multiple connessioni database
- Mock delle relazioni cross-database più complesso

## Esempi di Utilizzo

### Nell'interfaccia Filament
Il RelationManager viene automaticamente registrato nella `DoctorResource` e permette:

1. **Visualizzazione**: Lista degli studi associati al dottore
2. **Gestione**: Aggiunta/rimozione di studi dalla relazione
3. **Modifica**: Accesso diretto alla modifica dei dati studio
4. **Detach/Attach**: Gestione della relazione molti-a-molti

### Query Programmatiche
```php
// Ottieni tutti gli studi di un dottore
$doctor = Doctor::find(1);
$studios = $doctor->studios;

// Ottieni info dettagliate dal pivot
$doctorStudio = $doctor->studios()->first()->pivot;
$schedule = $doctorStudio->schedule;
$isPrimary = $doctorStudio->is_primary;
```

## Documentazione Correlata

### Modulo SaluteMo
- [Architettura SaluteMo](../architecture.md)
- [Filament Integration](../filament-integration.md)
- [StudioResource](../filament/resources/studio-resource.md)

### Modulo SaluteOra
- [RelationManager SaluteOra](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/relationmanagers.md)
- [Modello Doctor](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor.md)
- [Modello Studio](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/models/studio.md)
- [DoctorStudio Pivot](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor-studio.md)

### Root Documentation
- [Cross-Module Relations](/var/www/html/base_saluteora/docs/cross-module-relations.md)
- [Filament Best Practices](/var/www/html/base_saluteora/docs/filament-best-practices.md)

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.0*
*Compatibilità: Laraxot SaluteOra, Filament 3.x* 