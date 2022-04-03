<?php

namespace App\Models;

use App\Scopes\AppUserScope;

class AppUser extends User{

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new AppUserScope);
    }

    protected $table = 'users';
    public $model_name ='appuser';
    public $model_display_name ='Usuarios de App';


    public function afterStore()
    {
        $role = Role::find(2);
        $this->role()->attach($role);
    }


}
