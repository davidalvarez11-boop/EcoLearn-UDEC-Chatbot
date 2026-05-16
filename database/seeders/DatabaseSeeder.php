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
        User::firstOrCreate(['email' => 'student@ecolearn.cl'], [
            'name'     => 'Estudiante Demo',
            'password' => bcrypt('password'),
            'role'     => 'student',
        ]);

        User::firstOrCreate(['email' => 'admin@ecolearn.cl'], [
            'name'     => 'Administrador',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        $this->call(CourseSeeder::class);
        $this->call(ChatbotResponseSeeder::class);
    }
}
