<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum PatientStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
