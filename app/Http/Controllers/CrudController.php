<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Crudable;
use App\Models\Crudables\AdminUser;
use App\Models\Crudables\AppUser;
use App\Models\Crudables\Role;
use Illuminate\Http\Request;

class CrudController extends Controller
{

    protected $model_name;
    protected $instance;
    protected $returnJson;

    public function __construct(Request $request)
    {
        $model = $request->route('model');

        $this->model_name = self::$available_models[$model];

        $this->instance = new $this->model_name();

        $this->returnJson = (bool)$request->header("returnJson") ?? false;
    }

    public static $available_models = [
        'role' => Role::class,
        'adminuser' => AdminUser::class,
        'appuser' => AppUser::class
    ];

    public static function get_available_models(): array
    {
        $models   = collect(get_declared_classes())->filter(function ($model) {
            return (substr($model, 0, 21) === 'App\Models\Crudables\\') && is_subclass_of($model, Crudable::class);
        })->mapWithKeys(
            function ($v) {
                return [(new $v())->model_name => $v];
            }
        );
        return $models->toArray();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dump(self::get_available_models());
        return !$this->returnJson ? view('crud.index', ['data' => $this->model_name::withTrashed()->with($this->instance->withs)->paginate(10), 'model' => $this->instance]) : ['data' => $this->model_name::withTrashed()->with($this->instance->withs)->paginate(10), 'model' => $this->instance];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->instance->create_mode = true;
        return !$this->returnJson ? view('crud.form', ['model' => $this->instance, 'viewBag' => $this->getViewbag()]) : ['model' => $this->instance, 'viewBag' => $this->getViewbag()];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $model,  StoreRequest $request)
    {
        $data = $this->instance->renameRequestParams($request->all());
        $model =  new $this->model_name();
        $model = $model->fill($data);
        $model->beforeStore();
        $model->save();
        $model->afterStore();
        return $model;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crudable  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(string $model, int $id)
    {
        $model =  $this->model_name::findOrFail($id);

        return !$this->returnJson ? view('crud.form', ['model' => $model, 'viewBag' => $this->getViewbag()]) : ['model' => $model, 'viewBag' => $this->getViewbag()];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Crudable  $model
     * @return \Illuminate\Http\Response
     */
    public function update(string $model, UpdateRequest $request)
    {
        $data = $this->instance->renameRequestParams($request->all());
        $model =  $this->model_name::findOrFail($request->id);
        $model->beforeUpdate();
        $model->update($data);
        $model->afterUpdate();
        return $model;
    }

    public function delete(string $model, int $id)
    {
        $model =  $this->model_name::findOrFail($id);
        return !$this->returnJson ? view('crud.confirm', ['model' => $model]) : ['model' => $model];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crudable  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $model, Request $request)
    {
        $model =  $this->model_name::findOrFail($request->id);
        $model->beforeDestroy();
        $model->delete();
        $model->afterDestroy();
        return $model;
    }

    public function reactivate(string $model, int $id)
    {
        $model =  $this->model_name::withTrashed()->find($id);
        return !$this->returnJson ? view('crud.confirm', ['model' => $model, 'reactivate' => true]) : ['model' => $model, 'reactivate' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crudable  $role
     * @return \Illuminate\Http\Response
     */
    public function activate(string $model, Request $request)
    {
        $model =  $this->model_name::withTrashed()->find($request->id);
        $model->deleted_at = null;
        $model->id_status = 1;
        $model->save();
        return $model;
    }

    protected function getViewbag()
    {
        foreach ($this->instance->viewBag as  $toLoad) {
            $keys = explode('|', $toLoad);
            $viewBag[$keys[0]] = count($keys) > 1 ? self::$available_models[$keys[1]]::get() :  self::$available_models[$toLoad]::get();
        }
        return $viewBag;
    }
}
