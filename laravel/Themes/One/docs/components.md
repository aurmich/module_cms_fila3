# Documentazione Componenti

## Blocchi Base

### 1. Hero (`components/blocks/hero/`)

#### 1.1 Variante Simple
```php
<x-blocks.hero.simple
    title="Titolo Hero"
    subtitle="Sottotitolo opzionale"
    image="/path/to/image.jpg"
    :cta="[
        'text' => 'Call to Action',
        'link' => '/action'
    ]"
/>
```

Props disponibili:
- `title`: string (required)
- `subtitle`: string (optional)
- `image`: string (required)
- `cta`: array (optional)
  - `text`: string
  - `link`: string

### 2. Feature Sections (`components/blocks/feature_sections/`)

#### 2.1 Variante V1
```php
<x-blocks.feature_sections.v1
    title="Titolo Sezione"
    :sections="[
        [
            'title' => 'Feature 1',
            'description' => 'Descrizione feature',
            'icon' => 'check-circle'
        ]
    ]"
/>
```

Props disponibili:
- `title`: string (required)
- `sections`: array (required)
  - `title`: string
  - `description`: string
  - `icon`: string (optional)
  - `link`: string (optional)
  - `link_text`: string (optional)

### 3. Stats (`components/blocks/stats/`)

#### 3.1 Variante V1
```php
<x-blocks.stats.v1
    title="Statistiche"
    :stats="[
        [
            'number' => '100+',
            'label' => 'Clienti'
        ]
    ]"
/>
```

Props disponibili:
- `title`: string (required)
- `stats`: array (required)
  - `number`: string
  - `label`: string
  - `description`: string (optional)

### 4. CTA (`components/blocks/cta/`)

#### 4.1 Variante V1
```php
<x-blocks.cta.v1
    title="Call to Action"
    description="Descrizione della CTA"
    button_text="Azione"
    button_link="/action"
/>
```

Props disponibili:
- `title`: string (required)
- `description`: string (optional)
- `button_text`: string (required)
- `button_link`: string (required)

## Stili e Personalizzazione

### 1. Colori
I componenti utilizzano le seguenti classi di colore Tailwind:
- Primary: `text-indigo-600`, `bg-indigo-600`
- Neutral: `text-gray-900`, `text-gray-600`
- Background: `bg-white`

### 2. Tipografia
Gerarchie tipografiche standard:
- H1: `text-4xl font-bold`
- H2: `text-3xl font-semibold`
- Body: `text-base leading-7`
- Small: `text-sm`

### 3. Spaziatura
- Sezioni: `py-24 sm:py-32`
- Elementi: `gap-x-8 gap-y-16`
- Contenitori: `max-w-7xl mx-auto`

## Responsive Design

### 1. Breakpoint
```css
sm: @media (min-width: 640px)
md: @media (min-width: 768px)
lg: @media (min-width: 1024px)
xl: @media (min-width: 1280px)
2xl: @media (min-width: 1536px)
```

### 2. Grid System
- Mobile: `grid-cols-1`
- Tablet: `sm:grid-cols-2`
- Desktop: `lg:grid-cols-3`

## Best Practices

### 1. Utilizzo dei Componenti
- Mantenere i componenti il più possibile autonomi
- Utilizzare props per la configurazione
- Evitare logica complessa nei template
- Documentare tutte le props richieste

### 2. Personalizzazione
- Utilizzare slot per contenuto personalizzato
- Override dei componenti tramite Blade Components
- Estendere le classi CSS base

### 3. Performance
- Lazy loading per immagini pesanti
- Minimizzare le dipendenze JavaScript
- Ottimizzare le query database

## Testing

### 1. Unit Testing
```php
class ComponentTest extends TestCase
{
    /** @test */
    public function it_renders_hero_component()
    {
        $view = $this->blade(
            '<x-blocks.hero.simple :title="$title" />',
            ['title' => 'Test Title']
        );
        
        $view->assertSee('Test Title');
    }
}
```

### 2. Browser Testing
```php
class ComponentBrowserTest extends DuskTestCase
{
    /** @test */
    public function it_shows_cta_button()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                   ->assertSee('Call to Action')
                   ->click('@cta-button');
        });
    }
}
```

## Esempi di Implementazione

### 1. Pagina con Hero e Features
```php
<x-layouts.app>
    <x-blocks.hero.simple
        title="Welcome"
        subtitle="Subtitle here"
        image="/img/hero.jpg"
    />
    
    <x-blocks.feature_sections.v1
        title="Our Features"
        :sections="$features"
    />
</x-layouts.app>
```

### 2. Sezione Statistiche con CTA
```php
<div class="space-y-24">
    <x-blocks.stats.v1
        title="Our Numbers"
        :stats="$statistics"
    />
    
    <x-blocks.cta.v1
        title="Ready to Start?"
        button_text="Get Started"
        button_link="/register"
    />
</div>
```

# Componenti del Tema One

> **NOTA**: La documentazione generale sui componenti UI è centralizzata nel [modulo UI](../../../Modules/UI/docs/components.md). Questa sezione documenta solo i componenti specifici del tema One.

## Collegamenti

- [Documentazione generale componenti UI](../../../Modules/UI/docs/components.md)
- [Componenti form](../../../Modules/UI/docs/form-components.md)
- [Componenti layout](../../../Modules/UI/docs/layout-components.md)

## Logo

Il componente `x-ui.logo` è un SVG che rappresenta il logo dell'applicazione. 

### Utilizzo Base
```blade
<x-ui.logo />
```

### Dimensioni
- Dimensione predefinita: altezza 64px (h-16) con larghezza automatica
- Le dimensioni possono essere sovrascritte passando classi Tailwind:
```blade
<x-ui.logo class="h-8 w-auto" />
```

### Colori
- Il colore può essere controllato attraverso la classe `text-{color}` grazie all'uso di `currentColor` nell'SVG
- Supporta il tema chiaro/scuro attraverso le classi `dark:`

### Best Practices
- Mantenere le proporzioni usando `w-auto`
- Per header e navbar, usare dimensioni tra h-8 e h-16
- Per hero sections e splash screens, considerare dimensioni maggiori

## Collegamenti tra versioni di components.md
* [components.md](laravel/Modules/UI/docs/components.md)
* [components.md](laravel/Modules/UI/docs/themes/components.md)
* [components.md](laravel/Modules/Cms/docs/components.md)
* [components.md](laravel/Themes/One/docs/components.md)

