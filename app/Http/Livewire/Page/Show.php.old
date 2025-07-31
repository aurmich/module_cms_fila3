<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Livewire\Page;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Modules\Cms\Models\Page;
use Modules\Xot\Services\ThemeService;

class Show extends Component
{
    /**
     * Lo slug della pagina da visualizzare.
     *
     * @var string
     */
    public string $slug;

    /**
     * Se utilizzare la cache per i contenuti.
     *
     * @var bool
     */
    public bool $cache = true;

    /**
     * Il tema da utilizzare.
     *
     * @var string|null
     */
    public ?string $theme = null;

    /**
     * Se mostrare informazioni di debug.
     *
     * @var bool
     */
    public bool $debug = false;

    /**
     * I contenuti della pagina.
     *
     * @var array
     */
    protected array $pageContent = [];

    /**
     * Regole di validazione per i parametri.
     *
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'slug' => 'required|string',
            'cache' => 'boolean',
            'theme' => 'nullable|string',
            'debug' => 'boolean',
        ];
    }

    /**
     * Carica i contenuti della pagina.
     */
    public function mount(): void
    {
        $this->loadPageContent();
    }

    /**
     * Carica i contenuti della pagina, eventualmente dalla cache.
     */
    protected function loadPageContent(): void
    {
        // Chiave per la cache
        $cacheKey = 'page_content_' . $this->slug . '_' . ($this->theme ?? ThemeService::getTheme());

        // Se la cache è abilitata, tenta di recuperare dalla cache
        if ($this->cache) {
            $this->pageContent = Cache::remember(
                $cacheKey,
                now()->addHours(24),
                fn () => $this->fetchPageContent()
            );
        } else {
            $this->pageContent = $this->fetchPageContent();
        }
    }

    /**
     * Recupera i contenuti della pagina dal database.
     *
     * @return array
     */
    protected function fetchPageContent(): array
    {
        try {
            // Recupera la pagina dal database
            $page = Page::where('slug', $this->slug)
                ->where('lang', app()->getLocale())
                ->first();

            if (! $page) {
                return ['error' => 'Page not found', 'slug' => $this->slug];
            }

            // Recupera e processa i contenuti della pagina
            return [
                'title' => $page->title,
                'subtitle' => $page->subtitle,
                'content' => $page->content,
                'meta' => [
                    'description' => $page->meta_description,
                    'keywords' => $page->meta_keywords,
                ],
                'blocks' => $page->blocks ?? [],
                'layout' => $page->layout ?? 'default',
            ];
        } catch (\Exception $e) {
            if ($this->debug) {
                return [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }

            return ['error' => 'An error occurred while loading the page'];
        }
    }

    /**
     * Renderizza la vista con i contenuti della pagina.
     */
    public function render(): View
    {
        return view('cms::livewire.page.show', [
            'pageContent' => $this->pageContent,
            'theme' => $this->theme ?? ThemeService::getTheme(),
        ]);
    }
}
