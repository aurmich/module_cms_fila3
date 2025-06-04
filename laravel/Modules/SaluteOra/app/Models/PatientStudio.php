<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SaluteOra\Models\User;
use Parental\HasParent;



class PatientStudio extends StudioUser
{
    use HasParent;
}