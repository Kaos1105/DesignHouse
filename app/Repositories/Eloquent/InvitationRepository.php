<?php

namespace App\Repositories\Eloquent;

use App\Models\Invitation;
use App\Models\Team;
use App\Repositories\Contracts\IInvitation;

class InvitationRepository extends BaseRepository implements IInvitation
{
    public function __construct(Invitation $model)
    {
        parent::__construct($model);
    }

    public function addUserToTeam(Team $team, string $user_id)
    {
        $team->members()->attach($user_id);
    }

    public function removeUserFromTeam(Team $team, string $user_id)
    {
        $team->members()->detach($user_id);
    }
}