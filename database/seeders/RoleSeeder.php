<?php

namespace Database\Seeders;

use App\Models\Crudables\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    protected $roles = [
        ['name'=>'Admin', 'desc'=>'Usuario Administrador del Sistema', 'id_status' => 1],
        ['name'=>'User', 'desc'=> 'Usuario General del Sistema', 'id_status' => 1]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $key => $value) {
            Role::create($value);
        }
    }
}
