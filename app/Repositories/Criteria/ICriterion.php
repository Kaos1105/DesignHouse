<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

interface ICriterion
{
    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply($model);
}