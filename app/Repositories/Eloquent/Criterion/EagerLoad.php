<?php

namespace App\Repositories\Eloquent\Criterion;

use App\Repositories\Criteria\ICriterion;
use Illuminate\Database\Query\Builder;

class EagerLoad implements ICriterion
{

    protected array $relationships;

    public function __construct(array $relationships)
    {
        $this->relationships = $relationships;
    }

    /**
     * @param Builder $model
     * @return Builder
     */
    public function apply($model)
    {
        return $model->with($this->relationships);
    }
}