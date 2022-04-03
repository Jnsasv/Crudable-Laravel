<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Crudable
{
    use HasFactory;

    public $model_name ='role';

    public $model_display_name ='Roles';

    public $actions = [
        'create' =>true,
        'update' =>true,
        'delete' =>true,
    ];

    protected $fillable =  [
        'name',
        'desc',
        'id_status'
    ];

    public $display_names = [
        'name'=>'Nombre',
        'desc'=>'Descripción',
        'status.name' =>'Estátus'
    ];

    public $editable_fields = [
        'name'=>'Nombre',
        'desc'=>'Descripción',
        'status.name' =>'Estátus'
    ];

    public $creatable_fields =[
        'name'=>'Nombre',
        'desc'=>'Descripción',
        'status.name' =>'Estátus'
    ];

    public $withs = ['status'];

    public $viewBag = ['status'];

    public $field_types = [
        'name'=>'text',
        'desc'=>'textarea',
        'status.name'=> 'select'
    ];

    public $update_rules =[
        'name' => 'required|min:3|max:50',
        'desc'  => 'required|min:3|max:50',
        'status'  => 'required'
    ];

    public $store_rules =[
        'name' => 'required|min:3|max:50',
        'desc'  => 'required|min:3|max:50',
        'status'  => 'required'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
