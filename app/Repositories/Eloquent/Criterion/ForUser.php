<?php

namespace App\Repositories\Eloquent\Criterion;

use App\Repositories\Criteria\ICriterion;
use Illuminate\Database\Query\Builder;

class ForUser implements ICriterion
{
    protected string $user_id;

    public function __construct(string $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply($model)
    {
        return $model->where('user_id', $this->user_id);
    }
}