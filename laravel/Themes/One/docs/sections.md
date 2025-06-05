# Sezioni del Tema One

Questo documento descrive le sezioni disponibili nel tema One e come sono strutturate.

## Panoramica

Le sezioni sono componenti di alto livello che rappresentano aree specifiche del sito (header, footer, ecc.). Ogni sezione:
- Ha un template dedicato nella directory `resources/views/components/sections/`
- Può utilizzare blocchi di contenuto dal CMS
- Ha uno stile e un layout specifico per il tema

## Sezioni Disponibili

### Header (`header.blade.php`)

La sezione header è il componente principale di navigazione del sito.

#### Template
```php
<x-section slug="header" />
```

#### Blocchi Supportati
- `logo`: Per il logo del sito
- `navigation`: Per il menu di navigazione

#### Caratteristiche
- Layout responsive
- Menu mobile con animazioni
- Supporto per classi e stili personalizzati

### Footer (`footer.blade.php`)

**Regola sui blocchi legali:**
I blocchi legali e informativi (privacy, termini, condizioni, ecc.) devono essere gestiti esclusivamente nel footer tramite i blocks dedicati, mai all'interno di widget, form o pagine di autenticazione.

La sezione footer contiene informazioni di contatto e link utili.

#### Template
```php
<x-section slug="footer" />
```

#### Blocchi Supportati
- `info`: Informazioni legali e aziendali
  - Privacy Policy
  - Termini e Condizioni
  - Cookie Policy
- `contact`: Dettagli di contatto
- `quick_links`: Link rapidi
- `newsletter`: Form newsletter
- `social`: Link social media

## Struttura dei Template

Ogni template di sezione:
1. Accetta props standard:
   - `section`: Dati della sezione
   - `blocks`: Blocchi di contenuto
   - `class`: Classi CSS aggiuntive

2. Utilizza i blocchi in modo contestuale:
   ```blade
   @isset($blocks['block_name'])
       <x-dynamic-component 
           :component="'cms::blocks.block_name'" 
           :data="$blocks['block_name']['data']" 
       />
   @endisset
   ```

## Best Practices

1. **Layout**:
   - Utilizzare le classi Tailwind fornite dal tema
   - Mantenere la responsività
   - Rispettare la gerarchia visiva

2. **Blocchi**:
   - Utilizzare solo i blocchi supportati dalla sezione
   - Gestire correttamente i casi di blocchi mancanti
   - Mantenere la coerenza visiva

3. **Personalizzazione**:
   - Utilizzare le props per personalizzazioni leggere
   - Estendere il template per modifiche sostanziali
   - Mantenere la compatibilità con gli aggiornamenti

4. **Mantenere la coerenza tra le sezioni**:
   - Utilizzare blocchi appropriati per ogni contesto
   - Seguire le linee guida di accessibilità
   - Supportare il multilingua

5. **Gestire le informazioni legali esclusivamente nel footer**:
   - Mantenere la coerenza tra le sezioni
   - Utilizzare blocchi appropriati per ogni contesto
   - Seguire le linee guida di accessibilità
   - Supportare il multilingua

## Collegamenti

- [Documentazione CMS](../../Modules/Cms/docs/README.md)
- [Componenti UI](../../docs/ui/components.md)
- [Gestione Blocchi](../../Modules/Cms/docs/blocks/README.md)
- [Temi](../../docs/themes/README.md) 

## Collegamenti tra versioni di sections.md
* [sections.md](docs/sections.md)
* [sections.md](laravel/Modules/Cms/docs/sections.md)
* [sections.md](laravel/Themes/One/docs/sections.md)

