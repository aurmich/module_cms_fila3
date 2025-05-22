<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Traits\TransTrait;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Modules\Xot\Actions\GetViewByClassAction;

/**
 * Classe base astratta per tutte le pagine Filament non legate a risorse specifiche.
 * Fornisce funzionalità comuni e standardizzate per la gestione delle pagine.
 * 
 * Implementa:
 * - Sistema di traduzioni integrato
 * - Gestione autorizzazioni
 * - Integrazione con form
 * - Rilevamento intelligente modello
 * - Metodi helper comuni
 *
 * @property ?string $model Il modello associato alla pagina
 * @property ?array $data I dati del form
 * 
 * @see \Modules\Xot\docs\xotbasepage_implementation.md Documentazione completa
 */
abstract class XotBasePage extends Page implements HasForms
{
    use TransTrait;
    use InteractsWithForms;

    /**
     * Icona di navigazione predefinita.
     * 
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    /**
     * Vista predefinita per la pagina.
     * Deve essere sovrascritta nelle classi figlie.
     * 
     * @var string
     */
    protected static string $view;

    /**
     * Modello associato alla pagina.
     * Se non specificato, verrà dedotto automaticamente dal nome della classe.
     * 
     * @var string|null
     */
    protected static ?string $model = null;

    /**
     * Dati del form.
     * Contiene i dati del form durante la gestione della pagina.
     * 
     * @var array<string, mixed>|null
     */
    public ?array $data = [];
    
    /**
     * Cache timeout per operazioni di cache (in secondi).
     * 
     * @var int
     */
    protected static int $cacheTimeout = 3600;

    // public function mount(): void {
    //     $user = auth()->user();
    //     if(!$user->hasRole('super-admin')){
    //         redirect('/admin');
    //     }
    // }
    /**
     * Ottiene il nome del modulo dalla classe.
     * Estrae il nome del modulo dal namespace della classe.
     * 
     * @return string Il nome del modulo (es. 'SaluteOra', 'User', ecc.)
     */
    public static function getModuleName(): string
    {
        return Str::between(static::class, 'Modules\\', '\\Filament');
    }

    /**
     * Ottiene la chiave di traduzione per un dato key.
     * Genera un percorso di traduzione standardizzato basato sul modulo e sul nome della classe.
     * 
     * @param string $key La chiave di traduzione specifica
     * @param array<string, mixed> $replace Parametri di sostituzione per la traduzione
     * @param string|null $locale Locale da utilizzare (null = locale corrente)
     * 
     * @return string La stringa tradotta o la chiave originale se non trovata
     */
    public static function trans(string $key, array $replace = [], ?string $locale = null): string
    {
        $moduleNameLow = Str::lower(static::getModuleName());
        $p = Str::after(static::class, 'Filament\\Pages\\');
        $p_arr = explode('\\', $p);
        $slug = collect($p_arr)->map(static fn ($item) => Str::kebab($item))->implode('.');
        
        $translationKey = $moduleNameLow.'::'.$slug.'.'.$key;
        $translation = __($translationKey, $replace, $locale);
        
        // Se la traduzione non esiste, registra il warning in ambiente di sviluppo
        if ($translation === $translationKey && App::environment('local', 'development', 'testing')) {
            \Illuminate\Support\Facades\Log::warning("Traduzione mancante: {$translationKey}");
        }
        
        return $translation;
    }

    /**
     * Ottiene l'etichetta plurale del modello.
     */
    public static function getPluralModelLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    /**
     * Ottiene il modello associato alla pagina.
     * Se non specificato esplicitamente, tenta di dedurlo dal nome della classe.
     * 
     * @return string Il namespace completo della classe del modello
     */
    public function getModel(): string
    {
        if (null !== static::$model) {
            return static::$model;
        }

        $moduleName = static::getModuleName();
        $className = class_basename(static::class);
        
        // Rimuove suffissi comuni per ottenere il nome del modello
        $modelName = Str::of($className)
            ->before('Resource')
            ->before('Page')
            ->before('Dashboard')
            ->before('Report')
            ->trim()
            ->toString();
        
        $modelNamespace = 'Modules\\'.$moduleName.'\\Models\\'.$modelName;
        
        // Verifica che la classe del modello esista
        if (!class_exists($modelNamespace) && App::environment('local', 'development', 'testing')) {
            \Illuminate\Support\Facades\Log::warning("Modello {$modelNamespace} non trovato. Specificare static::\$model nella classe {static::class}");
        }
        
        return $modelNamespace;
    }

