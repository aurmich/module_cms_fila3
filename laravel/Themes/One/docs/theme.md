# Documentazione Tema One

## Struttura del Tema

```
laravel/Themes/One/
├── app/                    # Logica PHP del tema
│   ├── Http/              # Controllers e Middleware
│   └── Providers/         # Service Providers
├── resources/             # Asset sorgenti
│   ├── js/               # JavaScript
│   ├── css/              # CSS e Tailwind
│   ├── views/            # Template Blade
│   │   ├── components/   # Componenti riutilizzabili
│   │   ├── layouts/     # Layout base
│   │   └── pages/       # Template delle pagine
│   └── sass/            # SASS/SCSS
├── assets/               # Asset compilati
├── routes/              # Route del tema
└── config/             # Configurazioni
```

## Componenti Blade

### Blocchi di Contenuto
I blocchi di contenuto si trovano in `resources/views/components/blocks/` e includono:

1. **Hero** (`hero/`)
   - `simple.blade.php` - Hero section con immagine di sfondo
   - Supporta titolo, sottotitolo e CTA

2. **Feature Sections** (`feature_sections/`)
   - `v1.blade.php` - Grid di feature con icone
   - Supporta titolo, descrizioni e icone Heroicon

3. **Stats** (`stats/`)
   - `v1.blade.php` - Grid di statistiche
   - Supporta numeri e label

4. **CTA** (`cta/`)
   - `v1.blade.php` - Call to action centrata
   - Supporta titolo, descrizione e pulsanti

### Utilizzo dei Componenti

```php
<x-blocks.hero.simple 
    title="Titolo"
    subtitle="Sottotitolo"
    :image="'/path/to/image.jpg'"
/>

<x-blocks.feature_sections.v1
    :title="'Titolo Sezione'"
    :sections="[...]"
/>
```

## Asset Management

### Tailwind CSS
Il tema utilizza Tailwind CSS con una configurazione personalizzata in `tailwind.config.js`:

```js
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      // Personalizzazioni
    }
  },
  plugins: [
    // Plugin aggiuntivi
  ]
}
```

### Vite Configuration
Build degli asset gestita da Vite (`vite.config.js`):

