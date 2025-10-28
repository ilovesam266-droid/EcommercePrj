<?php

namespace App\Repository\Eloquent;

use App\Repository\Constracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct()
    {
        $this->setModel();
    }
    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function query(array $relations = [], bool $withTrashed = false): Builder
    {
        $query = $this->model->newQuery()->with($relations);

        if ($withTrashed && in_array(SoftDeletes::class, class_uses($this->model))) {
            $query->withTrashed();
        }

        return $query;
    }

    public function all(array|callable $criteria = [], array $sort = [], ?int $perPage = null, array $columns = ['*'], array $relations = [], bool $withTrashed = false)
    {
        $query = $this->query($relations, $withTrashed);
        $this->buildCriteria($query, $criteria);

        $this->applySort($query, $sort);

        return $perPage ? $query->paginate($perPage) : $query->get($columns);
    }

    /**
     * Apply sort for Query Builder.
     *
     * @param Builder $query
     * @param array $sort
     * @return Builder
     */
    protected function applySort(Builder $query, array $sort)
    {
        foreach ($sort as $field => $direction) {
            $query->orderBy($field, strtolower($direction) === 'desc' ? 'desc' : 'asc');
        }
        return $query;
    }

    public function find(int|string|array|callable $criteria, array $relations = [], bool $withTrashed = false)
    {
        $query = $this->query($relations, $withTrashed);
        //if input is id <integer>
        if (is_int($criteria)) {
            return $query->find($criteria);
        }

        if (is_array($criteria) && array_is_list($criteria)) {
            return $query->whereIn('id', $criteria)->get();
        }

        $this->buildCriteria($query, $criteria);

        return $query->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $criteria, array $data)
    {
        $model = $this->find($criteria);

        if (!$model) {
            return null;
        }

        $model->update($data);
        return $model;
    }

    public function delete(int $id, bool $forceDelete = false)
    {
        $model = $this->find($id, [], true);

        if (!$model) {
            return false;
        }

        if ($forceDelete && in_array(SoftDeletes::class, class_uses($this->model))) {
            return $model->forceDelete();
        }

        // If forceDelete is false, or the model doesn't use SoftDeletes, then delete() is the default action.
        return $model->delete();
    }

    public function deleteBulk(array|callable $criteria, bool $forceDelete = false)
    {
        $query = $this->query();

        $this->buildCriteria($query, $criteria);

        if ($forceDelete && in_array(SoftDeletes::class, class_uses($this->model))) {
            return $query->withTrashed()->forceDelete();
        }

        // If forceDelete is false, or the model doesn't use SoftDeletes, then delete() is the default action.
        return $query->delete();
    }

    public function restoreSoft(int|array|callable $criteria)
    {
        $model = $this->find($criteria, [], true);
        if (!$model) {
            return false;
        }
        if (in_array(SoftDeletes::class, class_uses($model)) && $model->trashed()) {
            return $model->restore();
        }
        return false;
    }
    //xử lý filter: buildCriteria để xử lý callback thành query, xử lý handleCriteria là xử lý giá trị truyền vào cho từng object, xử lý exists
    public function buildCriteria(Builder $query, mixed $criteria)
    {
        if (is_callable($criteria)) {
            $criteria($query);
            return $query;
        }
        if (is_array($criteria)) {
            foreach ($criteria as $field => $value) {
                if ($value === '') continue;
                $this->handleCriteria($query, $field, $value);
            }
        }
        return $query;
    }
    public function handleCriteria(Builder $query, $field, $value)
    {
        if (is_callable($value)) {
            $query->where(fn($q) => $value($q));
            return;
        }

        if ($field === 'exists' && is_array($value)) {
            foreach ($value as $relation => $exists) {
                $exists ? $query->whereHas($relation) : $query->whereDoesntHave($relation);
            }
            return;
        }

        if (is_array($value)) {
            $query->whereIn($field, $value);
            return;
        }

        if (is_string($value) && str_contains($value, '%')) {
            $query->where($field, 'like', $value);
            return;
        }

        if ($value === null) {
            $query->whereNull($field);
            return;
        }

        $query->where($field, $value);
    }
    public function exists(array|callable $criteria): bool
    {
        $query = $this->query();
        $this->buildCriteria($query, $criteria);
        return $query->exists();
    }
}
