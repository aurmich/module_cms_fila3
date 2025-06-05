<?php

namespace Modules\SaluteOra\States;

use Spatie\ModelStates\State;

abstract class DoctorState extends State
{
    public static function config(): \Spatie\ModelStates\StateConfig
    {
        return parent::config()
            ->default(Pending::class);
    }
}
