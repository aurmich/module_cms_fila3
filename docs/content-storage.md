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

```json
{
    "id": "1",
    "title": {
        "it": "Titolo della Pagina"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            // Array di blocchi di contenuto
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
                    "title": "Titolo del blocco hero",
                    // Altri campi del blocco
                }
            },
            // Altri blocchi...
        ]
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
