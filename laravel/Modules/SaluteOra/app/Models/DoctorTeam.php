<?php
declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;

class DoctorTeam extends TeamUser
{
    use HasParent;
    
    //protected $connection = 'salute_ora'; //in teamuser è già impostato
}
