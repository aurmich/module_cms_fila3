<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets\Doctor;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Webmozart\Assert\Assert;
use Illuminate\Support\Collection;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Group;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Modules\SaluteOra\Models\StudioUser;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Actions\Concerns\InteractsWithActions;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;

/**
 * DoctorAvailabilitiesWidget
 *
 * Widget per visualizzare tutti gli studi in cui lavora il dottore
 * e i relativi orari di disponibilità (schedule) configurati.
 * .
 * Caratteristiche:
 * - Multi-studio overview per dottori
 * - Visualizzazione schedule dal pivot studio_user
 * - Link diretti per modifica orari per studio
 * - Studio principale evidenziato
 * - Gestione empty states
 * - Security: solo per UserType::DOCTOR
 * 
 * @property-read Collection<int, array> $studios_schedules
 * @property-read User $doctor
 */
class ProfileWidget extends XotBaseWidget 
{
    public Doctor $user;
    /**
     * Vista del widget.
     */
    protected static string $view = 'pub_theme::filament.widgets.doctor.profile';

   

    public function getFormSchema(): array
    {
        return [
            //OpeningHoursField::make('schedule')
            //    ->columnSpanFull(),
        ];
    }

    public function mount(): void
    {
       // dddx('a');
        $user=auth()->user();
        Assert::isInstanceOf($user, Doctor::class);
        $this->user = $user;
    }

    
    

    /**
     * Ottiene i dati per la vista.
     * 
     * Recupera tutti gli studi associati al dottore con i relativi
     * schedule dalla tabella pivot studio_user.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
       
        /*
        $patient = auth()->user();
        Assert::isInstanceOf($patient, Patient::class);        
        
        return [
            
            'patient' => $patient,
        ];*/
        return [];
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-pencil')
            ->modalHeading(static::trans('actions.edit.modal_heading'))
            ->modalDescription(static::trans('actions.edit.modal_description'))

            //->action(fn () => $this->post->delete())
            ->form([
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                //TextInput::make('email'),
                TextInput::make('phone'),
                TextInput::make('address'),
            ])
            ->fillForm(fn()=>$this->user->attributesToArray())
            ->action(function(array $data){
                $this->user->update($data);
            })
            ;
    }

    

   
} 