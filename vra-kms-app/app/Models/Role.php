<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'name',
        'desc',
        'status.name'
    ];

    public $creatable_fields =[
        'name',
        'desc',
        'status.name'
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

    /**
     * Get the status that owns the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'id_status', 'id');
    }

}
