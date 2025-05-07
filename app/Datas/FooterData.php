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
 * Classe per la gestione dei dati del footer.
 */
class FooterData extends Data implements Wireable
{
    use WireableData;

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
    /**
     * @var view-string
     */
    public string $view;
=======
>>>>>>> feb96d7 (.)
    public ?string $background_color;
    public ?string $background;
    public ?string $overlay_color;
=======
>>>>>>> f1c9277 (.)
    /**
     * Il percorso della vista.
     *
     * @var string
     */
    public string $view = 'cms::components.footer';

    /**
     * Il colore di sfondo.
     *
     * @var string|null
     */
    public ?string $background_color;

    /**
     * L'immagine di sfondo.
     *
     * @var string|null
     */
    public ?string $background;

    /**
     * Il colore dell'overlay.
     *
     * @var string|null
     */
    public ?string $overlay_color;

    /**
     * Il template personalizzato.
     *
     * @var string|null
     */
    public ?string $_tpl;
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)

    /**
     * L'istanza singleton.
     *
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * Crea una nuova istanza dei dati del footer.
     *
     * @return self
     */
    public static function make(): self
    {
        if (!self::$instance instanceof FooterData) {
            $data = TenantService::getConfig('appearance');
            $data = Arr::get($data, 'footer', []);
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Renderizza la vista del footer.
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
        /** @var array<string, mixed> */
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
            'view' => ['nullable', 'string'],
            '_tpl' => ['nullable', 'string'],
        ];
    }
<<<<<<< HEAD
=======
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
}
