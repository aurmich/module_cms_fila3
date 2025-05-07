<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use Livewire\Wireable;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

/**
 * Classe per la gestione dei dati della navigazione dell'header.
 */
class HeadernavData extends Data implements Wireable
{
    use WireableData;

<<<<<<< HEAD
    public ?string $background_color = null;
<<<<<<< HEAD
=======
<<<<<<< HEAD

    public ?string $background = null;

    public ?string $overlay_color = null;

    public ?int $overlay_opacity = null;

    public ?string $class = null;

    public ?string $style = null;

    /**
     * @var view-string
     */
    public string $view;
=======
>>>>>>> feb96d7 (.)
    public ?string $background = null;
    public ?string $overlay_color = null;
    public ?int $overlay_opacity = null;
    public ?string $class = null;
    public ?string $style = null;
=======
>>>>>>> f1c9277 (.)
    /**
     * Il colore di sfondo.
     *
     * @var string|null
     */
    public ?string $background_color = null;

    /**
     * L'immagine di sfondo.
     *
     * @var string|null
     */
    public ?string $background = null;

    /**
     * Il colore dell'overlay.
     *
     * @var string|null
     */
    public ?string $overlay_color = null;

    /**
     * L'opacità dell'overlay.
     *
     * @var int|null
     */
    public ?int $overlay_opacity = null;

    /**
     * La classe CSS.
     *
     * @var string|null
     */
    public ?string $class = null;

    /**
     * Lo stile CSS inline.
     *
     * @var string|null
     */
    public ?string $style = null;

    /**
     * Il percorso della vista.
     *
     * @var string
     */
<<<<<<< HEAD
    public $view = 'cms::components.headernav';
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
=======
    public string $view = 'cms::components.headernav';
>>>>>>> f1c9277 (.)

    /**
     * L'istanza singleton.
     *
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * Crea una nuova istanza dei dati della navigazione.
     *
     * @return self
     */
    public static function make(): self
    {
        if (!self::$instance instanceof HeadernavData) {
            $data = TenantService::getConfig('appearance');
            $data = Arr::get($data, 'headernav', []);
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Renderizza la vista della navigazione.
     *
     * @return Renderable
     * @throws \Exception Se la vista non esiste
     */
    public function view(): Renderable
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
        $view_params = $this->toArray();
=======
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
        if (! view()->exists($this->view)) {
            $message = 'The view ['.$this->view.'] does not exist';
            throw new \Exception($message);
        }
<<<<<<< HEAD
=======
<<<<<<< HEAD

        return view($this->view, $view_params);
    }
=======
>>>>>>> feb96d7 (.)
=======
        if (!view()->exists($this->view)) {
            $message = 'The view ['.$this->view.'] does not exist';
            throw new \Exception($message);
        }

>>>>>>> f1c9277 (.)
        /** @var array<string, mixed> $view_params */
        $view_params = $this->toArray();

        return view($this->view, $view_params);
    }

    /**
     * Ottiene le regole di validazione.
     *
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'background_color' => ['nullable', 'string'],
            'background' => ['nullable', 'string'],
            'overlay_color' => ['nullable', 'string'],
            'overlay_opacity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'class' => ['nullable', 'string'],
            'style' => ['nullable', 'string'],
            'view' => ['nullable', 'string'],
        ];
    }
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
}
