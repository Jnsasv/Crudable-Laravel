<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    protected $status = [
        ['name'=>'Activo'],
        ['name'=>'Inactivo'],
        ['name'=>'Eliminado'],
        ['name'=>'Aceptado'],
        ['name'=>'En Revisión'],
        ['name'=>'Rechazado'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach ($this->status as $key => $value) {
          Status::create($value);
      }
    }
}
