<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;


interface IUser extends IBase
{
    public function updateUser(User $model, array $data, Point $location);
}