<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Exception;
use Illuminate\Support\Arr;
use Spatie\ModelStates\State;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\SelectColumn;
use Spatie\ModelStates\HasStatesContract;
use Modules\SaluteOra\States\User\UserState;

class SelectState extends Select
{

    protected function setUp(): void
    {
        parent::setUp();
       
      //  $this->selectablePlaceholder(false);
        $this->options(function ((Model&HasStatesContract)|null $record): array {
            $name=$this->getName();
            if(is_null($record)){
                $model=$this->getModel();
                $states=Arr::wrap(app($model)->getDefaultStateFor($name));
                /**
             * @var array<int|string>
             * @phpstan-ignore argument.type
             */
                return array_combine($states, $states);
                
            }
            
            $states=$record->getStatesFor($name)->toArray();
            
            /**
             * @var array<int|string>
             * @phpstan-ignore argument.type
             */
            return array_combine($states, $states);
        });
        $this->required();
       
    }

   
}
