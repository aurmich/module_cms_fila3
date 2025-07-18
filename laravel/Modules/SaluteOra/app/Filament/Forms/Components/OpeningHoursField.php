<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseField;

use Illuminate\Contracts\View\View;
use Spatie\OpeningHours\OpeningHours;
use function Safe\json_decode;
use function Safe\json_encode;

class OpeningHoursField extends XotBaseField
{
    /** @phpstan-ignore property.defaultValue */
    protected string $view = 'saluteora::filament.forms.components.opening-hours-field';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateHydrated(function (self $component, $state): void {
            if (is_string($state)) {
                $state = json_decode($state, true);
            }
            
            if (!is_array($state)) {
                $state = $this->getDefaultState();
            }
            
            // ⚠️ RIMOZIONE CHIAMATA RICORSIVA - causa loop infinito
            // $component->state($state); // QUESTO CAUSAVA IL LOOP!
            
            // ✅ Lo state è già gestito dal framework, non serve forzarlo
        });
        
        $this->dehydrateStateUsing(function ($state) {
            return is_array($state) ? json_encode($state) : $state;
        });
        
        $this->default([
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
        ]);
    }
    
    public function getDefaultState(): array
    {
        return [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
        ];
    }
    
    public function isOpenNow(): bool
    {
        /** @phpstan-ignore argument.type */
        $openingHours = OpeningHours::create($this->getState());
        return $openingHours->isOpen();
    }
}