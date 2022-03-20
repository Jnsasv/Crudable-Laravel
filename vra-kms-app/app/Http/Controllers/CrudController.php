<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Model2;
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
        'status'=> Status::class

    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crud.index',['data' =>$this->model_name::with($this->instance->withs)->paginate(10), 'model' =>$this->instance ]);
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
    public function store(StoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Model2  $model
     * @return \Illuminate\Http\Response
     */
    public function show(Model2 $model)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Model2  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(string $model,int $id)
    {
        $model =  $this->model_name::find($id);

        return view('crud.form',['model'=> $model , 'viewBag' => $this->getViewbag()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Model2  $model
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Model2 $model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Model2  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model2 $role)
    {
        //
    }

    protected function getViewbag(){
        $viewBag = [];
        foreach ($this->instance->viewBag as  $toLoad) {
            $viewBag[$toLoad] =  self::$available_models[$toLoad]::get();
        }
        return $viewBag;
    }
}
