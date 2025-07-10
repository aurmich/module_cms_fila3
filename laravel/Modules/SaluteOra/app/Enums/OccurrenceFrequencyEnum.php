<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum OccurrenceFrequencyEnum: string
{
    case NEVER = 'never';
    case ALMOST_NEVER = 'almost_never';
    case RARELY = 'rarely';
    case OCCASIONALLY = 'occasionally';
    case QUITE_OFTEN = 'quite_often';
    case FREQUENTLY = 'frequently';
}
