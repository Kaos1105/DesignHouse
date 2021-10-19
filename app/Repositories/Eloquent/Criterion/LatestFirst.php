<?php

namespace App\Repositories\Eloquent\Criterion;

use App\Repositories\Criteria\ICriterion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

class LatestFirst implements ICriterion
{

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply($model)
    {
        return $model->latest();
    }
}