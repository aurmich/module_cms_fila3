<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Modules\SaluteOra\Models\Appointment;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class DoctorCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;
    public string $calendarContainerClass = '';

    protected function headerActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            /*
            \Filament\Actions\Action::make('studio')
            ->label(fn () => 'Studio: ' . optional($this->studio)->name)
            //->disabled() // Solo visualizzazione
            ->form([
                Forms\Components\Select::make('authorId')
                    ->label('Author')
                    ->options(['1'=>'1','2'=>'2'])
                    ->required(),
            ])->action(function ($data) {
                dd($data);
            })
            ->color('gray'),
           */
        ];
    }

    protected function modalActions(): array
    {
        return [
            //Actions\EditAction::make(),
            //Actions\DeleteAction::make(),
        ];
    }

    public function config(): array
    {
        $lang=app()->getLocale();
        
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                //'left' => 'dayGridWeek,dayGridMonth',
                'left' => 'prev',
                'center' => 'title',
                //'right' => 'today prev,next',
                //'right' => 'prev,next',
                'right' => 'next',
            ],
            'titleFormat' => [
                'year' => 'numeric',
                'month' => 'long' // Questo dovrebbe capitalizzare automaticamente
            ],
            'locale' =>  $lang
        ];
    }

   

    //protected function viewAction(): Action
    //{
    //    return Actions\ViewAction::make();
    //}

    public function getFormSchema(): array
    {
       
        return [
           Forms\Components\Grid::make('patient')
               ->relationship('patient')
               ->schema([
                    'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
            'fiscal_code' => Forms\Components\TextInput::make('fiscal_code')
                ->required()
                ->maxLength(16),
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(20),
                ])->columns(2),

            Forms\Components\Grid::make()
                ->schema([
                   // Forms\Components\TextInput::make('patient.first_name')
                   // ->formatStateUsing(fn($state,$record) => $record->patient->first_name),
                    //Forms\Components\TextInput::make('patient.last_name')
                    //->formatStateUsing(fn($state,$record) => $record->patient->last_name),
                    Forms\Components\DateTimePicker::make('starts_at'),
                    Forms\Components\DateTimePicker::make('ends_at'),
                ]),
            Forms\Components\Textarea::make('notes'),
            Forms\Components\TextInput::make('state'),
        ];
    }


    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->where('doctor_id',auth()->id())
            ->get()
            ->map(
                fn (Appointment $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->patient()->first()->full_name ?? 'N/A')
                    /** @phpstan-ignore argument.type */
                    ->start($event->starts_at)
                    ->end($event->ends_at)
                    ->backgroundColor($event->state->bgColor())
                    //->backgroundColor('#00aa00')
                    ->borderColor($event->state->bgColor())
                    //->textColor('blue')
                    ->textColor($event->state->bgColor())
                    //->textColor('blue')
                    //->extraProperties(['class'=>['text-gray-600']])
                    //->url(
                    //    url: EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    //    shouldOpenUrlInNewTab: true
                    //)
            )
            ->toArray();
    }
}