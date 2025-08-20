<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;


use Closure;
use Livewire\Attributes\On;
use Webmozart\Assert\Assert;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Column;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Modules\Xot\Contracts\StateContract;
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
                Assert::isInstanceOf($stateInstance, StateContract::class);
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

    public function canTransitionTo(int|string $recordId, string $stateClass): bool
    {  
        $record = $this->modelClass::find($recordId);
        
        if (!$record) {
            return false;
        }
        
        if (!$record->state) {
            return false;
        }
        
        return $record->state->canTransitionTo($stateClass);
    }

    /**
     * Metodo per testare le azioni
     */
    public function prova(int|string $recordId): void
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
     * 
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getStateActions(): array
    {
        $record = $this->getRecord();
        $states = $this->getRecordStates();
        
        $actions = [];
        
        // Aggiungi azione di test
        $actions['prova'] = \Filament\Tables\Actions\Action::make('prova')
            ->icon('heroicon-m-plus')
            ->color('primary')
            ->tooltip('Test Prova')
            ->action(function () use ($record) {
                $recordId = $record && isset($record->id) ? (string) $record->id : 'N/A';
                \Filament\Notifications\Notification::make()
                    ->title('Prova funziona!')
                    ->body('Record ID: ' . $recordId)
                    ->success()
                    ->send();
            });
        
        // Aggiungi azioni per gli stati
        foreach ($states as $stateKey => $state) {
            $recordId = $record && isset($record->id) ? $record->id : null;
            if ($recordId !== null && $this->canTransitionTo($recordId, $state['class']::class)) {
                $actions["transition_to_{$stateKey}"] = \Filament\Tables\Actions\Action::make("transition_to_{$stateKey}")
                    ->icon($state['icon'])
                    ->color($state['color'])
                    ->label($state['label'])
                    ->action(fn() => $this->transitionState($recordId, $state['class']::class));
            }
        }
        
        return $actions;
    }

    /**
     * Listener per l'evento table-action
     */
    #[On('table-action')]
    public function handleTableAction(string $action, int|string $recordId): void
    {
        if ($action === 'prova') {
            $this->prova($recordId);
        }
    }

    /**
     * Metodo per eseguire la transizione di stato
     */
    public function transitionState(int|string $recordId, string $stateClass): void
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