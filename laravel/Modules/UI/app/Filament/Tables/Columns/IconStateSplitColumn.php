<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;


use Closure;
use Livewire\Attributes\On;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Split;

/**
 * IconStateSplitColumn - Enhanced state transition column with compact grid layout
 * 
 * This column displays state transition icons in a compact grid layout with:
 * - Optimized space usage with responsive grid
 * - Enhanced tooltips and visual feedback
 * - Smooth animations and hover effects
 * - Proper error handling and notifications
 * - Mobile-friendly design
 * 
 * @package Modules\UI\Filament\Tables\Columns
 */
class IconStateSplitColumn extends Column
{
    protected string $view = 'ui::filament.tables.columns.icon-state-split';
    protected string $stateClass = '';
    protected string $modelClass = '';
    

   
   
    /**
     * Configure the state class and model class for this column
     * 
     * @param string $stateClass The state machine class (e.g., AppointmentState::class)
     * @param string $modelClass The model class (e.g., Appointment::class)
     * @return static
     */
    public function stateClass(string $stateClass, string $modelClass): static
    {
        $this->stateClass = $stateClass;
        $this->modelClass = $modelClass;
        
        return $this;
    }

    public function getRecordStates(): array
    {
        $states = $this->stateClass::getStateMapping()->toArray();
        $record = $this->getRecord();
        
        $result = [];
        foreach ($states as $stateKey => $stateClass) {
            try {
                $stateInstance = new $stateClass($record);
                $result[$stateKey] = [
                    'class' => $stateInstance,
                    'icon' => $stateInstance->icon(),
                    'label' => $stateInstance->label(),
                    'color' => $stateInstance->color(),
                    'tooltip' => $stateInstance->label(),
                ];
            } catch (\Exception $e) {
                // Skip problematic states
                continue;
            }
        }
        
        return $result;
    }

    public function canTransitionTo($recordId, $stateClass): bool
    {  
        return true;
        $record = $this->modelClass::find($recordId);
        
        if (!$record || !$record->state) {
            return false;
        }
        
        return $record->state->canTransitionTo($stateClass);
    }

    /**
     * Metodo per testare le azioni
     */
    public function prova($recordId): void
    {
        // Logica per testare l'azione
        \Filament\Notifications\Notification::make()
            ->title('Test Azione')
            ->body("Record ID: {$recordId}")
            ->success()
            ->send();
    }

    /**
     * Restituisce le azioni per gli stati
     */
    public function getStateActions(): array
    {
        $record = $this->getRecord();
        $states = $this->getRecordStates();
        
        $actions = [];
        
        // Aggiungi azione di test
        $actions[] = \Filament\Tables\Actions\Action::make('prova')
            ->icon('heroicon-m-plus')
            ->color('primary')
            ->tooltip('Test Prova')
            ->action(function () use ($record) {
                \Filament\Notifications\Notification::make()
                    ->title('Prova funziona!')
                    ->body('Record ID: ' . $record->id)
                    ->success()
                    ->send();
            });
        
        // Aggiungi azioni per gli stati
        foreach ($states as $stateKey => $state) {
            if ($this->canTransitionTo($record->id, $state['class']::class)) {
                $actions[] = \Filament\Tables\Actions\Action::make("transition_to_{$stateKey}")
                    ->icon($state['icon'])
                    ->color($state['color'])
                    ->label($state['label'])
                    ->action(fn() => $this->transitionState($record->id, $state['class']::class));
            }
        }
        
        return $actions;
    }

    /**
     * Listener per l'evento table-action
     */
    #[On('table-action')]
    public function handleTableAction($action, $recordId): void
    {
        if ($action === 'prova') {
            $this->prova($recordId);
        }
    }

    /**
     * Metodo per eseguire la transizione di stato
     */
    public function transitionState($recordId, $stateClass): void
    {
        try {
            $record = $this->modelClass::find($recordId);
            
            if (!$record) {
                throw new \Exception('Record non trovato');
            }
            
            // Esegui la transizione
            $record->state->transitionTo($stateClass);
            
            \Filament\Notifications\Notification::make()
                ->title('Transizione Completata')
                ->body('Lo stato è stato cambiato con successo.')
                ->success()
                ->send();
                
        } catch (\Exception $e) {
            \Filament\Notifications\Notification::make()
                ->title('Errore Transizione')
                ->body('Si è verificato un errore: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}