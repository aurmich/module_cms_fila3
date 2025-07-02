<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Webmozart\Assert\Assert;
use Carbon\Carbon;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use function Safe\json_encode;
// use Squire\Models\Country;

class OpeningHoursField extends Field
{
    /**
     * Vista Blade per il rendering del componente.
     */
    protected string $view = 'ui::filament.forms.components.opening-hours-field';

    protected function setUp(): void
    {
        parent::setUp();

        $days = collect([
            Carbon::MONDAY,
            Carbon::TUESDAY,
            Carbon::WEDNESDAY,
            Carbon::THURSDAY,
            Carbon::FRIDAY,
            Carbon::SATURDAY,
        ])->mapWithKeys(function ($day) {
            /** @phpstan-ignore-next-line */
            $dayKey = strtolower(Carbon::create()->startOfWeek()->addDays($day - 1)->format('l'));
            /** @phpstan-ignore-next-line */
            $dayLabel = ucfirst(Carbon::create()->startOfWeek()->addDays($day - 1)->isoFormat('dddd'));
            return [$dayKey => $dayLabel];
        });

        $schema = [];

       
        
        foreach ($days as $dayKey => $dayLabel) {
            $schema[]=
                    // Mattina
                    Placeholder::make($dayKey.'_label')
                    ->label('')
                    ->content($dayLabel)
                    ->extraAttributes(['class' => 'font-medium text-gray-900 dark:text-gray-100 text-center py-2'])
                    ->columnSpan(1);

            $schema[]=TimePicker::make("$dayKey.morning_from")
                            ->placeholder('08:00')
                            ->seconds(false)
                            ->minutesStep(15)
                            ->nullable()
                            ->live();
                        
            $schema[]=TimePicker::make("$dayKey.morning_to")
                            ->placeholder('12:30')
                            ->seconds(false)
                            ->minutesStep(15)
                            ->nullable()
                            ->live();
                    
            $schema[]=TimePicker::make("$dayKey.afternoon_from")
                            ->placeholder('15:00')
                            ->seconds(false)
                            ->minutesStep(15)
                            ->nullable()
                            ->live();
                        
            $schema[]=TimePicker::make("$dayKey.afternoon_to")
                            ->placeholder('19:00')
                            ->seconds(false)
                            ->minutesStep(15)
                            ->nullable()
                            ->live();
                    
            
        }
         
        $this->schema($schema)->columns(5);
    }
}
