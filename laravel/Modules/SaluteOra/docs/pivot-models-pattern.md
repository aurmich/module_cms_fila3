# Pattern per Modelli Pivot in SaluteOra

## Introduzione

Questo documento descrive il corretto pattern di implementazione per i modelli pivot nel sistema SaluteOra, illustrando le best practice, i requisiti di tipizzazione e le convenzioni di ereditarietà.

## Struttura di Ereditarietà

### Pattern Corretto

```
Illuminate\Database\Eloquent\Relations\Pivot
    ↓
Modules\SaluteOra\Models\BasePivot
    ↓
Modules\SaluteOra\Models\{ModelName}  (es. DoctorStudio)
```

### Errore Comune 

```
Illuminate\Database\Eloquent\Model  // ERRATO per modelli pivot
    ↓
Modules\SaluteOra\Models\{ModelName}
```

## Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorStudio extends BasePivot
{
    /**
     * La tabella associata al modello.
     *
     * @var string
     */
    protected $table = 'doctor_studio';
    
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'doctor_id',
        'studio_id',
        'schedule',
        'is_primary',
    ];

    /**
     * Gli attributi che devono essere convertiti.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'schedule' => 'array',
            'is_primary' => 'boolean',
        ]);
    }
    
    // Relazioni e altri metodi...
}
```

## Motivazioni Fondamentali

### Motivazione Tecnica

Quando si utilizza il metodo `belongsToManyX()` o `belongsToMany()->using()` in Laravel, il framework si aspetta che la classe specificata come modello pivot sia un'istanza di `Illuminate\Database\Eloquent\Relations\Pivot`. Questo è un requisito di tipo stretto che garantisce la coerenza e il funzionamento corretto delle relazioni many-to-many.

Se la classe estende `Model` invece di `Pivot` (o una classe che estende `Pivot` come `BasePivot`), si otterrà l'errore:

```
Expected an instance of Illuminate\Database\Eloquent\Relations\Pivot. Got: Modules\SaluteOra\Models\DoctorStudio
```

### Motivazione Filosofica

L'ereditarietà in programmazione orientata agli oggetti rappresenta una relazione "è un", non semplicemente una condivisione di comportamento. Un modello pivot non è semplicemente un modello qualsiasi, ma un tipo specifico di modello con un comportamento e uno scopo particolare nell'ecosistema delle relazioni.

### Motivazione Zen

La semplicità risiede nel seguire il flusso naturale dell'implementazione di Laravel. Estendendo `BasePivot` (che estende `Pivot`), non stiamo combattendo contro il framework ma abbracciando la sua saggezza e struttura.

## Differenze Fondamentali con Model Standard

### 1. Gestione delle Relazioni

I modelli pivot hanno una gestione speciale delle chiavi esterne e delle relazioni parent-child che è ottimizzata per il caso d'uso many-to-many.

### 2. Caratteristiche Specifiche

- **Timestamp Personalizzati**: `Pivot` offre controllo sui nomi delle colonne per i timestamp
- **Chiavi Esterne Personalizzate**: È possibile specificare facilmente nomi personalizzati
- **Attributi Extra**: I modelli pivot gestiscono automaticamente gli attributi "pivot"

### 3. Convenzioni di Tabella

Le tabelle pivot seguono convenzioni di denominazione specifiche (generalmente nomi_modelli in ordine alfabetico).

## Metodo casts() vs. Proprietà $casts

Nel sistema SaluteOra, per i modelli pivot è preferibile utilizzare il metodo `casts()` che restituisce un array, consentendo di ereditare i cast dalla classe parent:

```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'schedule' => 'array',
        'is_primary' => 'boolean',
    ]);
}
```

Invece di:

```php
protected $casts = [
    'schedule' => 'array',
    'is_primary' => 'boolean',
];
```

Questo approccio garantisce che i cast definiti nella classe `BasePivot` vengano mantenuti e rispetta il principio di estensibilità OOP.

## Considerazioni Sulle Migrazioni

Le migrazioni per le tabelle pivot dovrebbero:

1. Utilizzare `$table->id()` per la chiave primaria autoincrement
2. Utilizzare campi `uuid()` per le chiavi esterne
3. Aggiungere un vincolo di unicità sulle colonne di relazione
4. Implementare `updateTimestamps()` tramite tableUpdate

## Collegamenti Ad Altri Documenti

- [Documentazione su RelationX](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/relationx-trait-usage.md)
- [Relazione Studio-Doctor](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/studio-doctor-relation.md)
- [Convenzioni di Migrazione XotBase](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/xot-base-migration-conventions.md)
