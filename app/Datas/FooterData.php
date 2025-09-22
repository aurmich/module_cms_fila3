<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use Livewire\Wireable;
use Modules\Tenant\Services\TenantService;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class FooterData extends Data implements Wireable
{
    use WireableData;

<<<<<<< HEAD
    public null|string $background_color;
    public null|string $background;
    public null|string $overlay_color;
=======
    public ?string $background_color;
    public ?string $background;
    public ?string $overlay_color;
>>>>>>> bc33217 (.)
    /**
     * The view path.
     *
     * @var string
     */
    public $view = 'cms::components.footer';
<<<<<<< HEAD
    public null|string $_tpl;

    private static null|self $instance = null;

    public static function make(): self
    {
        if (!(self::$instance instanceof FooterData)) {
=======
    public ?string $_tpl;

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! self::$instance instanceof FooterData) {
>>>>>>> bc33217 (.)
            $data = TenantService::getConfig('appearance');
            $data = Arr::get($data, 'footer', []);
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function view(): Renderable
    {
<<<<<<< HEAD
        if (!view()->exists($this->view)) {
            $message = 'The view [' . $this->view . '] does not exist';
=======
        if (! view()->exists($this->view)) {
            $message = 'The view ['.$this->view.'] does not exist';
>>>>>>> bc33217 (.)
            throw new \Exception($message);
        }
        /** @var array<string, mixed> */
        $view_params = $this->toArray();

        return view($this->view, $view_params);
    }

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
}
