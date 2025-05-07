<<<<<<< HEAD
# Sistema di Archiviazione dei Contenuti JSON

## Introduzione

Il sistema utilizza un innovativo approccio di archiviazione dei contenuti basato su file JSON anziché database tradizionali. Questo documento fornisce una panoramica del sistema e rimanda alla documentazione tecnica più dettagliata.

## Concetti Fondamentali

### Database JSON-based

Invece di utilizzare tabelle in un database relazionale, i contenuti vengono archiviati in file JSON strutturati, organizzati in directory che riflettono la struttura delle tabelle di un database tradizionale.

Vantaggi principali:
- **Versionamento**: I contenuti possono essere versionati con Git
- **Portabilità**: Facilità nel trasferire contenuti tra ambienti
- **Semplicità**: Non richiede configurazione di database complessi
- **Multi-tenant**: Supporto nativo per contenuti specifici per tenant

### Integrazione con Laravel Eloquent

Grazie all'utilizzo del pacchetto [Sushi](https://github.com/calebporzio/sushi) e del trait personalizzato `SushiToJsons`, il sistema offre una piena integrazione con l'ORM Eloquent di Laravel, consentendo di manipolare i contenuti JSON come se fossero record di database.

## Struttura dei File JSON

I file JSON sono organizzati in questa struttura:

```
laravel/config/local/{tenant}/database/content/{tabella}/{id}.json
```

Dove:
- `{tenant}` è l'identificatore del tenant
- `{tabella}` è il nome della tabella (es. "pages")
- `{id}` è l'identificatore univoco del record (es. "1")

Esempio per la homepage:
```
laravel/config/local/tenant1/database/content/pages/1.json
```

## Collegamento tra Slug e File JSON

Uno degli aspetti più importanti di questo sistema è come viene gestito il collegamento tra gli slug delle pagine (come "home" per la homepage) e i file JSON corrispondenti.

Il processo è il seguente:
1. La richiesta per una pagina include uno slug (es. "home")
2. Il `ThemeComposer` cerca una pagina con quello slug usando Eloquent
3. Sushi carica i dati dal file JSON corrispondente (es. "1.json")
4. I contenuti vengono renderizzati a partire dai blocchi definiti nel JSON

Per approfondimenti tecnici su questo meccanismo, consulta la [documentazione dettagliata nel modulo CMS](../laravel/Modules/Cms/docs/content-storage.md).

## Sezioni del FrontOffice

Le sezioni riutilizzabili del sito, come l'header e il footer, sono definite in file JSON nella directory:
```
laravel/config/local/{tenant}/database/content/sections/{id}.json
```
Ad esempio, il file `sections/1.json` contiene i blocchi (`logo`, `navigation`, `actions`) e gli attributi (`class`, `id`, `style`) per l'header principale del FrontOffice.

## Modifica dei Contenuti

### Tramite Interfaccia Amministrativa

Il modo consigliato per modificare i contenuti è utilizzare l'interfaccia amministrativa Filament, che offre:
- Editor visuale per i blocchi di contenuto
- Validazione dei dati
- Gestione delle traduzioni
- Interfaccia user-friendly

### Modifica Diretta dei JSON

In ambiente di sviluppo, è possibile modificare direttamente i file JSON. Questo può essere utile per modifiche massive o per debug, ma non è consigliato in produzione.

## Contenuti Multilingua

I contenuti possono essere tradotti in più lingue grazie al trait `HasTranslations`. I campi traducibili vengono memorizzati come oggetti JSON con chiavi per ciascuna lingua.

## Pagine a Blocchi

Una caratteristica fondamentale del sistema è la gestione delle pagine tramite blocchi di contenuto, che consente:
- Riutilizzo di componenti di UI
- Flessibilità nella composizione delle pagine
- Facilità di manutenzione e aggiornamento

