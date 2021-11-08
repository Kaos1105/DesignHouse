<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;


interface IUser extends IBase
{
    public function updateUser(User $model, array $data, Point $location);

    public function search(Request $request);
}