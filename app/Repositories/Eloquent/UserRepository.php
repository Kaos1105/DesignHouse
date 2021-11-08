<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUser;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    public function search(Request $request)
    {
        $query = $this->model->query();

        // only designers who have designs
        if ($request->input('has_designs')) {
            $query->has('designs');
        }

        // check for available to hire
        if ($request->input('available_to_hire')) {
            $query->where('available_to_hire', true);
        }

        // Geographic search
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $dist = $request->input('distance');
        $unit = $request->input('unit');

        if ($lat && $lng) {
            $point = new Point($lat, $lng);
            switch ($unit) {
                case 'km':
                    $dist *= 1000;
                    break;
                case 'mile':
                    $dist *= 1609.34;
                    break;
                case 'm':
                    break;
            }
            $query->distanceSphereExcludingSelf('location', $point, $dist);
        }

        // order the results
        if ($request->input('orderBy') == 'closest') {
            $query->orderByDistanceSphere('location', $point, 'asc');
        } else if ($request->input('orderBy') == 'latest') {
            $query->latest();
        } else {
            $query->oldest();
        }

        return $query->get();
    }
}