<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ModelNotDefined;
use App\Repositories\Contracts\IBase;
use App\Repositories\Criteria\ICriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class BaseRepository implements IBase, ICriteria
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function find(string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findWhere($column, $value)
    {
        return $this->model->where($column, $value);
    }

    public function findWhereFirst($column, $value)
    {
        return $this->model->where($column, $value)->fisrtOrFail();
    }

    public function paginate($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);
        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }
        return $this;
    }
}