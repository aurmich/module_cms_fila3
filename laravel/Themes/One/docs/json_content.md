# Gestione Contenuti JSON

## Struttura Base

I contenuti delle pagine sono gestiti attraverso file JSON che seguono questa struttura:

```json
{
    "id": "page_id",
    "title": {
        "it": "Titolo Pagina",
        "en": "Page Title"
    },
    "slug": "page-slug",
    "content_blocks": {
        "it": [],
        "en": []
    }
}
```

## Posizione dei File

```
{config_path}/
└── database/
    └── content/
        └── pages/
            ├── default.json   # Template di default
            └── {page_id}.json # Pagine specifiche
```

## Tipi di Blocchi

### 1. Hero Block
```json
{
    "type": "hero",
    "data": {
        "view": "components.blocks.hero.simple",
        "title": "Titolo Hero",
        "subtitle": "Sottotitolo",
        "image": "/path/to/image.jpg",
        "cta_text": "Call to Action",
        "cta_link": "/action"
    }
}
```

#### Gestione delle Espressioni Blade nei Link

**Problema**: Quando si inseriscono espressioni Blade come `{{ route('register') }}` nel campo `cta_link` di un file JSON, queste vengono interpretate come stringhe letterali e non come codice Blade da eseguire.

**Esempio problematico**:
```json
{
    "type": "hero",
    "data": {
        "cta_link": "{{ route('register') }}"
    }
}
```

Quando questo JSON viene passato alla blade `simple.blade.php`, il link diventa letteralmente `{{ route('register') }}` invece dell'URL generato dalla funzione route.

**Soluzioni possibili**:

1. **Modifica della Blade**: Aggiungere logica nella blade per riconoscere e valutare le espressioni Blade:
   ```php
   @php
   // Verifica se il link contiene un'espressione Blade
   $linkPattern = '/^\{\{\s*(.+?)\s*\}\}$/'; // Cerca pattern {{ ... }}
   $finalLink = $cta_link;
   
   if (preg_match($linkPattern, $cta_link, $matches)) {
       // Estrai l'espressione e valutala
       $expression = $matches[1];
       // Usa eval() con cautela o un sistema più sicuro
       try {
           $finalLink = eval("return {$expression};");
       } catch (\Exception $e) {
           // Gestione errori
           $finalLink = '#';
       }
   }
   @endphp
   
   <a href="{{ $finalLink }}" ...>
   ```

2. **Preelaborazione dei Dati JSON**: Elaborare i dati JSON prima di passarli alla blade:
   ```php
   // In un service o controller
   foreach ($contentBlocks as &$block) {
       if (isset($block['data']['cta_link'])) {
           $link = $block['data']['cta_link'];
           // Verifica e valuta le espressioni Blade
           if (preg_match('/^\{\{\s*(.+?)\s*\}\}$/', $link, $matches)) {
               $expression = $matches[1];
               $block['data']['cta_link'] = eval("return {$expression};");
           }
       }
   }
   ```

3. **Approccio con Funzioni Helper**: Usare funzioni helper nei file JSON invece di espressioni Blade complete:
   ```json
   {
       "type": "hero",
       "data": {
           "cta_link": "@route:register"
       }
   }
   ```
   
   E nella blade:
   ```php
   @php
   $finalLink = $cta_link;
   if (strpos($cta_link, '@route:') === 0) {
       $routeName = substr($cta_link, 7);
       $finalLink = route($routeName);
   }
   @endphp
   ```

**Raccomandazione**: L'opzione 3 è la più pulita e sicura, poiché evita l'uso di `eval()` e mantiene una chiara separazione tra dati e logica.

### Nota sul **Hero Block** (`components.blocks.hero.simple`)

Il problema si manifesta in particolare nella blade `Themes/One/resources/views/components/blocks/hero/simple.blade.php`, dove il link del bottone è reso con:

```blade
<a href="{{ $cta_link }}" ...>
```

Se `cta_link` contiene `{{ route('register') }}` (o altre espressioni Blade) provenienti dal JSON, l'espressione **non viene valutata** e diventa una stringa letterale.

#### Linee Guida
1. **Evitare** di inserire espressioni Blade nei file JSON. Usare percorsi assoluti/relativi o placeholder come `@route:register` da pre-processare.
2. **Pre-processing consigliato**: trasformare i placeholder in URL reali (vedi punto 2 sopra) in un service/composer prima di passare i dati alla view.
3. **Documentare** nel README del tema e nei template JSON che i campi URL non devono contenere sintassi Blade.

