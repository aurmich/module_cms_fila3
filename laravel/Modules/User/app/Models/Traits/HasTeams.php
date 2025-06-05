<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Membership;
use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;
use Illuminate\Support\Facades\Schema;

/**
 * Trait HasTeams.
 *
 * @property TeamContract $currentTeam
 * @property int|null $current_team_id
 * @property Collection $teams
 * @property Collection $ownedTeams
 */
trait HasTeams
{
    /**
     * Add a user to the team.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $user
     * @param  \Illuminate\Database\Eloquent\Model|null  $role
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addTeamMember($user, $role = null)
    {
        $teamUser = $this->teamUsers()->create([
            'user_id' => $user->getKey(),
            'role_id' => $role ? $role->getKey() : null,
        ]);

        $this->increment('total_members');

        return $teamUser;
    }

    /**
     * Get all teams the user belongs to.
     *
     * @return \Illuminate\Support\Collection<TeamContract>
     */
    public function allTeams(): Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    /**
     * Check if the user belongs to any teams.
     */
    public function belongsToTeams(): bool
    {
        return true;
    }

    /**
     * Check if the user belongs to a specific team.
     */
    public function belongsToTeam(\Modules\User\Contracts\TeamContract $team): bool
    {
        $found = $this->teams()->where('teams.id', $team->id)->first();
        if ($found === null) {
            return false;
        }
        \Webmozart\Assert\Assert::isInstanceOf($found, \Modules\User\Contracts\TeamContract::class, 'Team must implement TeamContract.');
        return true;
    }

    /**
     * Boot the HasTeams trait.
     *
     * @return void
     */
    protected static function bootHasTeams()
    {
        static::deleting(function ($team) {
            $team->teamUsers()->delete();
            $team->teamInvitations()->delete();
        });
    }

