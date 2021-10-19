<?php

namespace App\Repositories\Eloquent\Criterion;

use App\Repositories\Criteria\ICriterion;
use Illuminate\Database\Query\Builder;

class IsLive implements ICriterion
{

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply($model)
    {
        return $model->where('is_live', true);
    }
}