Queste indicazioni evitano il rischio di XSS/eval e mantengono separazione chiara tra contenuti e logica di routing.

### 2. Feature Sections Block
```json
{
    "type": "feature_sections",
    "data": {
        "view": "components.blocks.feature_sections.v1",
        "title": "Titolo Sezione",
        "sections": [
            {
                "title": "Feature 1",
                "description": "Descrizione feature",
                "icon": "heroicon-o-shield-check"
            }
        ]
    }
}
```

### 3. Stats Block
```json
{
    "type": "stats",
    "data": {
        "view": "components.blocks.stats.v1",
        "title": "Statistiche",
        "stats": [
            {
                "number": "100+",
                "label": "Label Statistica"
            }
        ]
    }
}
```

### 4. CTA Block
```json
{
    "type": "cta",
    "data": {
        "view": "components.blocks.cta.v1",
        "title": "Titolo CTA",
        "description": "Descrizione",
        "button_text": "Azione",
        "button_link": "/action"
    }
}
```

## Implementazione

### View Composer
```php
namespace Theme\View\Composers;

class ContentComposer
{
    public function compose(View $view)
    {
        $pageId = $view->getData()['page_id'] ?? 'default';
        $content = $this->loadContent($pageId);
        $view->with('content', $content);
    }

    protected function loadContent(string $pageId): array
    {
        $path = config_path("database/content/pages/{$pageId}.json");
        return json_decode(file_get_contents($path), true);
    }
}
```

### Rendering dei Blocchi
```php
namespace Theme\View\Components;

class RenderBlock extends Component
{
    public function render(): View
    {
        return view($this->data['view'], $this->data);
    }
}
```

## Multilingua

### Struttura
```json
{
    "title": {
        "it": "Titolo Italiano",
        "en": "English Title"
    },
    "content_blocks": {
        "it": [
            // Blocchi in italiano
        ],
        "en": [
            // Blocchi in inglese
        ]
    }
}
```

### Gestione Lingua
```php
public function getContent(string $locale = null): array
{
    $locale = $locale ?? app()->getLocale();
    return $this->content['content_blocks'][$locale] ?? [];
}
```

## Validazione

### Schema JSON
```json
{
    "type": "object",
    "required": ["id", "title", "slug", "content_blocks"],
    "properties": {
        "id": {
            "type": "string"
        },
        "title": {
            "type": "object",
            "patternProperties": {
                "^[a-z]{2}$": {
                    "type": "string"
                }
            }
        },
        "slug": {
            "type": "string",
            "pattern": "^[a-z0-9-]+$"
        },
        "content_blocks": {
            "type": "object",
            "patternProperties": {
                "^[a-z]{2}$": {
                    "type": "array",
                    "items": {
                        "type": "object",
                        "required": ["type", "data"],
                        "properties": {
                            "type": {
                                "type": "string"
                            },
                            "data": {
                                "type": "object"
                            }
                        }
                    }
                }
            }
        }
    }
}
```

### Validazione PHP
```php
public function validate(array $content): bool
{
    $validator = Validator::make($content, [
        'id' => 'required|string',
        'title' => 'required|array',
        'title.*' => 'required|string',
        'slug' => 'required|string|regex:/^[a-z0-9-]+$/',
        'content_blocks' => 'required|array',
        'content_blocks.*' => 'required|array'
    ]);

    return $validator->passes();
}
```

## Cache

### Configurazione
```php
// config/content.php
return [
    'cache' => [
        'enabled' => true,
        'ttl' => 3600 // 1 ora
    ]
];
```

### Implementazione
```php
public function getContent(string $pageId): array
{
    $cacheKey = "content.page.{$pageId}";
    
    if (config('content.cache.enabled')) {
        return Cache::remember($cacheKey, config('content.cache.ttl'), function () use ($pageId) {
            return $this->loadContent($pageId);
        });
    }
    
    return $this->loadContent($pageId);
}
```

## Best Practices

1. **Organizzazione**
   - Un file JSON per pagina
   - Struttura coerente dei blocchi
   - Nomi descrittivi per i file

2. **Manutenibilità**
   - Validare sempre il JSON
   - Mantenere la documentazione aggiornata
   - Utilizzare costanti per i tipi di blocchi

3. **Performance**
   - Implementare caching appropriato
   - Ottimizzare le dimensioni dei file JSON
   - Lazy loading per contenuti pesanti

4. **Versionamento**
   - Mantenere backup dei file JSON
   - Tracciare le modifiche
   - Implementare rollback se necessario 
