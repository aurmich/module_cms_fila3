# Analisi di SushiToJsons per l'Implementazione di Comune

## Overview del Trait SushiToJsons

`SushiToJsons` è un trait personalizzato presente nel modulo Tenant che estende le funzionalità di Laravel Sushi, aggiungendo capacità di persistenza dei dati in file JSON individuali. Questo approccio rappresenta un'implementazione ibrida che combina:

1. La potenza del query builder di Eloquent tramite Sushi
2. Un sistema di persistenza basato su file JSON individuali
3. Gestione automatizzata degli eventi del ciclo di vita del modello

### Caratteristiche principali di SushiToJsons

1. **Caricamento dati da file multipli**:
   - Ogni record è memorizzato in un file JSON separato
   - I file JSON sono organizzati in directory basate sul nome della tabella
   - I dati vengono caricati e combinati in un unico array per Sushi

2. **Persistenza automatica**:
   - Hook su eventi Eloquent (creating, updating, deleting)
   - Sincronizzazione automatica tra modello e file JSON
   - Gestione di timestamps e campi di auditing (created_by, updated_by)

3. **Gestione dello schema**:
   - Utilizzo della proprietà `$schema` per definire la struttura dei dati
   - Conversione automatica di array in JSON durante salvataggio/caricamento
   - Validazione implicita tramite Assert

## Confronto con l'Implementazione Attuale di Comune

| Aspetto | Comune Attuale | SushiToJsons |
|---------|---------------|--------------|
| **Origine dati** | Singolo file JSON | File JSON multipli (uno per record) |
| **Modificabilità** | Read-only | Read-write con persistenza |
| **Struttura** | Caricamento in memoria tramite Collection | Database SQLite tramite Sushi |
| **Performance** | Ottimizzata per lettura | Bilanciata tra lettura e scrittura |
| **Auditing** | Non supportato | Supporto nativo per created_by/updated_by |

## Applicabilità di SushiToJsons a Comune

### Vantaggi dell'Utilizzo di SushiToJsons per Comune (65% favorevole)

1. **Persistenza dei dati (95%)**:
   - Possibilità di modificare i dati geografici tramite l'API Eloquent
   - Salvataggio automatico in file JSON individuali
   - Tracciamento delle modifiche tramite campi di auditing

2. **API Eloquent completa (90%)**:
   - Mantenimento di tutti i vantaggi di Sushi
   - Supporto per query builder, relazioni, ecc.
   - Possibilità di utilizzare scope e altre funzionalità Eloquent

3. **Integrazione con il sistema esistente (85%)**:
   - Riutilizzo di codice già testato nel progetto
   - Coerenza con l'approccio utilizzato in altri moduli
   - Sfruttamento dell'infrastruttura TenantService esistente

4. **Gestione degli eventi del ciclo di vita (80%)**:
   - Hook automatici per creating/updating/deleting
   - Possibilità di estendere la logica di business in questi hook
   - Sincronizzazione automatica tra modello e storage

### Svantaggi dell'Utilizzo di SushiToJsons per Comune (35% sfavorevole)

1. **Overhead per dataset grandi (95%)**:
   - Un file per ogni comune (circa 8000 file)
   - Caricamento potenzialmente lento all'avvio
   - Consumo elevato di memoria e I/O disco

2. **Complessità non necessaria (90%)**:
   - I dati geografici sono raramente modificati
   - Overhead di persistenza per dati essenzialmente statici
   - Complessità aggiuntiva per un caso d'uso principalmente di lettura

3. **Dipendenza da TenantService (85%)**:
   - Accoppiamento con logiche specifiche del modulo Tenant
   - Necessità di adattamenti per funzionare nel modulo Geo
   - Potenziali problemi di manutenibilità a lungo termine

4. **Performance subottimali per lettura (80%)**:
   - Caricamento di migliaia di file JSON individuali
   - Conversione ripetuta tra formati
   - Inefficienza rispetto a un singolo file JSON precaricato

## Implementazione Proposta per Comune con SushiToJsons

Per implementare `Comune` utilizzando il trait `SushiToJsons`, sarebbe necessario adattare l'approccio attuale. Ecco una possibile implementazione:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToJsons;

class Comune extends Model
{
    use SushiToJsons;
    
    /**
     * Indica a Sushi di non utilizzare timestamps
     */
    public $timestamps = false;
    
    /**
     * Definizione dello schema per i campi
     */
    protected $schema = [
        'codice' => 'string',
        'nome' => 'string',
        'regione' => 'array',
        'provincia' => 'array',
        'cap' => 'array',
        'codiceCatastale' => 'string',
        'popolazione' => 'integer'
    ];
    
    /**
     * Cast per le colonne JSON
     */
    protected $casts = [
        'regione' => 'array',
        'provincia' => 'array',
        'cap' => 'array',
    ];
    
