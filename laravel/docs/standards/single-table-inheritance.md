# Single Table Inheritance (STI) Pattern

Questo documento descrive come implementare il pattern Single Table Inheritance (STI) nelle migrazioni del progetto SaluteOra.

## Panoramica

Lo STI è un pattern che permette di memorizzare diverse classi di oggetti in un'unica tabella del database, dove un campo `type` determina la classe specifica a cui appartiene ciascun record.

## Implementazione

### Struttura della Tabella

```php
Schema::create('entities', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // Determina la classe dell'entità
    // Campi comuni a tutte le entità
    $table->timestamps();
});
```

### Esempio di Classe Base

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $table = 'entities';
    
    protected $fillable = [
        'type',
        // altri campi comuni
    ];
    
    protected static function booted()
    {
        static::addGlobalScope('type', function ($builder) {
            $builder->where('type', static::class);
        });
        
        static::creating(function ($model) {
            $model->type = $model->type ?: static::class;
        });
    }
}
```

### Esempio di Sottoclasse

```php
namespace App\Models;

class Doctor extends Entity
{
    protected $table = 'entities';
    
    protected static function booted()
    {
        parent::booted();
        
        static::addGlobalScope('type', function ($builder) {
            $builder->where('type', static::class);
        });
    }
    
    // Metodi specifici del dottore
}
```

## Vantaggi

- Riduzione del numero di tabelle nel database
- Facilità di interrogazione tra tipi correlati
- Migliore gestione delle relazioni

## Svantaggi

- La tabella può diventare molto grande
- I campi non utilizzati da alcune sottoclassi rimangono null
- Più complesso da gestire con modifiche allo schema

## Best Practice

1. Usare sempre un campo `type` di tipo stringa
2. Documentare chiaramente la gerarchia delle classi
3. Considerare l'uso di trait per condividere funzionalità comuni
4. Implementare scope globali per filtrare automaticamente i tipi
5. Considerare l'uso di classi astratte per la classe base
