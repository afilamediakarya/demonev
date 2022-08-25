<?php


namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

abstract class BaseServices
{
    protected $model;
    protected $ruleMessages = [];
    protected $allowSearch = [];
    protected $relation = [];
    protected $isMasterTable = true;
    protected $hasPassword = false;
    protected $hasUuid = true;
    protected $uploadPath = '';
    protected $protectedField = [];
    protected $selectField = ['*'];
    protected $hasTimestamp = true;

    protected $orderBy = 'created_at';
    protected $order = 'desc';

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if (request()->has('search')) {
            $search = request('search');
            $this->model = $this->model->where(function ($q) use ($search) {
                foreach ($this->allowSearch as $key => $data) {
                    if ($key == 0) {
                        $q->where($data, 'like', '%' . $search . '%');
                    } else {
                        $q->orWhere($data, 'like', '%' . $search . '%');
                    }
                }
            });
        }
        if ($this->hasTimestamp) {
            $this->model = $this->model->orderBy(request('order_by', $this->orderBy), request('order', $this->order));
        }
        $this->model = $this->model->with($this->relation);
        if (request()->has('page')) {
            return $this->model->paginate(request('per_page', 10), $this->selectField);
        }
        if (request()->has('limit')) {
            $this->model = $this->model->take(request('limit', 10));
        }
        return $this->model->get($this->selectField);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        if (isset($attributes['uuid'])) {
            return $this->updateByUuid($attributes['uuid'], $attributes);
        }
        $this->removeProtectedField($attributes);
        if ($this->hasUuid) {
            $attributes['uuid'] = Str::uuid()->toString();
        }
        if ($this->isMasterTable && auth()->check()) {
            $attributes['user_insert'] = auth()->user()->id;
        }
        if ($this->hasPassword) {
            if (isset($attributes['password'])) {
                $attributes['password'] = Hash::make($attributes['password']);
            }
            unset($attributes['password_confirmation']);
        }
        foreach ($attributes as $key => $value) {
            if (method_exists($value, 'store')) {
                try {
                    $table = $this->model->getTable();
                } catch (\Exception $exception) {
                    $table = 'manre';
                }
                $file_name = strtotime(date('Y-m-d H:i:s')) . '-' . $key . '-' . $table . '.' . $value->getClientOriginalExtension();
                if (file_exists(storage_path('app/public/' . ($this->uploadPath != '' ? $this->uploadPath . '/' : '') . $file_name))) {
                    $file_name = Str::random(5) . $file_name;
                }
                $attributes[$key] = $value->storeAs($this->uploadPath, $file_name, 'public');
            }
        }
        return $this->model->create($attributes);
    }

    public function updateByUuid($uuid, array $attributes)
    {
        $this->removeProtectedField($attributes);
        if ($this->isMasterTable && auth()->check()) {
            $attributes['user_update'] = auth()->user()->id;
        }
        if ($this->hasPassword) {
            if (isset($attributes['password']) && $attributes['password'] != '') {
                $attributes['password'] = Hash::make($attributes['password']);
            } else {
                unset($attributes['password']);
            }
            unset($attributes['password_confirmation']);
        }
        if ($model = $this->findByUuid($uuid)) {
            foreach ($attributes as $key => $value) {
                if (method_exists($value, 'store')) {
                    $old_path = storage_path('app/public/' . $model->$key);
                    if ($model->$key && file_exists($old_path)) {
                        @unlink($old_path);
                    }
                    try {
                        $table = $this->model->getTable();
                    } catch (\Exception $exception) {
                        $table = $model->getTable();
                    }
                    $file_name = strtotime(date('Y-m-d H:i:s')) . '-' . $key . '-' . $table . '.' . $value->getClientOriginalExtension();
                    if (file_exists(storage_path('app/public/' . ($this->uploadPath != '' ? $this->uploadPath . '/' : '') . $file_name))) {
                        $file_name = Str::random(5) . $file_name;
                    }
                    $attributes[$key] = $value->storeAs($this->uploadPath, $file_name, 'public');
                }
            }
            if ($model->update($attributes)) {
                return $model;
            }
        }
        return false;
    }

    /**
     * @param array $attributes
     */
    protected function removeProtectedField(array &$attributes)
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->protectedField)) {
                unset($attributes[$key]);
            }
        }
    }

    public function findByUuid($uuid)
    {
        return $this->model->with($this->relation)->select($this->selectField)->whereUuid($uuid)->first();
    }

    /**
     * @param integer $id
     * @param array $attributes
     * @return bool
     */
    public function update($id, array $attributes)
    {
        $this->removeProtectedField($attributes);
        if ($this->isMasterTable && auth()->check()) {
            $attributes['user_update'] = auth()->user()->id;
        }
        if ($this->hasPassword) {
            if (isset($attributes['password'])) {
                $attributes['password'] = Hash::make($attributes['password']);
            } else {
                unset($attributes['password']);
            }
            unset($attributes['password_confirmation']);
        }
        if ($model = $this->find($id)) {
            foreach ($attributes as $key => $value) {
                if (method_exists($value, 'store')) {
                    $old_path = storage_path('app/public/' . $model->$key);
                    if ($model->$key && file_exists($old_path)) {
                        @unlink($old_path);
                    }
                    try {
                        $table = $this->model->getTable();
                    } catch (\Exception $exception) {
                        $table = $model->getTable();
                    }
                    $file_name = strtotime(date('Y-m-d H:i:s')) . '-' . $key . '-' . $table . '.' . $value->getClientOriginalExtension();
                    if (file_exists(storage_path('app/public/' . ($this->uploadPath != '' ? $this->uploadPath . '/' : '') . $file_name))) {
                        $file_name = Str::random(5) . $file_name;
                    }
                    $attributes[$key] = $value->storeAs($this->uploadPath, $file_name, 'public');
                }
            }
            if ($model->update($attributes)) {
                return $model;
            }
        }
        return false;
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->with($this->relation)->select($this->selectField)->find($id);
    }

    /**
     * @param integer $id
     * @param bool $force
     * @return bool
     */
    public function delete($id, $force = false)
    {
        if ($model = $this->find($id)) {
            if ($force) {
                return $model->forceDelete();
            }
            return $model->delete();
        } else {
            return false;
        }
    }

    public function deleteByUuid($uuid, $force = false)
    {
        if ($model = $this->findByUuid($uuid)) {
            if ($force) {
                return $model->forceDelete();
            }
            return $model->delete();
        } else {
            return false;
        }
    }

    /**
     * @param array $relation
     * @param bool $merge
     */
    public function setCustomRelation(array $relation, bool $merge = false)
    {
        $this->relation = $merge ? array_merge($relation, $this->relation) : $relation;
    }

    /**
     * @param array $attribute
     * @param null $id
     * @throws ValidationException
     */
    public function validate(array $attribute, $id = null)
    {
        return Validator::make($attribute, $this->rules($id), $this->ruleMessages);
    }

    /**
     * @param null $id
     * @return array
     */
    abstract public function rules($id = null): array;

    public function validateWithUuid(array $attribute, $uuid = null)
    {
        return Validator::make($attribute, $this->rulesWithUuid($uuid), $this->ruleMessages);
    }

}
