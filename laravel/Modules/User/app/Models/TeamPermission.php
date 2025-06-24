<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\User\Models\TeamPermission
 *
 * @property string $id
 * @property string $team_id
 * @property string $user_id
 * @property string $permission
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property Team $team
 * @property User $user
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a3f7230 (.)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamPermission query()
 * @mixin \Eloquent
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
 */
class TeamPermission extends Model
{
    /** @var string */
    protected $connection = 'user';

<<<<<<< HEAD
<<<<<<< HEAD
    /** @var array<string> */
=======
    /** @var list<string> */
>>>>>>> aurmich/dev
=======
    /** @var list<string> */
>>>>>>> a3f7230 (.)
    protected $fillable = [
        'team_id',
        'user_id',
        'permission',
    ];

    /**
     * Get the team that owns the permission.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user that owns the permission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
