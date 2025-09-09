<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Livewire\Wireable;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;
use Modules\Tenant\Services\TenantService;
use Illuminate\Contracts\Support\Renderable;
use Spatie\LaravelData\Concerns\WireableData;
use Modules\Xot\Actions\View\GetViewPathAction;

class BlockData extends Data implements Wireable
{
    use WireableData;
    public string $type;
    public array $data;
    public string $view;
    public string $slug='--';

    public function __construct(string $type,array $data){
        $this->type=$type;
        $this->data=$data;
        Assert::string($view=Arr::get($data,'view','ui::empty'));
        if(!view()->exists($view)){
            $view_path=app(GetViewPathAction::class)->execute($view);
            throw new \Exception('view not found: ['.$view.'] path: ['.$view_path.']');
        }
        $this->view=$view;
    }
}
