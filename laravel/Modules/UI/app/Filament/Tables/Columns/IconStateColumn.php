<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Spatie\ModelStates\State;
use Modules\SaluteOra\Models\User;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Spatie\ModelStates\HasStatesContract;

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
                        function (Model&HasStatesContract $record ,string $state): array {

                            $name=$this->getName();
                            $state=$record->getAttribute($name);
                            if($state==null){
                                $states=Arr::wrap($record->getDefaultStateFor($name));
                                return array_combine($states, $states);
                            }
                            Assert::isInstanceOf($state, State::class);
                            
                            try{
                                //$states=$record->getAttribute($name)->transitionableStates();
                                $states=$state->transitionableStates();
                            }catch(Exception $e){
                                $states=$record->getStatesFor($name)->toArray();;
                            }
                            /** @phpstan-ignore-next-line */
                            //$states=[$state::$name, ...$states];
                            //$states=array_combine($states, $states);
                            $states=Arr::mapWithKeys($states,function($state) use ($record){
                                $model=Str::of(class_basename($record))->slug()->toString();
                                /** @phpstan-ignore-next-line */
                                Assert::string($label=__('pub_theme::'.$model.'_states.'.$state.'.label'));
                                return [$state=>$label];
                            });
                            
                            //dddx(['state'=>$state, 'state1'=>$record->getAttribute($name),'record'=>$record]);

                            return $states;
                        }
                    )
                    ->required(),
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