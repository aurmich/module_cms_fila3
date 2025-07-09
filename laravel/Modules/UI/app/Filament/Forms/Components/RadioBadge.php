<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Radio;

class RadioBadge extends Radio
{
    protected string $view = 'ui::filament.forms.components.radio-badge';
    protected string $defaultColor = 'gray-200'; // gray-200
    protected string $selectedColor = 'blue-500';//'#3b82f6'; // blue-500
   
    public function getColorForOption(string $value): string
    {
       
        if (is_string($this->options) && enum_exists($this->options)) {
            $enumClass = $this->options;
            $color = $enumClass::tryFrom($value)?->getColor();
            return $color ?? $this->selectedColor;
        }
        return $this->selectedColor;
    }

    
    public function getIconForOption(string $value): ?string
    {
       
        if (is_string($this->options) && enum_exists($this->options)) {
            $enumClass = $this->options;
            $icon = $enumClass::tryFrom($value)?->getIcon();
            return $icon;
        }
        return null;
    }

    public function defaultColor(string $color): static
    {
        $this->defaultColor = $color;
        return $this;
    }

    public function selectedColor(string $color): static
    {
        $this->selectedColor = $color;
        return $this;
    }

    
}