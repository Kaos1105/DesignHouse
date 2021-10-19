<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface IBase
{
    public function all();

    public function find(string $id);

    public function findWhere($column, $value);

    public function findWhereFirst($column, $value);

    public function paginate($perPage = 10);

    public function create(array $data);

    public function update(Model $model, array $data);

    public function delete(Model $model);
}