    /**
     * Configura il form della pagina.
     * Imposta lo schema e il percorso dello stato per il form.
     * 
     * @param Form $form Il form da configurare
     * @return Form Il form configurato
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data')
            ->autosaveDebounce($this->getAutosaveDebounce());
    }
    
    /**
     * Ottiene il tempo di debounce per l'autosave in millisecondi.
     * Sovrascrivere nelle classi figlie per modificare questo valore.
     * 
     * @return int|null Il tempo di debounce in millisecondi o null per disabilitare l'autosave
     */
    protected function getAutosaveDebounce(): ?int
    {
        return null; // Disabilitato per default
    }

    /**
     * Ottiene lo schema del form.
     * Deve essere implementato nelle classi figlie per fornire lo schema del form.
     * 
     * @return array<string|int, \Filament\Forms\Components\Component> Lo schema del form con componenti
     */
    protected function getFormSchema(): array
    {
        return [];
    }

    /**
     * Ottiene l'utente autenticato.
     * Verifica che l'utente sia un'istanza di Model per permettere aggiornamenti.
     * 
     * @return Authenticatable&Model L'utente autenticato
     * @throws \Exception Se l'utente non è un'istanza di Model
     */
    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();
        if (! $user instanceof Model) {
            throw new \Exception('L\'utente autenticato deve essere un modello Eloquent per permettere aggiornamenti.');
        }

        return $user;
    }

    /**
     * Verifica se l'utente ha l'accesso alla pagina.
     * Utilizza il sistema di autorizzazioni per controllare l'accesso.
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException Se l'utente non è autorizzato
     */
    protected function authorizeAccess(): void
    {
        $this->authorize('view', static::class);
    }
    
    /**
     * Verifica se l'utente ha un permesso specifico.
     * Utile per controlli granulari all'interno delle pagine.
     * 
     * @param string $permission Il permesso da verificare
     * @return bool True se l'utente ha il permesso, false altrimenti
     */
    protected function hasPermissionTo(string $permission): bool
    {
        return $this->getUser()->hasPermissionTo($permission);
    }

    /**
     * Ottiene la vista della pagina.
     * Restituisce la vista specificata o tenta di dedurla dal nome della classe.
     * 
     * @return string Il percorso della vista
     * @throws \Exception Se la vista non può essere trovata
     */
    public function getView(): string
    {
        if (isset(static::$view)) {
            return static::$view;
        }

        return $this->resolveViewPath();
    }
    
    /**
     * Risolve il percorso della vista in base alla classe.
     * Questo metodo statico può essere usato internamente quando serve risolvere
     * il percorso della vista senza un'istanza dell'oggetto.
     * 
     * @return string Il percorso della vista
     * @throws \Exception Se la vista non può essere trovata
     */
    protected function resolveViewPath(): string
    {
        $view = app(GetViewByClassAction::class)->execute(static::class);
        if (view()->exists($view)) {
            return $view;
        }

        // Tenta di generare un percorso di vista predefinito basato sul modulo e sulla classe
        $moduleNameLow = Str::lower(static::getModuleName());
        $className = Str::kebab(class_basename(static::class));
        $fallbackView = "{$moduleNameLow}::filament.pages.{$className}";
        
        if (view()->exists($fallbackView)) {
            return $fallbackView;
        }

        throw new \Exception('Vista non trovata per la pagina: ' . static::class);
    }
    
    /**
     * Ottiene un record di modello dal database usando l'ID specificato.
     * 
     * @param int|string $id L'ID del record da recuperare
     * @param array<string> $with Relazioni da caricare in eager loading
     * @return Model|null Il record trovato o null
     */
    protected function getRecord($id, array $with = []): ?Model
    {
        $modelClass = $this->getModel();
        $cacheKey = "xot_page_{$modelClass}_{$id}_" . md5(json_encode($with));
        
        return Cache::remember($cacheKey, static::$cacheTimeout, function () use ($modelClass, $id, $with) {
            return app($modelClass)::with($with)->find($id);
        });
    }
    
    /**
     * Ottiene una query builder per il modello associato alla pagina.
     * 
     * @return Builder La query builder per il modello
     */
    protected function getQuery(): Builder
    {
        $modelClass = $this->getModel();
        return app($modelClass)::query();
    }
    
    /**
     * Esegue l'invalidazione della cache per il modello specificato.
     * 
     * @param string|null $modelClass Classe del modello (se null, usa il modello della pagina)
     * @param int|string|null $id ID specifico da invalidare (se null, invalida tutti)
     * @return void
     */
    protected function invalidateCache(?string $modelClass = null, $id = null): void
    {
        $modelClass = $modelClass ?? $this->getModel();
        $pattern = $id ? "xot_page_{$modelClass}_{$id}_*" : "xot_page_{$modelClass}_*";
        
        $cache = app('cache');
        if (method_exists($cache, 'deletePattern')) {
            $cache->deletePattern($pattern);
        } else {
            // Fallback per driver che non supportano deletePattern
            Cache::forget($pattern);
        }
    }
}
