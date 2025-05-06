# Blocchi di Contenuto

Questo documento descrive i blocchi disponibili per la gestione delle sezioni tramite `SectionResource`.

## Panoramica di SectionResource

Il `SectionResource` utilizza un campo `blocks` per consentire la creazione e l'organizzazione di blocchi di contenuto:

```php
// SectionResource.php
'blocks' => Forms\Components\Section::make('Content')
    ->schema([
        SectionBuilder::make('blocks')->columnSpanFull(),
    ]),
```

Il builder carica dinamicamente tutte le classi di blocco presenti in:
- `Modules/Cms/app/Filament/Blocks`
- `Modules/UI/app/Filament/Blocks`

## SectionBuilder

- Recupera le classi dei blocchi tramite `GetAllBlocksAction`.
- Invoca `BlockClass::make(string $context)` per ogni blocco.
- Restituisce un `Builder` con tutti i blocchi registrati.

## Blocchi Disponibili

### NavigationBlock

- **Type**: `navigation`
- **Classe**: `Modules\Cms\Filament\Blocks\NavigationBlock`
- **Scopo**: gestire le voci del menu di navigazione.
- **[Documentazione dettagliata](blocks/navigation.md)**

### HeroBlock

- **Type**: `hero`
- **Classe**: `Modules\Cms\Filament\Blocks\HeroBlock`
- **Scopo**: creare sezioni hero con immagine di sfondo e call-to-action.
- **[Documentazione dettagliata](blocks/hero.md)**

### ParagraphBlock

- **Type**: `paragraph`
- **Classe**: `Modules\Cms\Filament\Blocks\ParagraphBlock`
- **Scopo**: gestire contenuti testuali formattati.
- **[Documentazione dettagliata](blocks/paragraph.md)**

### FeatureSectionsBlock

- **Type**: `feature_sections`
- **Classe**: `Modules\Cms\Filament\Blocks\FeatureSectionsBlock`
- **Scopo**: presentare caratteristiche con icone e descrizioni.
- **[Documentazione dettagliata](blocks/feature-sections.md)**

### StatsBlock

- **Type**: `stats`
- **Classe**: `Modules\Cms\Filament\Blocks\StatsBlock`
- **Scopo**: visualizzare statistiche e metriche chiave.
- **[Documentazione dettagliata](blocks/stats.md)**

### CtaBlock

- **Type**: `cta`
- **Classe**: `Modules\Cms\Filament\Blocks\CtaBlock`
- **Scopo**: creare sezioni di chiamata all'azione.
- **[Documentazione dettagliata](blocks/cta.md)**

### FooterInfoBlock

- **Type**: `footer.info`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterInfoBlock`
- **Scopo**: gestire le informazioni principali del footer.
- **[Documentazione dettagliata](blocks/footer-info.md)**

### FooterLinksBlock

- **Type**: `footer.links`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterLinksBlock`
- **Scopo**: gestire i link di navigazione nel footer.
- **[Documentazione dettagliata](blocks/footer-links.md)**

### FooterSocialBlock

- **Type**: `footer.social`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterSocialBlock`
- **Scopo**: gestire i link ai social media nel footer.
- **[Documentazione dettagliata](blocks/footer-social.md)**

### FooterContactBlock

- **Type**: `footer.contact`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterContactBlock`
- **Scopo**: gestire le informazioni di contatto nel footer.
- **[Documentazione dettagliata](blocks/footer-contact.md)**

### FooterNewsletterBlock

- **Type**: `footer.newsletter`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterNewsletterBlock`
- **Scopo**: gestire il form di iscrizione alla newsletter nel footer.
- **[Documentazione dettagliata](blocks/footer-newsletter.md)**

### FooterQuickLinksBlock

- **Type**: `footer.quick-links`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterQuickLinksBlock`
- **Scopo**: gestire i link rapidi nel footer.
- **[Documentazione dettagliata](blocks/footer-quick-links.md)**

## Aggiungere un Nuovo Blocco

1. Creare `Modules/Cms/app/Filament/Blocks/YourBlock.php`.
2. Definire una classe con `public static function make(string $context): Block`.
3. Restituire `Block::make('<type>')` con `label()` e `schema()` appropriati.
4. Aggiungere le traduzioni in `lang/<locale>/blocks.php`.
5. Creare la documentazione in `docs/blocks/your-block.md`.

## Best Practices

1. **Naming**:
   - Utilizzare nomi descrittivi per i blocchi
   - Seguire le convenzioni di naming Laravel
   - Mantenere coerenza con gli altri blocchi

2. **Struttura**:
   - Estendere `XotBaseBlock`
   - Implementare `getBlockSchema()`
   - Documentare tutti i campi

