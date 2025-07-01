<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Exception;
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
        $this->options(function (Model&HasStatesContract $record): array {
            $name=$this->getName();
            $states=$record->getStatesFor($name)->toArray();
            /*
            dddx([
                'name'=>$name,
                'states'=>$states,
                'record'=>$record,
                'state'=>$record->state,
                'default_state'=>$record->getDefaultStates(),
                'default_states_for'=>$record->getDefaultStateFor($name),
                'record_method'=>get_class_methods($record),
                'userstate_method'=>get_class_methods(UserState::class),
                //'aa'=>$record->state->transitionableStates(),
                //'getStateConfigurations'=>$record->getStateConfigurations(),
            ]);
            */
            /**
             * @var array<int|string>
             * @phpstan-ignore-next-line
             */
            return array_combine($states, $states);
        });
       
    }

   
}