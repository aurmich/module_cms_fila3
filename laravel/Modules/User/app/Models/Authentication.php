<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property int $id
 * @property string $type
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $authenticatable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Authentication whereUserAgent($value)
 * @mixin \Eloquent
 */
class Authentication extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'login_at',
        'login_successful',
        'logout_at',
        'authenticatable_type',
        'authenticatable_id',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
        'login_successful' => 'boolean',
    ];

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }
}
