<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Providers\ModelsProvider;
use Illuminate\Http\Request;


class CrudController extends Controller
{

    /**
     * Name of the model current used
     *
     * @var string
    */
    protected $model_name;

    /**
     * instance of the model current used
     *
     * @var \App\Models\Crudable
    */
    protected $instance;

    /**
     * if the response to be returned is a json or a view
     *
     * @var bool
    */
    protected $returnJson;

    /**
     * Controller Constructor
     *
     * @param Request $request
    */
    public function __construct(Request $request)
    {
        if(count(ModelsProvider::$available_models )== 0){
            ModelsProvider::getInstance();
        }
        $model = $request->route('model');

        $this->model_name = ModelsProvider::$available_models[$model];

        $this->instance = new $this->model_name();

        $this->returnJson = $request->is('api/*');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return !$this->returnJson ? view('crud.form', ['model' => $this->instance, 'view_bag' => $this->getViewbag()]) : ['model' => $this->instance, 'view_bag' => $this->getViewbag()];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $model  model name
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
     * @param  string $model  model name
     * @param  int $id  id to edit
     * @return \Illuminate\Http\Response
     */
    public function edit(string $model, int $id)
    {
        $model =  $this->model_name::findOrFail($id);

        return !$this->returnJson ? view('crud.form', ['model' => $model, 'view_bag' => $this->getViewbag()]) : ['model' => $model, 'view_bag' => $this->getViewbag()];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $model model name
     * @param  \App\Http\Requests\UpdateRequest  $request
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

    /**
     * Show the form for cofirm the deleting the specified resource.
     *
     * @param  string $model  model name
     * @param  int $id  id to delete
     * @return \Illuminate\Http\Response
     */
    public function delete(string $model, int $id)
    {
        $model =  $this->model_name::findOrFail($id);
        return !$this->returnJson ? view('crud.confirm', ['model' => $model]) : ['model' => $model];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $model  model name
     * @param   Request  $request
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

    /**
     * reactivate the specified resource.
     *
     * @param  string $model  model name
     * @param  int $id  id to create
     * @return \Illuminate\Http\Response
     */
    public function reactivate(string $model, int $id)
    {
        $model =  $this->model_name::withTrashed()->find($id);
        return !$this->returnJson ? view('crud.confirm', ['model' => $model, 'reactivate' => true]) : ['model' => $model, 'reactivate' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $model  model name
     * @param   Request  $request
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

    /**
     * get the viewbagfor selects according to the current model.
     *
     * @return array
     */
    protected function getViewbag()
    {
        foreach ($this->instance->view_bag as  $toLoad) {
            $keys = explode('|', $toLoad);
            $view_bag[$keys[0]] = count($keys) > 1 ? ModelsProvider::$available_models[$keys[1]]::get() :  ModelsProvider::$available_models[$toLoad]::get();
        }
        return $view_bag;
    }
}
