# Architettura dei Componenti

## Struttura Base

### 1. Componente Base

Tutti i componenti estendono la classe base:

```php
namespace Themes\One\Components;

abstract class BaseComponent
{
    protected $view;
    protected $data = [];
    
    public function render()
    {
        return view($this->view, $this->data);
    }
}
```

### 2. Trait Comuni

#### 2.1 HasStyles
```php
trait HasStyles
{
    protected $styles = [];
    
    public function addStyle($style)
    {
        $this->styles[] = $style;
        return $this;
    }
    
    public function getStyles()
    {
        return implode(' ', $this->styles);
    }
}
```

#### 2.2 HasScripts
```php
trait HasScripts
{
    protected $scripts = [];
    
    public function addScript($script)
    {
        $this->scripts[] = $script;
        return $this;
    }
}
```

## Struttura dei Blocchi

### 1. Block Base

```php
namespace Themes\One\Components\Blocks;

abstract class Block extends BaseComponent
{
    use HasStyles;
    use HasScripts;
    
    protected $type;
    protected $variant;
    
    public function __construct($type, $variant = 'default')
    {
        $this->type = $type;
        $this->variant = $variant;
        $this->view = "theme::components.blocks.{$type}.{$variant}";
    }
}
```

### 2. Implementazioni Specifiche

#### 2.1 Hero Block
```php
namespace Themes\One\Components\Blocks\Hero;

class Simple extends Block
{
    public function __construct()
    {
        parent::__construct('hero', 'simple');
    }
    
    public function withBackground($url)
    {
        $this->data['background'] = $url;
        return $this;
    }
}
```

#### 2.2 Feature Section Block
```php
namespace Themes\One\Components\Blocks\FeatureSections;

class V1 extends Block
{
    public function __construct()
    {
        parent::__construct('feature_sections', 'v1');
    }
    
    public function addFeature($title, $description, $icon = null)
    {
        $this->data['features'][] = compact('title', 'description', 'icon');
        return $this;
    }
}
```

## Pattern di Composizione

### 1. Decorator Pattern

```php
namespace Themes\One\Components\Decorators;

class WithAnimation
{
    protected $component;
    
    public function __construct($component)
    {
        $this->component = $component;
    }
    
    public function render()
    {
        $view = $this->component->render();
        // Aggiungi animazioni
        return $view;
    }
}
```

### 2. Builder Pattern

```php
namespace Themes\One\Components\Builders;

class HeroBuilder
{
    protected $hero;
    
    public function create()
    {
        $this->hero = new Hero\Simple();
        return $this;
    }
    
    public function withTitle($title)
    {
        $this->hero->data['title'] = $title;
        return $this;
    }
    
    public function withCTA($text, $link)
    {
        $this->hero->data['cta'] = compact('text', 'link');
        return $this;
    }
    
    public function build()
    {
        return $this->hero;
    }
}
```

## Gestione degli Stati

### 1. State Management

```php
namespace Themes\One\Components\States;

trait HasState
{
    protected $state = [];
    
    public function setState($key, $value)
    {
        $this->state[$key] = $value;
        return $this;
    }
    
    public function getState($key)
    {
        return $this->state[$key] ?? null;
    }
}
```

### 2. Reactive State

```php
namespace Themes\One\Components\States;

trait ReactiveState
{
    use HasState;
    
    public function watch($key, $callback)
    {
        // Implementazione reactive state
    }
}
```

## Eventi dei Componenti

### 1. Eventi Base

```php
namespace Themes\One\Components\Events;

class ComponentEvent
{
    public $component;
    public $name;
    public $data;
    
    public function __construct($component, $name, $data = [])
    {
        $this->component = $component;
        $this->name = $name;
        $this->data = $data;
    }
}
```

### 2. Event Listeners

```php
namespace Themes\One\Components\Listeners;

class ComponentEventListener
{
    public function handle(ComponentEvent $event)
    {
        // Gestione evento
    }
}
```

## Testing dei Componenti

### 1. Unit Testing

```php
namespace Tests\Themes\One\Components;

class HeroTest extends TestCase
{
    /** @test */
    public function it_renders_with_title()
    {
        $hero = new Hero\Simple();
        $hero->data['title'] = 'Test Title';
        
        $view = $hero->render();
        $view->assertSee('Test Title');
    }
}
```

### 2. Integration Testing

```php
namespace Tests\Themes\One\Components;

class BlockIntegrationTest extends TestCase
{
    /** @test */
    public function it_composes_multiple_blocks()
    {
        $page = [
            new Hero\Simple(),
            new FeatureSections\V1(),
            new Stats\V1(),
        ];
        
        // Test composizione
    }
}
```

## Best Practices

### 1. Composizione
- Preferire composizione all'ereditarietà
- Utilizzare trait per funzionalità condivise
- Implementare pattern builder per componenti complessi

### 2. Testing
- Testare ogni componente isolatamente
- Verificare la composizione dei componenti
- Testare stati e eventi

### 3. Performance
- Lazy loading dei componenti pesanti
- Caching dei componenti statici
- Ottimizzazione del rendering

### 4. Manutenibilità
- Documentare le API dei componenti
- Seguire convenzioni di naming
- Mantenere componenti piccoli e focalizzati 
