<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Webmozart\Assert\Assert;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Field;

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
            $dayKey = strtolower(Carbon::create()->startOfWeek()->addDays($day - 1)->format('l'));
            $dayLabel = ucfirst(Carbon::create()->startOfWeek()->addDays($day - 1)->isoFormat('dddd'));
            return [$dayKey => $dayLabel];
        });

        $this->schema([
            // Intestazioni delle colonne con stile coerente
            Grid::make(3)->schema([
                Placeholder::make('header_day')
                    ->label('')
                    ->content(__('ui::opening_hours.headers.day'))
                    ->extraAttributes(['class' => 'font-semibold text-gray-700 dark:text-gray-300 text-center py-3']),
                
                Placeholder::make('header_morning')
                    ->label('')
                    ->content(__('ui::opening_hours.headers.morning'))
                    ->extraAttributes(['class' => 'font-semibold text-gray-700 dark:text-gray-300 text-center py-3']),
                
                Placeholder::make('header_afternoon')
                    ->label('')
                    ->content(__('ui::opening_hours.headers.afternoon'))
                    ->extraAttributes(['class' => 'font-semibold text-gray-700 dark:text-gray-300 text-center py-3']),
            ])
            ->columnSpanFull()
            ->extraAttributes(['class' => 'bg-gray-100 dark:bg-gray-700 rounded-lg px-2 py-1 mb-2 border-b-2 border-gray-200 dark:border-gray-600']),

            // Righe dei giorni con zebra striping
            Grid::make(1)
                ->schema(
                    $days->map(function ($label, $dayKey) use ($days) {
                        // Determina l'indice della riga per le righe alternate (zebra striping)
                        $dayIndex = array_search($dayKey, array_keys($days->toArray()));
                        $isEvenRow = $dayIndex % 2 === 0;
                        
                        // Classi CSS per righe alternate: migliora leggibilità e UX
                        // Righe pari: grigio chiaro, Righe dispari: bianco
                        $rowClass = $isEvenRow 
                            ? 'bg-gray-50 dark:bg-gray-800/50 rounded-lg px-2 py-1'   // Riga pari
                            : 'bg-white dark:bg-gray-900/50 rounded-lg px-2 py-1';    // Riga dispari
                        
                        return Grid::make(3)->schema([
                            // Prima colonna: Nome del giorno
                            Placeholder::make($dayKey.'_label')
                                ->label('')
                                ->content($label)
                                ->extraAttributes(['class' => 'font-medium text-gray-900 dark:text-gray-100 text-center py-2'])
                                ->columnSpan(1),

                            // Seconda colonna: Mattina (Due TimePicker)
                            Group::make([
                                Grid::make(2)->schema([
                                    TimePicker::make("$dayKey.morning_from")
                                        ->label(__('ui::opening_hours.labels.from'))
                                        ->placeholder('08:00')
                                        ->seconds(false)
                                        ->minutesStep(15)
                                        ->nullable()
                                        ->live()
                                        //->rules(['before_or_equal:' . $dayKey . '.morning_to'])
                                        ,
                                    
                                    TimePicker::make("$dayKey.morning_to")
                                        ->label(__('ui::opening_hours.labels.to'))
                                        ->placeholder('12:30')
                                        ->seconds(false)
                                        ->minutesStep(15)
                                        ->nullable()
                                        ->live()
                                        ->rules(['after_or_equal:' . $dayKey . '.morning_from']),
                                ])
                            ])
                            ->columnSpan(1),

                            // Terza colonna: Pomeriggio (Due TimePicker)
                            Group::make([
                                Grid::make(2)->schema([
                                    TimePicker::make("$dayKey.afternoon_from")
                                        ->label(__('ui::opening_hours.labels.from'))
                                        ->placeholder('15:00')
                                        ->seconds(false)
                                        ->minutesStep(15)
                                        ->nullable()
                                        ->live()
                                        ->rules(['before_or_equal:' . $dayKey . '.afternoon_to']),
                                    
                                    TimePicker::make("$dayKey.afternoon_to")
                                        ->label(__('ui::opening_hours.labels.to'))
                                        ->placeholder('19:00')
                                        ->seconds(false)
                                        ->minutesStep(15)
                                        ->nullable()
                                        ->live()
                                        ->rules(['after_or_equal:' . $dayKey . '.afternoon_from']),
                                ])
                            ])
                            ->columnSpan(1),
                        ])
                        ->columnSpanFull()
                        ->extraAttributes(['class' => $rowClass . ' transition-colors duration-200 hover:bg-blue-50 dark:hover:bg-blue-900/20']);
                    })->values()->toArray()
                )
        ])
        ->columns(1);
    }

   
}
