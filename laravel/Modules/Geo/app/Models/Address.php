<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'formatted_address',
        'latitude',
        'longitude',
        'street_number',
        'route',
        'locality',
        'postal_code',
        'country',
    ];

    // Definisci le relazioni e i metodi necessari per la classe Address
}
