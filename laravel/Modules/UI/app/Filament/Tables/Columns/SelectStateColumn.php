<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Exception;
use Illuminate\Support\Arr;
use Spatie\ModelStates\State;
use Modules\SaluteOra\Models\User;
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
                $states=Arr::wrap($record->getDefaultStateFor($name));
                return array_combine($states, $states);
            }
            try{
                //$states=$record->getAttribute($name)->transitionableStates();
                $states=$state->transitionableStates();
            }catch(Exception $e){
                $states=$states=$record->getStatesFor($name)->toArray();;
            }
            $states[]=$state::$name;


            return array_combine($states, $states);
        });

    }


}