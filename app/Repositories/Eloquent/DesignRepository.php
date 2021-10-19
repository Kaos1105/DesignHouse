<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\DesignResource;
use App\Models\Design;
use App\Models\User;
use App\Repositories\Contracts\IDesign;
use Illuminate\Database\Eloquent\Model;

class DesignRepository extends BaseRepository implements IDesign
{
    public function __construct(Design $model)
    {
        parent::__construct($model);
    }

    public function applyTags(Design $design, array $data)
    {
        $design->retag($data);
    }

    public function allLive()
    {
        return Design::where('is_live', true)->get();
    }
}