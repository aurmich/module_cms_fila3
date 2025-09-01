<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Illuminate\Support\Arr;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class BlockData extends Data implements Wireable
{
    use WireableData;

    public string $type;

    public array $data;

    public string $view;

    public string $slug = '---';

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
        Assert::string($view = Arr::get($data, 'view', 'ui::empty'));
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }
        $this->view = $view;
    }
}
