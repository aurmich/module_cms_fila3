# Documentazione Tema One

## Percorsi e Directory

⚠️ **IMPORTANTE**: Tutti i file del tema DEVONO essere nella directory `laravel/Themes/One/`.
Per le regole complete e gli errori comuni, vedere [Directory Structure Rules](../../../Modules/Xot/docs/directory-structure-rules.md).

## Struttura Base
```
laravel/Themes/One/
├── resources/
│   ├── views/
│   │   ├── pages/
│   │   │   └── auth/
│   │   │       └── register.blade.php
│   │   ├── components/
│   │   └── layouts/
│   ├── js/
│   └── css/
├── src/
│   └── Providers/
└── docs/
    └── theme-structure.md
```

## Struttura del Tema

### 1. Cartelle Principali

```
One/
├── app/                    # Logica PHP specifica del tema
│   ├── Http/              # Controllers e Middleware
│   └── Providers/         # Service Providers
├── resources/             # Asset sorgenti e views
│   ├── views/             # Template Blade
│   └── css/              # Stili
├── routes/                # Definizioni delle rotte
├── config/               # Configurazioni
├── assets/               # Asset compilati
└── docs/                 # Documentazione
```

### 2. Componenti Blade

La cartella `resources/views/components` contiene i componenti riutilizzabili:

#### 2.1 Blocchi (`components/blocks/`)
- **Hero** (`hero/`): Sezioni principali della pagina
- **Feature Sections** (`feature_sections/`): Sezioni per caratteristiche
- **Stats** (`stats/`): Visualizzazione statistiche
- **CTA** (`cta/`): Call to action
- **FAQ** (`faq_accordion/`): Sezioni FAQ
- **Testimonial** (`testimonial_carousel/`): Carousel testimonianze
- **Booking Form** (`booking_form/`): Form di prenotazione

Ogni tipo di blocco supporta multiple varianti (v1, simple, etc.)

### 3. Layout e Pagine

#### 3.1 Layouts (`views/layouts/`)
- Layout principali per la struttura delle pagine
- Gestione header e footer
- Inclusione asset e meta tag

#### 3.2 Pagine (`views/pages/`)
- Template per pagine specifiche
- Implementazioni personalizzate

### 4. Asset e Stili

#### 4.1 Configurazione Tailwind
Il tema utilizza Tailwind CSS con configurazione personalizzata:
```js
// tailwind.config.js
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      // Estensioni personalizzate
    }
  },
  plugins: [
    // Plugin aggiuntivi
  ]
}
```

#### 4.2 Build System
- Vite.js per la compilazione degli asset
- PostCSS per il processing CSS
- Supporto per JavaScript moderno

### 5. Funzionalità Principali

#### 5.1 Componenti Dinamici
- Supporto per componenti dinamici con x-dynamic-component
- Integrazione con Heroicons
- Sistema di props flessibile

#### 5.2 Responsive Design
- Breakpoint standard:
  - sm: 640px
  - md: 768px
  - lg: 1024px
  - xl: 1280px
  - 2xl: 1536px

#### 5.3 Personalizzazione
- Variabili CSS personalizzabili
- Override dei componenti
- Temi colore configurabili

### 6. Best Practices

#### 6.1 Struttura Componenti
- Ogni componente deve essere autonomo
- Props chiaramente definite
- Supporto per slot e personalizzazione
- Documentazione inline

#### 6.2 Naming Convention
- Componenti: PascalCase
- Partial views: snake_case
- File CSS: kebab-case
- Classi CSS: BEM-style

#### 6.3 Performance
- Lazy loading delle immagini
- Code splitting
- Ottimizzazione asset
- Caching appropriato

### 7. Integrazione

#### 7.1 Filament Admin
- Componenti personalizzati per Filament
- Temi admin personalizzati
- Form components

#### 7.2 Livewire
- Componenti dinamici
- Real-time features
- State management

### 8. Testing

#### 8.1 View Testing
```php
public function test_component_renders()
{
    $view = $this->blade(
        '<x-blocks.feature_sections.v1 :title="$title" :sections="$sections"/>', 
        ['title' => 'Test', 'sections' => []]
    );
    
    $view->assertSee('Test');
}
```

### 9. Manutenzione

#### 9.1 Aggiornamenti
- Seguire il semantic versioning
- Mantenere changelog
- Documentare breaking changes

#### 9.2 Compatibilità
- Browser supportati
- Versioni PHP
- Dipendenze

### 10. Documentazione Componenti

Per ogni componente principale, mantenere:
- Descrizione funzionale
- Props disponibili
- Esempi di utilizzo
- Note di personalizzazione 

## Collegamenti tra versioni di theme-structure.md
* [theme-structure.md](../../../Modules/Theme/docs/theme-structure.md)

