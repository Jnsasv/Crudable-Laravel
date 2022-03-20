<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model2 extends Model
{
    public $model_name ='';

    public $actions =[];

    public $display_names = [];

    public $editable_fields = [];

    public $creatable_fields =[];

    public $input_types = [];

    public $withs =[];

    public $viewBag =[];

    public $create_mode = false;
}
