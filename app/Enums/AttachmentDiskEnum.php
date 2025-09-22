<?php

<<<<<<< HEAD
declare(strict_types=1);


namespace Modules\Cms\Enums;

use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Arr;
=======
namespace Modules\Cms\Enums;

use Illuminate\Support\Arr;
use Filament\Support\Contracts\HasIcon;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Traits\TransTrait;

enum AttachmentDiskEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;

    case public_html = 'public_html';
    case videos = 'videos';
    case local = 'local';
<<<<<<< HEAD

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
=======
    


    public function getLabel(): string
    {
        return $this->transClass(self::class,$this->value.'.label');
>>>>>>> bc33217 (.)
    }

    public function getColor(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value . '.color');
=======
        return $this->transClass(self::class,$this->value.'.color');

>>>>>>> bc33217 (.)
    }

    public function getIcon(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value . '.icon');
=======
        return $this->transClass(self::class,$this->value.'.icon');
>>>>>>> bc33217 (.)
    }

    public function getDescription(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value . '.description');
    }
=======
        return $this->transClass(self::class,$this->value.'.description');
    }

>>>>>>> bc33217 (.)
}
