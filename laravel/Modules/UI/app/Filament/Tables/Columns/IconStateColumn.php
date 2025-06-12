<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Exception;
use Illuminate\Support\Arr;
use Spatie\ModelStates\State;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Actions\Action;

class IconStateColumn extends IconColumn
{

    protected function setUp(): void
    {
        parent::setUp();
        //$this->getStateUsing(fn() => true); // the column requires a state to be passed to it
        $this->icon(fn($state): string => $state->icon());
        $this->color(fn($state): string => $state->color());
        $this->tooltip(fn($state): string => $state->label());
        //$this->label('aaa');

        $this->action(Action::make('change-state')
            ->form([
                Select::make('state')
                    ->options(
                        function (Model $record ,string $state): array {

                            $name=$this->getName();
                            $state=$record->getAttribute($name);
                            if($state==null){
                                // Verifica se il metodo esiste prima di chiamarlo
                                if (!method_exists($record, 'getDefaultStateFor')) {
                                    return [];
                                }
                                $states=Arr::wrap($record->getDefaultStateFor($name));
                                return array_combine($states, $states);
                            }
                            try{
                                //$states=$record->getAttribute($name)->transitionableStates();
                                if (!is_object($state) || !method_exists($state, 'transitionableStates')) {
                                    throw new Exception('Method not available');
                                }
                                $states=$state->transitionableStates();
                            }catch(Exception $e){
                                // Verifica se il metodo esiste prima di chiamarlo
                                if (!method_exists($record, 'getStatesFor')) {
                                    return [];
                                }
                                $states=$record->getStatesFor($name)->toArray();;
                            }
                            $stateName = is_object($state) && property_exists($state, 'name') ? $state::$name : '';
                            $states=[$stateName, ...$states];
                            $states=array_combine($states, $states);
                            //dddx(['state'=>$state, 'state1'=>$record->getAttribute($name),'record'=>$record]);

                            return $states;
                        }
                    ),
                Textarea::make('message'),
            ])
            ->fillForm(function($record){
                //dddx($record->state);//Modules\SaluteOra\States\User\Pending
                return [
                    'state' => $record->state::$name,
                ];
            })
            ->action(function($record, $data) {
                //dddx(['record'=>$record, 'data'=>$data]);
                $record->state->transitionTo($data['state'],$data['message']);

            })
        );


    }




}