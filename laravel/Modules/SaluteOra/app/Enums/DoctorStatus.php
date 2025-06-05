<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
