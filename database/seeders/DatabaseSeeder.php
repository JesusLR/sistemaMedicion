<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ExerciseSeeder::class,
        ]);

        // Crear Administrador
        User::factory()->create([
            'name' => 'Admin de Pruebas',
            'email' => 'admin@example.com',
            'role_id' => 1, // Admin
        ]);

        // Crear Entrenador
        $trainer = User::factory()->create([
            'name' => 'Entrenador Juan',
            'email' => 'trainer@example.com',
            'role_id' => 2, // Trainer
        ]);

        // Crear Atleta
        $athlete = User::factory()->create([
            'name' => 'Atleta Carlos',
            'email' => 'athlete@example.com',
            'role_id' => 3, // Athlete
        ]);

        // Asignar Atleta al Entrenador
        \Illuminate\Support\Facades\DB::table('trainer_athletes')->insert([
            'trainer_id' => $trainer->id,
            'athlete_id' => $athlete->id,
            'assigned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
