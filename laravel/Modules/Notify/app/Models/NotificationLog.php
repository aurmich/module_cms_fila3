<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property int $id
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $title
 * @property string $content
 * @property string $channels
 * @property string|null $data
 * @property \Illuminate\Support\Carbon $sent_at
 * @property string $status
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $notifiable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereChannels($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'type',
        'channel',
        'recipient',
        'subject',
        'message',
        'status',
        'sent_at',
        'read_at',
        'error_message',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * The possible status values.
     *
     * @var array<string, string>
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_FAILED = 'failed';
    public const STATUS_READ = 'read';

    /**
     * Get the parent notifiable model.
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
