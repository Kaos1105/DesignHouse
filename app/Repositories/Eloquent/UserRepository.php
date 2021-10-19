<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUser;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class UserRepository extends BaseRepository implements IUser
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function updateUser(User $model, array $data, Point $location)
    {
        $model->tagline = $data['tagline'];
        $model->name = $data['name'];
        $model->about = $data['about'];
        $model->formatted_address = $data['formatted_address'];
        $model->available_to_hire = $data['available_to_hire'];
        $model->location = $location;
        $model->save();
    }
}