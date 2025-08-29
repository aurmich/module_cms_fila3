<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColumnGroup;
use Modules\Xot\Contracts\StateContract;

class IconStateGroupColumn extends ColumnGroup
{

    public string $stateClass='';
    public string $modelClass='';
    public array $data=[];

    
    protected function setUp(): void
    {
        //$this->label('');
       
    }

 


    public function stateClass(string $stateClass,string $modelClass): static
    {
        $this->stateClass = $stateClass;
        $this->modelClass = $modelClass;
        $states=$this->stateClass::getStateMapping()->toArray();
        $columns = [];
        
        
        foreach($states as $state=>$stateClass){
            $stateInstance=new $stateClass($this->modelClass);
            Assert::isInstanceOf($stateInstance,StateContract::class);
            $this->data[$state.'-visible']=true;
                
            $column = IconColumn::make($state.'-icon')
                ->icon(fn()=>$stateInstance->icon())
                ->color(fn()=>$stateInstance->color())
                ->tooltip(fn()=>$stateInstance->label())
                ->extraAttributes([
                    'class' => 'w-auto min-w-0 px-0',
                    'style' => 'width: fit-content !important;'
                ])
                ->extraCellAttributes(['class' => 'px-1 py-1'])
                ->label('')
                ->default(function($record,Set $set) use ($stateClass,$state){
                     $res=$record->state->canTransitionTo($stateClass);
                     $this->data[$state.'-visible']=$res;
                     if(!$res){
                        return null;
                     }
                     return true;
                });
            $column->action(Action::make($state.'-action')
                    ->requiresConfirmation()
                    ->modalHeading(fn($record)=>$stateInstance->modalHeading())
                    ->modalDescription(fn($record)=>$stateInstance->modalDescription())
                    ->form(fn($record)=>$stateInstance->modalFormSchema())
                    ->fillForm(fn($record)=>$stateInstance->modalFillFormByRecord($record))
                    ->action(function($record,$data) use ($stateInstance){
                        $stateInstance->modalActionByRecord($record,$data);
                        //$this->invalidateCache();
                        //$this->loadAppointments();
                        //$this->dispatch('notify', [
                        //    'type' => 'success',
                        //    'message' => __('ui::messages.action_completed'),
                        //]);
                    })
                
                )
                ;
            $column->visible($this->data[$state.'-visible']);
            $columns[] = $column;
        }
        
        $this->columns($columns);
        return $this;
    }
}