```js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## Struttura delle Views

### Layout Base
Il tema fornisce diversi layout base in `resources/views/layouts/`:
- `app.blade.php` - Layout principale
- `marketing.blade.php` - Layout per pagine marketing

### Template PDF
Il tema include template PDF specializzati in `resources/views/`:
- `appointment/report_pdf.blade.php` - Report appuntamenti medici
- Per dettagli completi, vedere [Template PDF](pdf_templates.md)
- `auth.blade.php` - Layout per pagine di autenticazione

### Componenti UI
Componenti riutilizzabili in `resources/views/components/`:
- Form elements
- Navigation
- Cards
- Buttons
- Icons

## Gestione dei Contenuti

### JSON Content Blocks
I contenuti sono gestiti attraverso file JSON con la seguente struttura:

```json
{
    "type": "block_type",
    "data": {
        "view": "components.blocks.type.variant",
        // Dati specifici del blocco
    }
}
```

### View Composers
I contenuti vengono renderizzati utilizzando View Composers che:
1. Caricano i dati dal JSON
2. Preparano i dati per la view
3. Renderizzano il componente appropriato

## Best Practices

### Sviluppo Componenti
1. Mantenere i componenti piccoli e focalizzati
2. Utilizzare props tipizzate
3. Documentare le props richieste
4. Seguire le convenzioni di naming

### Asset
1. Utilizzare Tailwind per lo styling
2. Minimizzare il JavaScript custom
3. Ottimizzare le immagini
4. Utilizzare lazy loading dove appropriato

### Performance
1. Utilizzare la cache delle view
2. Minimizzare le query al database
3. Ottimizzare gli asset
4. Implementare lazy loading per immagini e componenti pesanti

## Testing

### View Testing
```php
public function test_hero_component()
{
    $view = $this->blade(
        '<x-blocks.hero.simple title="Test" />'
    );
    
    $view->assertSee('Test');
}
```

### Component Testing
```php
public function test_feature_section_component()
{
    $component = new FeatureSection();
    $view = $component->render();
    
    $this->assertInstanceOf(View::class, $view);
}
```

## Deployment

1. Compilare gli asset:
```bash
npm run build
```

2. Pubblicare gli asset:
```bash
php artisan theme:publish
```

3. Cache delle views:
```bash
php artisan view:cache
```

## Collegamenti alla Documentazione

- [Template PDF](pdf_templates.md) - Template PDF specializzati
- [Componenti PDF](pdf_components.md) - Componenti riutilizzabili per PDF
- [Miglioramenti DRY + KISS](dry_kiss_improvements.md) - Ottimizzazioni template PDF
- [Correzioni Errori Traduzioni](translation_errors_fixes.md) - Errori corretti e best practices
- [Componenti UI](components.md) - Componenti riutilizzabili
- [Best Practices](best_practices.md) - Linee guida sviluppo
- [Traduzioni](translations.md) - Gestione multilingua

### Risorse Esterne
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Laravel Blade](https://laravel.com/docs/blade)
- [Vite](https://vitejs.dev/guide/) 

## Template PDF

### Report PDF
Il template `resources/views/appointment/report_pdf.blade.php` genera PDF per i referti medici.

#### Caratteristiche:
- Utilizza namespace `pub_theme::` per tutte le traduzioni
- Struttura HTML ottimizzata per HTML2PDF
- **NUOVO**: CSS riutilizzabile con `@include('xot::pdf.css')`
- **NUOVO**: Componenti riutilizzabili per informazioni paziente e studio
- Supporto multilingua completo

#### Refactoring CSS DRY+KISS:
**Motivazione DRY**: Evita duplicazione di stili CSS tra diversi template PDF
**Motivazione KISS**: Componente con responsabilità singola e ben definita

```blade
{{-- Prima: CSS inline duplicato --}}
<style type="text/css">
    body { font-family: Arial, sans-serif; }
    /* ... centinaia di righe CSS ... */
</style>

{{-- Dopo: CSS riutilizzabile --}}
@include('xot::pdf.css')
```

#### Refactoring Componenti DRY+KISS:
**Motivazione DRY**: Evita duplicazione di blocchi HTML per informazioni paziente e studio
**Motivazione KISS**: Componenti con responsabilità singola e ben definita

```blade
{{-- Prima: Blocchi HTML duplicati --}}
<!-- Informazioni paziente -->
<h2>...</h2>
<table class="info">...</table>

<!-- Informazioni studio -->
<div class="studio-box">...</div>

{{-- Dopo: Componenti riutilizzabili --}}
@includeWhen($appointment->patient, 'pub_theme::appointment.report_pdf.patient', ['patient' => $appointment->patient])
@includeWhen($appointment->studio, 'pub_theme::appointment.report_pdf.studio', ['studio' => $appointment->studio])
```

#### Vantaggi del Refactoring:
- **Manutenibilità**: Un solo punto di modifica per CSS e componenti
- **Riutilizzabilità**: CSS e componenti utilizzabili in tutti i PDF
- **Coerenza**: Layout e stili uniformi in tutti i PDF
- **Performance**: Inclusione condizionale e ottimizzata
- **Scalabilità**: Facile aggiungere nuovi componenti

#### Componenti Disponibili:
- **Appointment**: `pub_theme::appointment.report_pdf.appointment` - Informazioni appuntamento
- **Patient**: `pub_theme::appointment.report_pdf.patient` - Informazioni paziente
- **Doctor**: `pub_theme::appointment.report_pdf.doctor` - Informazioni medico
- **Studio**: `pub_theme::appointment.report_pdf.studio` - Informazioni studio
- **CSS**: `xot::pdf.css`

#### Documentazione Correlata:
- [CSS Refactoring](css_refactoring.md)
- [Component Refactoring](component_refactoring.md)
- [PDF Report Errors](pdf_report_errors.md) 
