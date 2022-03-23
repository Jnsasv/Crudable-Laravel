<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Crudable
{
    use HasFactory,SoftDeletes;
    protected $table='status';
}
