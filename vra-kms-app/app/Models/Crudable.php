<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crudable extends Model
{
    use SoftDeletes;

    public $model_name ='';

    public $model_display_name ='';

    public $actions =[];

    public $display_names = [];

    public $editable_fields = [];

    public $creatable_fields =[];

    public $input_types = [];

    public $withs =[];

    public $viewBag =[];

    public $create_mode = false;

    public $update_rules =[];

    public $store_rules =[];

    public function renameRequestParams (array $params){
        foreach ($params as $key => $param) {
            if(!in_array($key,$this->fillable) && in_array('id_'.$key,$this->fillable)){
                $params['id_'.$key] = $param;
                unset($params[$key]);
            }
        }
        return $params;
    }

    public function delete()
    {
        $this->id_status =3;
        $this->save();
        parent::delete();
    }
}
