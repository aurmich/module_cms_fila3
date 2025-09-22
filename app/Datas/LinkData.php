<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

class LinkData extends Data
{
    public string $title;

    public string $icon;

    public string $url;

    public bool $active = false;

    public bool $render = true;

<<<<<<< HEAD
    public null|string $onclick = null;
=======
    public ?string $onclick = null;
>>>>>>> bc33217 (.)
}