Per maggiori dettagli sulla struttura dei blocchi di contenuto, consulta la [documentazione dei blocchi nel modulo CMS](../laravel/Modules/Cms/docs/content.md).

## Esempi Pratici

### Struttura del File JSON della Homepage
=======
# Sistema di Archiviazione dei Contenuti

## Introduzione

Questo documento spiega come il modulo CMS gestisce l'archiviazione dei contenuti delle pagine, concentrandosi in particolare sul meccanismo che collega lo `slug` di una pagina (come `home` per la homepage) con il corrispondente file JSON nel filesystem.

## Architettura di Storage dei Contenuti

Il modulo utilizza un approccio ibrido per la gestione dei contenuti che combina:

1. **Modelli Eloquent** per l'interazione con i dati
2. **File JSON** per la persistenza dei dati
3. **Trait Sushi** per mappare i file JSON al modello relazionale

Questo approccio offre diversi vantaggi:
- Permette di versionare i contenuti con Git
- Supporta facilmente ambienti multi-tenant
- Offre un'interfaccia familiare di Eloquent per manipolare i dati
- Mantiene la persistenza senza richiedere un database relazionale

## Il Trait SushiToJsons

Il cuore di questa architettura è il trait `SushiToJsons` che estende il pacchetto [Sushi](https://github.com/calebporzio/sushi) di Laravel, aggiungendo funzionalità per leggere e scrivere dati da e verso file JSON.

```php
trait SushiToJsons
{
    use \Sushi\Sushi;

    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);
        $files = File::glob($path.'/*.json');
        $rows = [];
        foreach ($files as $id => $file) {
            $json = File::json($file);
            $item = [];
            foreach ($this->schema ?? [] as $name => $type) {
                $value = $json[$name] ?? null;
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                }
                $item[$name] = $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    public function getJsonFile(): string
    {
        Assert::string($tbl = $this->getTable());
        Assert::string($id = $this->getKey());

        $filename = 'database/content/'.$tbl.'/'.$id.'.json';
        $file = TenantService::filePath($filename);

        return $file;
    }
    
    // Altre funzionalità omesse per brevità
}
```

## Come Funziona il Collegamento Slug-File

### 1. Struttura Generale

Ogni pagina nel sistema è rappresentata da:

- Un **record nel modello `Page`** identificato da un ID e uno slug
- Un **file JSON** corrispondente che memorizza i dati completi della pagina

### 2. Il Modello Page

Il modello `Page` nel namespace `Modules\Cms\Models` utilizza il trait `SushiToJsons` per mappare i dati JSON ai campi del modello:

```php
class Page extends BaseModel
{
    use HasTranslations;
    use SushiToJsons;
    
    // Campi traducibili
    public $translatable = [
        'title',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];
    
    // Schema dei dati
    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'content' => 'string',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        // Altri campi...
    ];
    
    // Altre funzionalità...
}
```

### 3. Mapping Slug-ID-File

Ecco il processo che collega lo slug "home" al file JSON specifico:

1. **Richiesta di Contenuto**: Quando si richiede la homepage, Laravel Folio indirizza alla vista `pages/index.blade.php`
2. **Chiamata al ThemeComposer**: La vista chiama `$_theme->showPageContent('home')`
3. **Recupero della Pagina**: `ThemeComposer` cerca la pagina con slug "home" tramite `Page::firstOrCreate(['slug' => 'home'], ...)`
4. **Caricamento dei Dati**: Sushi carica i dati chiamando `getSushiRows()` che legge tutti i file JSON dalla directory `database/content/pages`
5. **Identificazione del File**: Il file JSON viene identificato nella forma `{id}.json` (es. `1.json` per la homepage)
6. **Rendering dei Blocchi**: I blocchi di contenuto vengono estratti e renderizzati tramite il componente `\Modules\UI\View\Components\Render\Blocks`

### 4. Percorso del File JSON

Il percorso tipico di un file JSON per una pagina segue questa struttura:

```
/config/local/{tenant}/database/content/pages/{id}.json
```

Dove:
- `{id}` è l'ID univoco della pagina
- `pages` è il nome della tabella del modello Page
- `database/content` è la directory standard per i contenuti
- `{tenant}` è l'identificatore del tenant attivo

## Contenuto del File JSON della Homepage

Un tipico file JSON per una pagina contiene:
>>>>>>> feb96d7 (.)

```json
{
    "id": "1",
    "title": {
<<<<<<< HEAD
        "it": "il progetto - Homepage"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
=======
        "it": "Titolo della Pagina"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            // Array di blocchi di contenuto
>>>>>>> feb96d7 (.)
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
<<<<<<< HEAD
                    "title": "Benvenuti",
                    "subtitle": "Piattaforma per la salute orale"
=======
                    "title": "Titolo del blocco hero",
                    // Altri campi del blocco
>>>>>>> feb96d7 (.)
                }
            },
            // Altri blocchi...
        ]
<<<<<<< HEAD
    }
}
```

### Come Modificare la Homepage

Per modificare la homepage:

1. Accedere al pannello amministrativo Filament
2. Navigare alla sezione "Pagine"
3. Selezionare la pagina con slug "home"
4. Modificare i blocchi di contenuto come necessario
5. Salvare le modifiche

## Risorse Tecniche

Per approfondire il funzionamento tecnico del sistema:

- [Sistema di Archiviazione dei Contenuti](../laravel/Modules/Cms/docs/content-storage.md) - Documentazione tecnica completa
- [Gestione dei Blocchi di Contenuto](../laravel/Modules/Cms/docs/content.md) - Come funzionano i blocchi di contenuto
- [Struttura delle Pagine](../laravel/Modules/Cms/docs/page-resource.md) - Informazioni sulle risorse Page
=======
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": null,
    // Altri metadati...
}
```

## Flusso Completo di Renderizzazione della Pagina

1. L'utente visita una pagina (`/` o `/{locale}`)
2. Laravel Folio indirizza alla vista appropriata
3. La vista utilizza il layout marketing e chiama `$_theme->showPageContent('slug')`
4. `ThemeComposer` cerca la pagina con lo slug specificato
5. Sushi carica i dati dal file JSON corrispondente
6. I blocchi di contenuto vengono passati al renderer
7. Ogni blocco viene renderizzato utilizzando il componente specificato nel campo `view`
8. Il contenuto HTML viene restituito e visualizzato nella pagina

## Modificare i Contenuti

Per modificare i contenuti delle pagine, è possibile:

1. **Tramite Pannello Amministrativo**: Utilizzare l'interfaccia Filament che modifica il modello `Page` e salva le modifiche nel file JSON (approccio consigliato)

2. **Modifica Diretta del JSON**: Modificare manualmente il file JSON corrispondente. Questa operazione è sconsigliata in produzione ma può essere utile in sviluppo

## Best Practices

1. **Utilizzare Sempre Filament**: Per modificare i contenuti, utilizzare sempre l'interfaccia amministrativa Filament
2. **Versionare i File JSON**: Includere i file JSON nel controllo versione per tracciare le modifiche ai contenuti
3. **Testare dopo le Modifiche**: Verificare che le modifiche non causino problemi di visualizzazione o funzionamento
4. **Mantenere la Struttura dei Blocchi**: Rispettare la struttura esistente dei blocchi quando si creano nuovi contenuti

## Considerazioni per lo Sviluppo

1. **Multi-Tenant**: Il sistema supporta nativamente ambienti multi-tenant
2. **Traduzioni**: I contenuti possono essere tradotti utilizzando il trait `HasTranslations`
3. **Override per Tenant**: Ogni tenant può avere la propria versione dei file di contenuto
4. **Prestazioni**: I dati vengono caricati in memoria tramite Sushi, offrendo prestazioni elevate 
>>>>>>> feb96d7 (.)
