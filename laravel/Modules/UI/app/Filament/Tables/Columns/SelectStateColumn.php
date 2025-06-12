<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Exception;
use Illuminate\Support\Arr;
use Spatie\ModelStates\State;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\SelectColumn;
use Modules\SaluteOra\States\User\UserState;

class SelectStateColumn extends SelectColumn
{

    protected function setUp(): void
    {
        parent::setUp();
      //  $this->selectablePlaceholder(false);
        $this->options(function (Model $record ,$state): array {
            $name=$this->getName();
            if($state==null){
                if (!method_exists($record, 'getDefaultStateFor')) {
                    return [];
                }
                $states=Arr::wrap($record->getDefaultStateFor($name));
                return array_combine($states, $states);
            }
            try{
                if (!is_object($state) || !method_exists($state, 'transitionableStates')) {
                    throw new Exception('Method not available');
                }
                $states=$state->transitionableStates();
            }catch(Exception $e){
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
        });


        $this->beforeStateUpdated(function (Model $record, $state) {
            $message='';
            if (property_exists($record, 'state') && $record->state !== null) {
                $record->state->transitionTo($state,$message);
            }
        });


    }




}