    /**
     * Recupera le regioni
     */
    public function scopeByRegion($query, string $regionCode)
    {
        return $query->where('regione->codice', $regionCode)
                     ->orderBy('nome');
    }
    
    // Implementazione di altri metodi e scope...
    
    /**
     * Prepopola i file JSON dai dati esistenti (da eseguire una tantum)
     */
    public static function populateJsonFiles(): void
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        $comuni = json_decode(file_get_contents($path), true);
        
        $basePath = TenantService::filePath('database/content/comuni');
        
        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true, true);
        }
        
        foreach ($comuni as $index => $comune) {
            $id = $index + 1;
            $comune['id'] = $id;
            $content = json_encode($comune, JSON_PRETTY_PRINT);
            File::put($basePath . '/' . $id . '.json', $content);
        }
    }
}
```

### Considerazioni sull'Implementazione

1. **Migrazione dei dati (90% cruciale)**:
   - Necessità di convertire l'attuale formato JSON singolo in file multipli
   - Script di migrazione per prepopolare i file JSON individuali
   - Gestione di potenziali inconsistenze durante la migrazione

2. **Adattamenti al trait (85% necessari)**:
   - Possibile necessità di estendere `SushiToJsons` per adattarlo al modulo Geo
   - Rimozione delle dipendenze da TenantService
   - Ottimizzazioni per gestire dataset di grandi dimensioni

3. **Manutenibilità a lungo termine (80% considerazione)**:
   - Valutazione dell'impatto sulla manutenzione futura
   - Documentazione dettagliata dell'approccio
   - Strategie di backup e ripristino

## Approccio Alternativo: Ibrido Personalizzato

Un approccio alternativo potrebbe essere quello di creare un trait specifico per il modulo Geo che si ispiri a `SushiToJsons` ma con ottimizzazioni per il caso d'uso specifico:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

trait GeoSushi
{
    use \Sushi\Sushi;
    
    protected const CACHE_TTL = 604800; // 1 settimana
    
    public function getRows()
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        $cacheKey = 'geo_comuni_json_' . md5($path);
        
        return Cache::rememberForever($cacheKey, function () use ($path) {
            return json_decode(file_get_contents($path), true);
        });
    }
    
    protected function sushiShouldCache()
    {
        return true;
    }
    
    protected function sushiCacheReferencePath()
    {
        return module_path('Geo', 'resources/json/comuni.json');
    }
    
    /**
     * Metodo per aggiornare il file JSON principale
     * Implementa la logica di persistenza solo quando necessaria
     */
    public static function updateJsonData(array $updates): bool
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        $data = json_decode(file_get_contents($path), true);
        
        foreach ($updates as $update) {
            $index = array_search($update['codice'], array_column($data, 'codice'));
            if ($index !== false) {
                $data[$index] = array_merge($data[$index], $update);
            }
        }
        
        $result = file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        
        if ($result) {
            // Invalida la cache
            static::clearSushiCache();
            Cache::forget('geo_comuni_json_' . md5($path));
            return true;
        }
        
        return false;
    }
}
```

Questo approccio:
1. Mantiene l'efficienza del caricamento da un singolo file JSON
2. Aggiunge funzionalità per aggiornare il file JSON quando necessario
3. Gestisce l'invalidazione della cache in modo esplicito
4. Evita l'overhead di migliaia di file individuali

## Conclusione e Raccomandazione

Dopo un'analisi approfondita del trait `SushiToJsons` e delle sue potenziali applicazioni al modello `Comune`, possiamo trarre le seguenti conclusioni:

1. **Utilizzo diretto di SushiToJsons (50% favorevole)**:
   - Pro: Riutilizzo di codice esistente, persistenza nativa
   - Contro: Overhead significativo, complessità non necessaria

2. **Approccio ibrido personalizzato (85% favorevole)**:
   - Pro: Mantiene l'efficienza per lettura, aggiunge persistenza quando necessaria
   - Contro: Richiede sviluppo di un nuovo trait

3. **Implementazione Sushi pura (75% favorevole)**:
   - Pro: Semplicità, manutenibilità, performance
   - Contro: Funzionalità di persistenza limitate

### Raccomandazione Finale

**Raccomandiamo l'approccio ibrido personalizzato (GeoSushi)** che combina:
1. L'efficienza di caricamento del singolo file JSON
2. Le funzionalità di query di Laravel Sushi
3. Un meccanismo di persistenza semplificato per aggiornamenti occasionali

Questo approccio offre il miglior equilibrio tra performance, flessibilità e manutenibilità per il caso specifico del modello `Comune` nel modulo Geo.

---

*Documento creato il: 28/05/2025*  
*Autore: Team SaluteOra*
