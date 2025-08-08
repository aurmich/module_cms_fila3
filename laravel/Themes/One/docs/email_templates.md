# Template Email del Tema One

## Scopo
Template HTML modulari e compatibili con i principali client email (Gmail, Outlook, Apple Mail). Forniscono header con logo, contenuto dinamico e footer con link utili.

## File Disponibili
- `resources/mail-layouts/base.html`: layout generico (lingua neutra, variabili Mustache)
- `resources/mail-layouts/base-it.html`: variante localizzata italiana con miglior compatibilità email
- `resources/mail-layouts/basev1-it.html`: versione migliorata italiana (DRY/KISS ottimizzato)

## Analisi Template Esistenti

### base.html - Limitazioni Identificate
- Footer usa flexbox (problematico in Outlook)
- CSS dark mode non ottimizzato per tutti i client
- Struttura tabelle migliorabile per compatibilità
- Mancanza preheader per migliorare open rate

### base-it.html - Miglioramenti Presenti
- Footer con tabelle invece di flexbox
- Preheader nascosto implementato
- Struttura più pulita e compatibile
- Localizzazione italiana dei contenuti

## Variabili disponibili
- `{{ subject }}`: oggetto email
- `{{ preheader }}`: testo breve per anteprima client (opzionale)
- `{{{ body }}}`: contenuto HTML del corpo (renderizzato tramite Mustache)
- `{{ site_url }}`: URL base del sito
- `{{ logo_header }}`: URL assoluto del logo (preferibile per compatibilità globale)
- `{{ logo_header_base64 }}`: versione base64 del logo (fallback quando serve embed)

## Best Practice DRY/KISS

### Principi Fondamentali
- **DRY (Don't Repeat Yourself)**: Centralizzare stili comuni nel `<style>` invece di ripetere inline
- **KISS (Keep It Simple, Stupid)**: Struttura semplice, compatibilità massima, codice leggibile

### Regole di Compatibilità Email
- Tenere la struttura a tabelle per massima compatibilità
- Evitare Flexbox nel footer: usare tabelle per allineamento link
- Limitare CSS all'inline essenziale e piccoli reset nel `<style>`
- Mantenere immagini `display:block` e dimensioni fisse (width/height) quando possibile
- Usare `preheader` nascosto per migliorare l'open rate

### Miglioramenti basev1-it.html
- **Semantic HTML**: Uso corretto di `role="presentation"` per tabelle layout
- **Accessibilità**: Alt text significativi, lang="it", struttura logica
- **Performance**: CSS ottimizzato, meno codice duplicato
- **Manutenibilità**: Commenti chiari, struttura modulare
- **Responsive**: Media queries ottimizzate per mobile
- **Dark Mode**: Supporto migliorato con fallback sicuri

## Note Gmail / SVG
- Gmail rimuove CSS inline dentro SVG (`<defs>`, `<style>`) e attributi non supportati
- Preferire `<img src="{{ logo_header }}">` o, se necessario, `{{ logo_header_base64 }}`

## Integrazione con `SpatieEmail`
Il mailable `Modules/Notify/Emails/SpatieEmail.php` fornisce le variabili:
- `site_url`, `logo_header`, `logo_header_base64`, `body`, `subject`
- Layout caricato tramite `getHtmlLayout()` puntando a `base.html` (o `base-it.html` su richiesta)

## Come scegliere il layout
- Generico: `base.html`
- Italiano: `base-it.html`

Esempio override (pseudo):
```
$layout = base_path('Themes/One/resources/mail-layouts/base-it.html');
$html = file_get_contents($layout);
```

## Collegamenti
- Vedi anche: `email_template_logo_integration.md` per dettagli su logo Base64 e compatibilità Gmail
