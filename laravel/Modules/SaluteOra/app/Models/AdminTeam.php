<?php
declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;

/**
 * @property string $id
 * @property int $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereUserId($value)
 * @mixin IdeHelperAdminTeam
 * @mixin \Eloquent
 */
class AdminTeam extends TeamUser
{
    use HasParent;
    //protected $connection = 'salute_ora'; //in teamuser è già impostato
}
