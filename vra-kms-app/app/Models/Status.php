<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model2
{
    use HasFactory,SoftDeletes;
    protected $table='status';
}
