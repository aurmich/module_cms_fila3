# Modelli Pivot in SaluteOra

## Introduzione

I modelli pivot sono classi specializzate che gestiscono le relazioni many-to-many in Laravel. Questo documento descrive le convenzioni specifiche di SaluteOra per l'implementazione dei modelli pivot.

## Gerarchia di Ereditarietà

Tutti i modelli pivot in SaluteOra devono seguire questa gerarchia di ereditarietà:

```
Illuminate\Database\Eloquent\Relations\Pivot (Laravel)
                    ↑
Modules\SaluteOra\Models\BasePivot (SaluteOra)
                    ↑
       ModelloPivotSpecifico (es. DoctorStudio)
```

## BasePivot

La classe `BasePivot` è la base per tutti i modelli pivot nell'applicazione. Include:

- Trait `Updater` per tracciare le modifiche
- Configurazione comune come connessione al database
- Comportamenti standard per i modelli pivot

```php
abstract class BasePivot extends Pivot
{
    use Updater;
    
    // Configurazioni comuni per i pivot
}
```

## Implementazione Corretta di un Modello Pivot

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modello pivot per la relazione many-to-many tra Doctor e Studio.
 */
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
    
    // Metodi di relazione e altre funzionalità
}
```

## Errori Comuni e Come Evitarli

### Errore #1: Estendere Model invece di BasePivot

```php
// ❌ ERRATO
class DoctorStudio extends Model

// ✅ CORRETTO
class DoctorStudio extends BasePivot
```

**Conseguenza dell'errore**: Laravel si aspetta che i modelli pivot estendano `Pivot`. Quando un modello pivot estende `Model`, si ottiene l'errore "Expected an instance of Illuminate\Database\Eloquent\Relations\Pivot".

### Errore #2: Configurazioni Ridondanti

```php
// ❌ ERRATO - Ridondante, già definito in BasePivot
protected $connection = 'salute_ora';
public $incrementing = true;

// ✅ CORRETTO - Definire solo ciò che differisce dalla configurazione di BasePivot
```

## Utilizzo nei Modelli Correlati

Quando si definisce una relazione many-to-many con un modello pivot personalizzato, Laravel deve essere informato di utilizzare quel modello:

```php
// In Doctor.php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class)
        ->using(DoctorStudio::class);
}

// In Studio.php
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class)
        ->using(DoctorStudio::class);
}
```

Con il trait `RelationX`, il modello pivot viene rilevato automaticamente senza bisogno di specificarlo esplicitamente con `->using()`.

## Considerazioni Filosofiche e Tecniche

L'ereditarietà corretta nei modelli pivot riflette:

- **Principio di Specializzazione**: Un pivot è un tipo specializzato di modello con comportamento specifico
- **Principio di Sostituzione di Liskov**: Una sottoclasse deve poter sostituire la sua classe base senza alterare il corretto funzionamento del sistema
- **Onestà Semantica**: Un pivot deve dichiararsi come tale estendendo la classe appropriata

## Collegamenti a Documentazione Correlata

- [Struttura di Ereditarietà dei Modelli](inheritance-structure.md)
- [Relazioni Many-to-Many](../studio-doctor-relation.md)
- [Documentazione Laravel su Relazioni Pivot](https://laravel.com/docs/eloquent-relationships#defining-custom-intermediate-table-models)
