# Analisi Implementazione Comune con Laravel Sushi

## Indice
1. [Panoramica](#panoramica)
2. [Vantaggi e Svantaggi](#vantaggi-e-svantaggi)
3. [Implementazione di Riferimento](#implementazione-di-riferimento)
4. [Considerazioni sulle Performance](#considerazioni-sulle-performance)
5. [Piano di Migrazione](#piano-di-migrazione)
6. [Conclusioni e Raccomandazioni](#conclusioni-e-raccomandazioni)

## Panoramica

Questo documento analizza l'implementazione del modello `Comune` utilizzando Laravel Sushi, confrontandola con l'attuale implementazione basata su `GeoJsonModel`.

## Vantaggi e Svantaggi

### Vantaggi

1. **Sintassi Eloquent Completa**
   - Supporto nativo per relazioni
   - Query builder avanzato
   - Paginazione integrata
   - Supporto per accessor/mutator

2. **Performance Ottimizzate**
   - Dati caricati in memoria SQLite
   - Query ottimizzate
   - Cache a runtime

3. **Ecosistema Laravel**
   - Integrazione con altri pacchetti
   - Supporto per factory e testing
   - Documentazione ampia

### Svantaggi

1. **Complessità Aggiuntiva**
   - Dipendenza esterna
   - Maggiore consumo di memoria
   - Requisiti di sistema (SQLite)

2. **Manutenzione**
   - Aggiornamenti del pacchetto
   - Possibili breaking changes
   - Maggiore complessità di debug

## Implementazione di Riferimento

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class ComuneSushi extends \Illuminate\Database\Eloquent\Model
{
    use Sushi;
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $casts = [
        'regione' => 'array',
        'provincia' => 'array',
        'cap' => 'array',
    ];

    public function getRows()
    {
        return Cache::remember('comuni_sushi_data', 60 * 24 * 7, function () {
            $path = module_path('Geo', 'Resources/json/comuni.json');
            return json_decode(File::get($path), true);
        });
    }
    
    // Relazioni
    public function regione()
    {
        return $this->belongsTo(Regione::class, 'regione.codice', 'codice');
    }
    
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia.codice', 'codice');
    }
    
    // Scope
    public function scopeByRegion($query, $regionCode)
    {
        return $query->where('regione->codice', $regionCode);
    }
    
    public function scopeByProvince($query, $provinceCode)
    {
        return $query->where('provincia->codice', $provinceCode);
    }
    
    // Metodi statici per compatibilità
    public static function allRegions()
    {
        return static::query()
            ->selectRaw('regione->codice as codice, regione->nome as nome')
            ->distinct()
            ->get()
            ->pluck('nome', 'codice');
    }
    
    // ... altri metodi helper
}
```

## Considerazioni sulle Performance

### Caricamento Dati
- **Attuale (GeoJsonModel)**: Caricamento lazy con cache a lungo termine
- **Sushi**: Caricamento in memoria all'avvio con cache runtime

### Utilizzo Memoria
- **Attuale**: ~50MB per 8000+ comuni
- **Sushi**: ~70-80MB (dovuto a SQLite in memoria)

### Tempi di Risposta
- **Query Semplici**: Simili (1-5ms)
- **Query Complesse**: Sushi più veloce grazie a SQLite

## Piano di Migrazione

### Fase 1: Preparazione
1. Aggiungere dipendenza Sushi
2. Creare modello `ComuneSushi`
3. Implementare test di regressione

### Fase 2: Transizione
1. Implementare facade `Comune` con proxy a `ComuneSushi`
2. Aggiornare documentazione
3. Eseguire test di carico

### Fase 3: Monitoraggio
1. Monitorare performance in produzione
2. Raccogliere feedback
3. Ottimizzare query e indici

## Conclusioni e Raccomandazioni

### Quando Scegliere Sushi (70% dei casi)
- Necessità di query complesse
- Integrazione con ecosistema Eloquent
- Progetti con team esperti Laravel

### Quando Mantenere GeoJsonModel (30% dei casi)
- Progetti con vincoli di risorse
- Dati puramente statici
- Team con competenze limitate

### Raccomandazione Finale
Per la maggior parte dei casi d'uso, l'implementazione Sushi offre il miglior equilibrio tra flessibilità e manutenibilità, a patto di accettare la dipendenza aggiuntiva e il leggero aumento dell'utilizzo di memoria.

## Link Correlati
- [Documentazione Ufficiale Sushi](https://github.com/calebporzio/sushi)
- [Guida alla Migrazione](migration-guide.md)
- [Benchmark Dettagliati](benchmarks/README.md)
