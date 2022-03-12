<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        StatusSeeder::class,
        RoleSeeder::class
        ]);


        $user = User::create([
            'name' => 'Juan Casillas',
            'email' => 'jns_asv@hotmail.com',
            'password' => Hash::make('password'),
            'id_status' => 1
        ]);

        DB::table('users_roles')->insert(
        [
            'id_user'=>1,
            'id_role'=>1
        ]);

        event(new Registered($user));


    }
}
