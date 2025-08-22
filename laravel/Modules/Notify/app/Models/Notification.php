<?php

namespace Modules\Notify\Models;

use Modules\Xot\Models\BaseModel;

/**
 * Notification model for the Notify module.
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array<string, mixed>|string $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property int|null $tenant_id
 * @property int|null $user_id
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property array<string>|string|null $channels
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property-read \Illuminate\Database\Eloquent\Model|null $creator
 * @property-read \Illuminate\Database\Eloquent\Model|null $updater
 * @method static \Modules\Notify\Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedBy($value)
 * @mixin IdeHelperNotification
 * @mixin \Eloquent
 */
class Notification extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'message',
        'type',
        'read_at',
        'tenant_id',
        'user_id',
        'subject_type',
        'subject_id',
        'channels',
        'status',
        'sent_at',
        'data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'sent_at' => 'datetime',
            'data' => 'array',
            'channels' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
