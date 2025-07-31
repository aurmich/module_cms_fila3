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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereUserId($value)
 * @mixin \Eloquent
 */
class DoctorTeam extends TeamUser
{
    use HasParent;
    
    //protected $connection = 'salute_ora'; //in teamuser è già impostato
}
