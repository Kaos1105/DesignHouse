<?php

namespace App\Repositories\Eloquent;

use App\Models\Team;
use App\Repositories\Contracts\ITeam;
use Illuminate\Support\Facades\Auth;

class TeamRepository extends BaseRepository implements ITeam
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }


    public function fetchUserTeams()
    {
        return Auth::user()->teams;
    }
}