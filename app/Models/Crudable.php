<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crudable extends Model
{
    use SoftDeletes;

    /**
     * Model name, nescessary to take it in count for the crudable
     *
     *@var string
    */
    public $model_name ='';

    /**
     *Model display Name, used for display on Table and Edit
     *
     *@var string
    */
    public $model_display_name ='';

    /**
     *available actions for the model, can be: ['create','update','delete']
    *
     *@var array
    */
    public $actions =[];

    /**
     *names to show for model properties on grid
     *use formats:
     *['propery' => 'propertydisplayname' ]
     * RM =relatedmodel
     * ['RMname.RMnameproperty' => 'properydisplayname ]
     *
     *@var array
    */
    public $display_names = [];

    /**
     *properties that can used on edit and it's displaynames
     *use formats:
     *['propery' => 'propertydisplayname' ]
     * RM =relatedmodel
     * ['RMname.RMnameproperty' => 'properydisplayname ]
     *
     *@var array
    */
    public $editable_fields = [];

    /**
     *properties that can be used on create and it's displaynames
     *use formats:
     *['propery' => 'propertydisplayname' ]
     * RM =relatedmodel
     * ['RMname.RMnameproperty' => 'properydisplayname ]
     *
     *@var array
    */
    public $creatable_fields =[];

    /**
     *type of controls must to be used  for edit and create
     *use formats:
     *['propery' => 'type' ]
     * RM =relatedmodel
     * ['RMname.RMnameproperty' => 'type ]
     *
     *  available types: 'text','number','boolean','textarea','select'
     *
     *for select type is necessary to add the RM to $withs and $view_bag arrays
     *@var array
    */
    public $field_types = [];

    /**
     *models to be leftjoined when it's getting data
     *must be called by $model_name
     *example ['status','role']
     *
     *@var array
    */
    public $withs =[];

    /**
     *models to be retrieving for select fields on edit or create action
     *must be called by $model_name
     *example ['status','role']
     *
     *@var array
    */
    public $view_bag =[];

    /**
     *if is creating or editing
     *@var bool
    */
    public $create_mode = false;

    /**
     *Rules to be used when the record is being created
     *the array follows the laravel guidelines
     *for selectable fields use Related Model Name
     *  Example: for id_status use ['status' =>required]
     *@var array
    */
    public $update_rules =[];

    /**
     *Rules to be used when the record is being created
     *the array follows the laravel guidelines
     *for selectable fields use Related Model Name
     *  Example: for id_status use ['status' =>required]
     *@var array
    */
    public $store_rules =[];

    /**
     * scripts to be added when creating or editing
     * example: 'js/user.js'
     *default: false
     *@var mixed
    */
    public $xtraScripts = false;


    /**
     * rename the request paramas whoses are Related Model with the id prefix
     * @param array params request params without id prefix
     * @return array
    */
    public function renameRequestParams (array $params){
        foreach ($params as $key => $param) {
            if(!in_array($key,$this->fillable) && in_array('id_'.$key,$this->fillable)){
                $params['id_'.$key] = $param;
                unset($params[$key]);
            }
        }
        return $params;
    }

    /**
     * override the delete method of model to add deleted status
     *
    */
    public function delete()
    {
        $this->id_status =3;
        $this->save();
        parent::delete();
    }

    /**
     * function to be executed before create record on db
     * it has the intention to modify the record
    */
    public function beforeStore(){

    }

    /**
     * function to be executed after create record on db
     * it has the intention to modify the record or append relations
    */
    public function afterStore(){

    }


    /**
     * function to be executed before update record on db
     * it has the intention to modify the record
    */
    public function beforeUpdate(){

    }


    /**
     * function to be executed before update record on db
     * it has the intention to modify the record
    */
    public function afterUpdate(){

    }


    /**
     * function to be executed before delete record on db
     * it has the intention to modify the record
    */
    public function beforeDestroy(){

    }

    /**
     * function to be executed after create delete on db
     * it has the intention to modify the record or append relations
    */
    public function afterDestroy()
    {

    }

    /**
     * function to add buttons to the header of the crud
     *  return echo, blade component, view
    */
    public function headerXtraButtons(){

    }

    /**
     * function to add buttons to the table of the crud
     *  return echo, blade component, view
    */
    public function tableXtraButtons(){
    }

    /**
     * Get the status that owns the Crudable
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'id_status', 'id');
    }

}
