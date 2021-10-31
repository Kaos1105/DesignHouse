<?php

namespace App\Repositories\Eloquent\Criterion;

use App\Models\Invitation;
use App\Repositories\Criteria\ICriterion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class WithTrashed implements ICriterion
{

    /**
     * @param Builder|Model $model
     * @return Builder
     */
    public function apply($model)
    {
        return $model->withTrashed();
    }
}