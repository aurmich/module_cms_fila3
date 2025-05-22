<?php

namespace Modules\SaluteOra\States;

use Spatie\ModelStates\State;

class Pending extends State
{
    public static $name = 'pending';

    public function color(): string
    {
        return 'warning';
    }

    public function display(): string
    {
        return __('saluteora::states.pending');
    }
}
