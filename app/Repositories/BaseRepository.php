<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Role;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var array $select
     */
    protected $select = [];
    /**
     * Current Object instance
     *
     * @var object
     */
    protected $instance;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        //other -> new Model
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Find records by a specific field.
     *
     * @param string $field The field to filter by.
     * @param mixed $value The value to search for.
     * @param array $relations Optional related models to load.
     * @return Model|null Returns a collection of found records.
     */
    public function findByField(string $field, $value, array $relations = []): ?Model
    {
        return $this->model->where($field, $value)->with($relations)->first();
    }



    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {

        return $this->model->get();
    }

    public function getOrderBy($orderBy, $orderDirection = 'asc')
    {
        return $this->model->orderBy($orderBy, $orderDirection)->get();
    }

    /**
     * Find a single record
     *
     * @param int $id
     * @param array $relations
     * @return mixed
     * @throws Exception
     */
    public function findOrFail($id)
    {
        $this->instance = $this->model->findOrFail($id);
        return $this->instance;
    }

    /**
     * Find a single record
     *
     * @param int $id
     * @param array $relations
     * @return mixed
     * @throws Exception
     */
    public function find($id)
    {
        $this->instance = $this->model->find($id);

        return $this->instance;
    }

    /**
     * Create
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update
     * @param $id
     * @param array $data
     * @return mixed|bool
     */
    public function update($id, array $data)
    {
        $this->find($id);

        if ($this->instance) {
            $this->instance->update($data);
            return $this->instance;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $this->find($id);
        if ($this->instance) {
            $this->instance->delete();

            return true;
        }

        return false;
    }

    public function getBy(array $filter, array $relations = [])
    {

        $this->getByQueryBuilder($filter, $relations);

        return $this->instance->get();
    }

    /**
     * get query
     * @return Builder
     */
    public function getQueryBuilder()
    {
        $this->instance = $this->model->newQuery();
        return $this->instance;
    }

    public function getByQueryBuilder(array $filter, array $relations = [], $sort = ['id', 'desc'])
    {

        $this->getQueryBuilderOrderBy(...$sort);

        $this->applyFilters($filter);

        return $this->instance->with($relations);
    }

    protected function applyFilters(array $filter): void
    {
        foreach ($filter as $field => $value) {
            if (is_array($value)) {
                [$field, $condition, $val] = $value;
                if (strpos($field, '.') !== false) {
                    list($relation, $relatedField) = explode('.', $field, 2);
                    $this->instance = $this->instance->whereHas($relation, function ($query) use ($relatedField, $condition, $val) {
                        $query->where($relatedField, $condition, $val);
                    });
                } else {
                    $this->instance = match (strtoupper($condition)) {
                        'IN' => $this->instance->whereIn($field, $val),
                        'NOT_IN' => $this->instance->whereNotIn($field, $val),
                        default => $this->instance->where($field, $condition, $val)
                    };
                }
            } else {
                $this->instance = $this->instance->where($field, $value);
            }
        }
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {

        $this->getQueryBuilder();

        $this->instance = $this->instance->orderBy($column, $sort);

        return $this->instance;
    }

    public function updateAttribute(mixed $id, string $attribute, mixed $value): void
    {
        $model = $this->find($id);
        $model->$attribute = $value;
        $model->save();
    }

    public function authorize($action = 'view', $guard = 'web')
    {
        if (!$this->instance || auth()->guard($guard)->user()->can($action, $this->instance)) {
            return true;
        }
        if (request()->routeIs('api.*')) {
            throw new HttpResponseException(
                response()->json([
                    'status' => 401,
                    'message' => __('Bạn không có quyền truy cập.')
                ], 401)
            );
        }
        throw new HttpException(401, 'UNAUTHORIZED');
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function updateOrCreate(array $attributes, array $values): mixed
    {
        $model = $this->getModel();
        return $model::updateOrCreate($attributes, $values);
    }


    /**
     * @throws Exception
     */
    public function syncModelRoles($modelId, $roles = []): int
    {
        $model = $this->find($modelId);

        if (!is_array($roles)) {
            $roles = [];
        }

        $model->syncRoles($roles);
        return 1;
    }

    public function assignRoles($model, array $rolesNames): bool
    {
        try {
            $model->roles()->detach();

            foreach ($rolesNames as $roleName) {
                $role = Role::where('name', $roleName)->first();
                if ($role) {
                    $model->roles()->attach($role->id, ['model_type' => get_class($model)]);
                }
            }

            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }


    /**
     * Attach related models to a specified model instance using a relation.
     *
     * @param int $id
     * @param array $ids Array of IDs to attach via the relation.
     * @param string $relation The relationship method name on the model.
     * @throws Exception
     */
    public function attachRelations(int $id, array $ids, string $relation): void
    {
        $model = $this->find($id);

        if (!$model) {
            throw new Exception("Model with ID $id not found.");
        }

        if (!method_exists($model, $relation)) {
            throw new Exception("Relation $relation does not exist on the model.");
        }

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $model->$relation()->attach($id);
            }
        }
    }

    /**
     * Synchronizes the relationship ids for a given model.
     * It compares current relationship ids with new ids, detaches the unwanted ones,
     * and attaches the new ones that are not currently associated.
     *
     * @param Model $model The Eloquent model instance.
     * @param string $relationship The relationship method name on the model.
     * @param array $newIds The array of new ids to be synced with the model's relationship.
     * @param string $idKey The key used to retrieve ids from the relationship.
     */
    public function syncRelationshipIds($model, $relationship, array $newIds, $idKey): void
    {
        $currentIds = $model->$relationship()->pluck($idKey)->toArray();

        $idsToDetach = array_diff($currentIds, $newIds);

        $idsToAttach = array_diff($newIds, $currentIds);

        if (!empty($idsToDetach)) {
            $model->$relationship()->detach($idsToDetach);
        }

        if (!empty($idsToAttach)) {
            foreach ($idsToAttach as $id) {
                $model->$relationship()->attach($id);
            }
        }
    }




}
