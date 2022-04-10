<?php

namespace App\Models;

use App\Scopes\AdminUserScope;

class AdminUser extends User{

    protected $table = 'users';
    public $model_name ='adminuser';
    public $model_display_name ='Administradores';

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new AdminUserScope);
    }


    public function afterStore()
    {
        $role = Role::find(1);
        $this->role()->attach($role);
    }

    public function tableXtraButtons (){
        return view('components.user.table-buttons',['model'=> $this]);
    }

    public $xtraScripts = 'js/user.js';
}
