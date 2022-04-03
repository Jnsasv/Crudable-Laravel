<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\AdminUser;
use App\Models\AppUser;
use App\Models\Status;
use Illuminate\Http\Request;

class CrudController extends Controller
{

    protected $model_name;
    protected $instance;

    public function __construct(Request $request){
        $model = $request->route('model');

        $this->model_name = self::$available_models[$model];

        $this->instance = new $this->model_name();

    }

    public static $available_models = [
        'role'=> Role::class,
        'status'=> Status::class,
        'adminuser'=> AdminUser::class,
        'appuser' =>AppUser::class

    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crud.index',['data' =>$this->model_name::withTrashed()->with($this->instance->withs)->paginate(10), 'model' =>$this->instance ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->instance->create_mode = true;
        return  view('crud.form',['model'=> $this->instance, 'viewBag'=>$this->getViewbag()]);
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
        $model= $model->fill($data);
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
    public function edit(string $model,int $id)
    {
        $model =  $this->model_name::findOrFail($id);

        return view('crud.form',['model'=> $model , 'viewBag' => $this->getViewbag()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Crudable  $model
     * @return \Illuminate\Http\Response
     */
    public function update(string $model,UpdateRequest $request)
    {
        $data = $this->instance->renameRequestParams($request->all());
        $model =  $this->model_name::findOrFail($request->id);
        $model->beforeUpdate();
        $model->update($data);
        $model->afterUpdate();
        return $model;
    }

    public function delete(string $model,int $id){
        $model =  $this->model_name::findOrFail($id);
        return view('crud.confirm',['model'=> $model]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crudable  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $model ,Request $request)
    {
        $model =  $this->model_name::findOrFail($request->id);
        $model->beforeDestroy();
        $model->delete();
        $model->afterDestroy();
        return $model;
    }

    public function reactivate(string $model,int $id){
        $model =  $this->model_name::withTrashed()->find($id);
        return view('crud.confirm',['model'=> $model,'reactivate'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crudable  $role
     * @return \Illuminate\Http\Response
     */
    public function activate(string $model ,Request $request)
    {
        $model =  $this->model_name::withTrashed()->find($request->id);
        $model->deleted_at = null;
        $model->id_status = 1;
        $model->save();
        return $model;
    }

    protected function getViewbag(){
        $viewBag = [];
        foreach ($this->instance->viewBag as  $toLoad) {
            $viewBag[$toLoad] =  self::$available_models[$toLoad]::get();
        }
        return $viewBag;
    }
}
