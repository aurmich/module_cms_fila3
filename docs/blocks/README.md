# Blocchi di Contenuto

Questo documento contiene la documentazione dettagliata dei blocchi di contenuto.

## Struttura dei Blocchi

### Base Blocks
- `XotBaseTextBlock`: Blocco di testo con formattazione
- `XotBaseImageBlock`: Blocco immagine con caption
- `XotBaseGalleryBlock`: Galleria di immagini
- `XotBaseVideoBlock`: Video con player
- `XotBaseQuoteBlock`: Citazione con autore

### Layout Blocks
- `XotBaseColumnsBlock`: Colonne con contenuto
- `XotBaseAccordionBlock`: Accordion espandibile
- `XotBaseTabsBlock`: Tabs con contenuto
- `XotBaseCarouselBlock`: Carosello di elementi
- `XotBaseGridBlock`: Grid con items

### Special Blocks
- `XotBaseFormBlock`: Form con campi
- `XotBaseMapBlock`: Mappa con markers
- `XotBaseCalendarBlock`: Calendario eventi
- `XotBaseTableBlock`: Tabella dati
- `XotBaseChartBlock`: Grafico dati

## Implementazione

### Esempio Base
```php
namespace Modules\Cms\app\Models\Blocks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class XotBaseTextBlock extends Model
{
    protected $fillable = [
        'content',
        'format',
        'alignment',
        'style',
    ];

    protected $casts = [
        'content' => 'string',
        'format' => 'string',
        'alignment' => 'string',
        'style' => 'array',
    ];

    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }
}
```

### Configurazione
```php
class TextBlockConfig
{
    public static function getConfig(): array
    {
        return [
            'name' => 'text',
            'label' => 'Testo',
            'icon' => 'heroicon-o-document-text',
            'component' => 'cms::blocks.text',
            'rules' => [
                'content' => ['required', 'string'],
                'format' => ['required', 'in:plain,html,markdown'],
                'alignment' => ['required', 'in:left,center,right'],
            ],
            'defaults' => [
                'format' => 'plain',
                'alignment' => 'left',
            ],
        ];
    }
}
```

### Rendering
```php
class TextBlockRenderer
{
    public function render(XotBaseTextBlock $block): string
    {
        return match($block->format) {
            'plain' => e($block->content),
            'html' => $block->content,
            'markdown' => Str::markdown($block->content),
        };
    }
}
```

## Gestione

### Versionamento
```php
class BlockVersion
{
    public function createVersion(Block $block): void
    {
        Version::create([
            'versionable_type' => $block->getMorphClass(),
            'versionable_id' => $block->id,
            'user_id' => auth()->id(),
            'content' => $block->toArray(),
        ]);
    }
}
```

### Cache
```php
class BlockCache
{
    public function remember(Block $block, Closure $callback): mixed
    {
        return Cache::tags(['blocks', $block->getMorphClass()])
            ->remember(
                "block:{$block->id}",
                now()->addHour(),
                $callback
            );
    }
}
```

## Frontend

### Componente Vue
```javascript
// resources/js/Blocks/TextBlock.vue
<template>
    <div class="text-block" :class="alignment">
        <div v-if="format === 'markdown'" v-html="renderedContent"></div>
        <div v-else>{{ content }}</div>
    </div>
</template>

<script>
export default {
    props: {
        content: String,
        format: String,
        alignment: String,
    },
    computed: {
        renderedContent() {
            return marked(this.content);
        },
    },
};
</script>
```

### Stili
```scss
.text-block {
    @apply prose max-w-none;
    
    &.left {
        @apply text-left;
    }
    
    &.center {
        @apply text-center;
    }
    
    &.right {
        @apply text-right;
    }
}
```

## API

### Endpoints
```php
Route::prefix('api/blocks')->group(function () {
    Route::get('/', [BlockController::class, 'index']);
    Route::post('/', [BlockController::class, 'store']);
    Route::get('/{block}', [BlockController::class, 'show']);
    Route::put('/{block}', [BlockController::class, 'update']);
    Route::delete('/{block}', [BlockController::class, 'destroy']);
});
```

### Resources
```php
class BlockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'content' => $this->content,
            'config' => $this->config,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
```

## Testing

### Unit Tests
```php
class TextBlockTest extends TestCase
{
    /** @test */
    public function it_renders_markdown(): void
    {
        $block = TextBlock::factory()->create([
            'content' => '# Test',
            'format' => 'markdown',
        ]);
        
        $this->assertStringContainsString(
            '<h1>Test</h1>',
            $block->render()
        );
    }
}
```

### Feature Tests
```php
class BlockApiTest extends TestCase
{
    /** @test */
    public function it_stores_a_block(): void
    {
        $response = $this->postJson('/api/blocks', [
            'type' => 'text',
            'content' => 'Test content',
        ]);
        
        $response->assertCreated();
        $this->assertDatabaseHas('blocks', [
            'type' => 'text',
            'content' => 'Test content',
        ]);
    }
}
```

## File Contenuti

- `system.md`
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/project_docs/README.md)
* [README.md](bashscripts/project_docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/project_docs/README.md)
* [README.md](laravel/Modules/Chart/project_docs/README.md)
* [README.md](laravel/Modules/Reporting/project_docs/README.md)
* [README.md](laravel/Modules/Gdpr/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/project_docs/README.md)
* [README.md](laravel/Modules/Notify/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/project_docs/README.md)
* [README.md](laravel/Modules/Xot/project_docs/filament/README.md)
* [README.md](laravel/Modules/Xot/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/project_docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/project_docs/README.md)
* [README.md](laravel/Modules/Xot/project_docs/standards/README.md)
* [README.md](laravel/Modules/Xot/project_docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/project_docs/development/README.md)
* [README.md](laravel/Modules/Dental/project_docs/README.md)
* [README.md](laravel/Modules/User/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/User/project_docs/README.md)
* [README.md](laravel/Modules/User/resources/views/project_docs/README.md)
* [README.md](laravel/Modules/UI/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/project_docs/README.md)
* [README.md](laravel/Modules/UI/project_docs/standards/README.md)
* [README.md](laravel/Modules/UI/project_docs/themes/README.md)
* [README.md](laravel/Modules/UI/project_docs/components/README.md)
* [README.md](laravel/Modules/Lang/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/project_docs/README.md)
* [README.md](laravel/Modules/Job/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/project_docs/README.md)
* [README.md](laravel/Modules/Media/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/project_docs/README.md)
* [README.md](laravel/Modules/Tenant/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/project_docs/README.md)
* [README.md](laravel/Modules/Activity/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/project_docs/README.md)
* [README.md](laravel/Modules/Patient/project_docs/README.md)
* [README.md](laravel/Modules/Patient/project_docs/standards/README.md)
* [README.md](laravel/Modules/Patient/project_docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/project_docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/project_docs/README.md)
* [README.md](laravel/Modules/Cms/project_docs/standards/README.md)
* [README.md](laravel/Modules/Cms/project_docs/content/README.md)
* [README.md](laravel/Modules/Cms/project_docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/project_docs/components/README.md)
* [README.md](laravel/Themes/Two/project_docs/README.md)
* [README.md](laravel/Themes/One/project_docs/README.md)

