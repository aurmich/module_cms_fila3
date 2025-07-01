<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

class TestInlineDatePickerPage extends Page
{
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static string $view = 'ui::filament.pages.test-inline-date-picker';
    
    protected static ?string $navigationLabel = 'Test InlineDatePicker';
    
    protected static ?string $navigationGroup = 'Test';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Test InlineDatePicker')
                    ->description('Test del componente InlineDatePicker con date abilitate')
                    ->schema([
                        InlineDatePicker::make('appointment_date')
                            ->label(__('Data appuntamento'))
                            ->enabledDates([
                                now()->format('Y-m-d'),
                                now()->addDays(2)->format('Y-m-d'),
                                now()->addDays(5)->format('Y-m-d'),
                                now()->addDays(8)->format('Y-m-d'),
                            ])
                            ->calendarConfig([
                                'locale' => 'it',
                                'firstDayOfWeek' => 1,
                                'numberOfMonths' => 2,
                            ])
                            ->required(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }
}