    /**
     * Check if the user can add a member to a team.
     */
    public function canAddTeamMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'add team member');
    }

    /**
     * Check if the user can create a team.
     */
    public function canCreateTeam(): bool
    {
        return $this->hasPermissionTo('create team');
    }

    /**
     * Check if the user can delete a team.
     */
    public function canDeleteTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can leave a team.
     */
    public function canLeaveTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team) && ! $this->ownsTeam($team);
    }

    /**
     * Check if the user can manage a team.
     */
    public function canManageTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }

    /**
     * Check if the user can remove a member from a team.
     */
    public function canRemoveTeamMember(TeamContract $team, UserContract $user): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'remove team member');
    }

    /**
     * Check if the user can update a team.
     */
    public function canUpdateTeam(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'update team');
    }

    /**
     * Check if the user can update a team member.
     */
    public function canUpdateTeamMember(TeamContract $team, UserContract $user): bool
    {
        return $this->ownsTeam($team) || $this->hasTeamPermission($team, 'update team member');
    }

    /**
     * Check if the user can view a team.
     */
    public function canViewTeam(TeamContract $team): bool
    {
        return $this->belongsToTeam($team) || $this->hasTeamPermission($team, 'view team');
    }

    /**
     * Get all of the team's users including its owner.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllTeamUsersAttribute()
    {
        return $this->teamUsers->merge([$this->owner]);
    }

    /**
     * Determine if the given user is on the team.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $user
     * @return bool
     */
    public function hasTeamMember($user)
    {
        return $this->teamUsers->contains($user) || $user->ownsTeam($this);
    }

    /**
     * Check if the user has teams.
     */
    public function hasTeams(): bool
    {
        return true;
    }

    /**
     * Check if the user has a specific permission in a team.
     */
    public function hasTeamPermission(\Modules\User\Contracts\TeamContract $team, string $permission): bool
    {
        return $this->ownsTeam($team) || in_array($permission, $this->teamPermissions($team));
    }

    /**
     * Check if the user has a specific role in a team.
     */
    public function hasTeamRole(\Modules\User\Contracts\TeamContract $team, string $role): bool
    {
        if ($this->ownsTeam($team)) {
            return true;
        }

        $teamRole = $this->teamRole($team);
        return $teamRole !== null && isset($teamRole->name) && $teamRole->name === $role;
    }

    /**
     * Get the current team of the user's context.
     * Commented out as it is less comprehensive and does not use TeamContract.
     * The preferred method (below) includes logic for default team switching and uses TeamContract for better abstraction.
     */
    /*
    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }
    */

    /**
     * Get the current team of the user's context.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\User\Contracts\TeamContract, static>
     */
    public function currentTeam(): BelongsTo
    {
        $xot = XotData::make();
        if ($this->current_team_id === null && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        if ($this->allTeams()->isEmpty() && $this->getKey() !== null) {
            $this->current_team_id = null;
            $this->save();
        }

        $teamClass = $xot->getTeamClass();

        return $this->belongsTo($teamClass, 'current_team_id');
    }

    /**
     * Get the teams owned by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownedTeams(): HasMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();
        return $this->hasMany($teamClass, 'user_id');
    }

    /**
     * Get all of the pending invitations for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamInvitations()
    {
        return $this->hasMany(app('team_invitation_model'), 'team_id');
    }

    /**
     * Get the relationship name of the primary team user.
     *
     * @return string
     */
    public function teamRelation()
    {
        return config('teams.relationship_name', 'teamUsers');
    }

    /**
     * Get all of the team's users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamUsers()
    {
        return $this->hasMany(app('team_user_model'), 'team_id');
    }

    /**
     * Get the role for a specific team.
     */
    public function teamRole(\Modules\User\Contracts\TeamContract $team): ?Role
    {
        /** @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\Pivot|null $teamUser */
        $teamUser = $this->teamUsers()->where('team_id', $team->id)->first();

        return $teamUser?->role;
    }

    /**
     * Get permissions for a specific team.
     *
     * @param \Modules\User\Contracts\TeamContract $team
     * @return array<int, string>
     */
    public function teamPermissions(TeamContract $team): array
    {
        $role = $this->teamRole($team);

        if ($role === null || !$role->permissions) {
            return [];
        }

        /** @var array<int, string> */
        return $role->permissions->pluck('name')->values()->toArray();
    }

    /**
     * Remove a user from the team.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $user
     * @return void
     */
    public function removeTeamMember($user)
    {
        $this->teamUsers()
            ->where('user_id', $user->getKey())
            ->delete();

        $this->decrement('total_members');
    }

    /**
     * Get the user's personal team.
     *
     * @return \Modules\User\Contracts\TeamContract|null
     */
    public function personalTeam(): ?\Modules\User\Contracts\TeamContract
    {
        /** @var \Modules\User\Contracts\TeamContract|null */
        $personalTeam = $this->ownedTeams->where('personal_team', true)->first();

        return $personalTeam;
    }

    /**
     * Switch the user's context to the given team.
     *
     * @param \Modules\User\Contracts\TeamContract $team
     */
    public function switchTeam(\Modules\User\Contracts\TeamContract $team): bool
    {
        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->current_team_id = (string) $team->id;
        $this->save();

        return true;
    }

    /**
     * Determine if the given team is the current team.
     */
    public function isCurrentTeam(TeamContract $team): bool
    {
        if ($this->currentTeam === null) {
            return false;
        }

        return $team->getKey() == $this->currentTeam->getKey();
    }

    /**
     * Determine if the user owns the given team.
     *
     * @param \Modules\User\Contracts\TeamContract $team
     */
    public function ownsTeam(\Modules\User\Contracts\TeamContract $team): bool
    {
        /** @var ?\Illuminate\Database\Eloquent\Model $found */
        $found = $this->ownedTeams()->where('teams.id', $team->id)->first();

        return $found !== null;
    }

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<\Modules\User\Contracts\TeamContract, static>
     * @phpstan-return BelongsToMany<\Modules\User\Contracts\TeamContract&\Illuminate\Database\Eloquent\Model, static>
     */
    public function teams(): BelongsToMany
    {
        $xot = XotData::make();
        $teamClass = $xot->getTeamClass();

        return $this->belongsToManyX($teamClass, null, null, 'team_id');
        // ->as('membership')
    }

    /**
     * Invite a user to a team.
     */
    public function inviteToTeam(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->attach($user->id, ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Remove a user from the team.
     */
    public function removeFromTeam(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->detach($user->id);

            return true;
        }

        return false;
    }

    /**
     * Check if the user is an owner or a member.
     */
    public function isOwnerOrMember(TeamContract $team): bool
    {
        return $this->ownsTeam($team) || $this->belongsToTeam($team);
    }

    /**
     * Promote a member to team admin.
     */
    public function promoteToAdmin(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->id, ['role' => 'admin']);

            return true;
        }

        return false;
    }

    /**
     * Demote a member from team admin.
     */
    public function demoteFromAdmin(UserContract $user, TeamContract $team): bool
    {
        if ($this->ownsTeam($team)) {
            $team->members()->updateExistingPivot($user->id, ['role' => 'member']);

            return true;
        }

        return false;
    }

    /**
     * Get all admins of the team.
     */
    public function getTeamAdmins(TeamContract $team): Collection
    {
        return $team->members()->wherePivot('role', 'admin')->get();
    }

    /**
     * Get all members of the team.
     */
    public function getTeamMembers(TeamContract $team): Collection
    {
        return $team->members()->wherePivot('role', 'member')->get();
    }

    /**
     * Determine if the user owns the given team.
     *
     * @param \Modules\User\Contracts\TeamContract $team
     */
    public function checkTeamOwnership(\Modules\User\Contracts\TeamContract $team): bool
    {
        return $this->ownsTeam($team);
    }
}