3. **Validazione**:
   - Definire regole di validazione appropriate
   - Utilizzare messaggi di errore chiari
   - Gestire correttamente i campi obbligatori

4. **Documentazione**:
   - Mantenere la documentazione aggiornata
   - Includere esempi di utilizzo
   - Specificare best practices

## Collegamenti

- [Filament Forms](filament-forms.md)
- [UI Components](ui/components.md)
- [Content Management](content.md)
- [Best Practices](best-practices/index.md)

# Blocchi CMS

## Struttura dei Blocchi

Ogni blocco nel CMS segue una struttura comune:

```php
[
    "name" => [
        "it" => "Nome Blocco",
        "en" => "Block Name"
    ],
    "type" => "tipo_blocco",
    "data" => [
        // Dati specifici del blocco
    ]
]
```

## Best Practices

### 1. Internazionalizzazione

- Tutti i testi devono supportare la traduzione
- Utilizzare array associativi per le traduzioni:
```php
"label" => [
    "it" => "Etichetta",
    "en" => "Label"
]
```
- Gestire i fallback per le traduzioni mancanti:
```php
$label = is_array($item['label']) ? ($item['label'][$locale] ?? '') : ($item['label'] ?? '');
```

### 2. Gestione URL

- Gli URL possono essere sia stringhe che array tradotti
- Implementare la stessa logica di fallback degli altri campi:
```php
$url = is_array($item['url']) ? ($item['url'][$locale] ?? '#') : ($item['url'] ?? '#');
```

### 3. Stili e Classi

- Definire array di classi per ogni variante di stile
- Utilizzare classi base comuni per tutti gli elementi dello stesso tipo
- Organizzare le classi per funzionalità:
```php
$buttonClasses = [
    'primary' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700',
    'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50',
    'outline' => 'border-primary-600 text-primary-600 bg-transparent hover:bg-primary-50',
    'link' => 'text-primary-600 hover:text-primary-900 underline'
];
```

### 4. Layout e Spaziatura

- Utilizzare sistemi di spaziatura coerenti
- Supportare diverse configurazioni di allineamento
- Definire valori predefiniti sensati:
```php
$gapClasses = [
    2 => 'space-x-2',
    3 => 'space-x-3',
    4 => 'space-x-4', // default
    5 => 'space-x-5',
    6 => 'space-x-6',
    8 => 'space-x-8'
];
```

### 5. Accessibilità

- Includere sempre stati di focus visibili
- Aggiungere attributi ARIA quando necessario
- Utilizzare target appropriati per i link
- Mantenere un contrasto adeguato nei colori

## Tipi di Blocchi

### 1. Navigation Block
- Supporta menu multilivello
- Gestisce orientamento orizzontale/verticale
- Supporta dropdown per sottomenu
- Configurazione flessibile dell'allineamento

### 2. Actions Block
- Supporta multiple varianti di pulsanti
- Integrazione con icone
- Spaziatura configurabile
- Allineamento flessibile

### 3. Logo Block
- Supporta sia immagini che testo
- Gestisce dimensioni configurabili
- Supporta link personalizzati
- Gestisce alt text multilingua

## Validazione

Ogni blocco dovrebbe implementare:
1. Valori predefiniti per tutti i parametri opzionali
2. Controlli di tipo per i dati in ingresso
3. Fallback per dati mancanti o non validi

## Performance

- Minimizzare le chiamate al database
- Utilizzare cache per i dati statici
- Ottimizzare le query per i contenuti dinamici
- Lazy loading per le immagini quando appropriato

## Sicurezza

- Sanitizzare tutti gli input
- Escape corretto dell'output HTML
- Validazione degli URL
- Controllo dei permessi quando necessario

## Manutenibilità

1. Separare la logica in componenti riutilizzabili
2. Mantenere una struttura coerente tra i blocchi
3. Documentare le opzioni di configurazione
4. Utilizzare costanti per valori comuni

## Testing

Ogni blocco dovrebbe avere test per:
1. Rendering corretto
2. Gestione delle traduzioni
3. Comportamento responsive
4. Gestione degli errori
5. Accessibilità

## Collegamenti tra versioni di blocks.md
* [blocks.md](laravel/Modules/Xot/docs/blocks.md)
* [blocks.md](laravel/Modules/User/resources/views/docs/blocks.md)
* [blocks.md](laravel/Modules/UI/docs/blocks.md)
* [blocks.md](laravel/Modules/Cms/docs/blocks.md)
* [blocks.md](laravel/Themes/One/docs/blocks.md)
* [blocks.md](laravel/Themes/One/docs/components/blocks.md)

