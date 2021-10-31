<?php

namespace App\Repositories\Contracts;

use App\Models\Design;
use App\Models\Team;

interface IInvitation extends IBase
{
    public function addUserToTeam(Team $team, string $user_id);

    public function removeUserFromTeam(Team $team, string $user_id);
}
