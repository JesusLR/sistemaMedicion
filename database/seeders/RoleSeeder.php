<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'display_name' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'trainer', 'display_name' => 'Entrenador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'athlete', 'display_name' => 'Atleta', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
