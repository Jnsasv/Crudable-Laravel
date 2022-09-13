<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Crudable
{
    use HasFactory;
    protected $table='status';
    public  $model_name ='status';
}
