<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test Applicant',
            'email' => 'applicant@example.com',
            'password' => bcrypt('password'),
        ]);

        $session = \App\Models\AdmissionSession::create([
            'name' => 'Fall 2025',
            'is_active' => true,
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(30),
        ]);

        $cse = \App\Models\Department::create(['name' => 'Computer Science', 'code' => 'CSE']);
        $eee = \App\Models\Department::create(['name' => 'Electrical Engineering', 'code' => 'EEE']);

        \App\Models\Subject::create(['department_id' => $cse->id, 'name' => 'Software Engineering', 'capacity' => 50]);
        \App\Models\Subject::create(['department_id' => $cse->id, 'name' => 'Data Science', 'capacity' => 40]);
        \App\Models\Subject::create(['department_id' => $eee->id, 'name' => 'Power Systems', 'capacity' => 60]);
    }
}
