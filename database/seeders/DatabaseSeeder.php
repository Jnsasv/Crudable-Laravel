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


        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            //admin123
            'password' => '$2y$10$PuypVvlSXCbnU9OMJTNyC.V3dLsS2Bta7OqbolEQafb11Yb2NcwiO',
            'id_status' => 1,
            'email_verified_at' => now()
        ]);

        DB::table('users_roles')->insert(
        [
            'id_user'=>1,
            'id_role'=>1
        ]);
    }
}
