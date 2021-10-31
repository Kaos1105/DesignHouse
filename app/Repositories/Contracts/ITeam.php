<?php

namespace App\Repositories\Contracts;

use App\Models\Design;

interface ITeam extends IBase
{
    public function fetchUserTeams();
}
