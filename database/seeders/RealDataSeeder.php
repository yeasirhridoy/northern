<?php

namespace Database\Seeders;

use App\Models\AdmissionSession;
use App\Models\Application;
use App\Models\ApplicationPreference;
use App\Models\Department;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class RealDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Departments & Subjects
        $cse = Department::firstOrCreate(['code' => 'CSE'], ['name' => 'Computer Science & Engineering']);
        $eee = Department::firstOrCreate(['code' => 'EEE'], ['name' => 'Electrical & Electronic Engineering']);
        $bba = Department::firstOrCreate(['code' => 'BBA'], ['name' => 'Business Administration']);
        $eng = Department::firstOrCreate(['code' => 'ENG'], ['name' => 'English']);
        $law = Department::firstOrCreate(['code' => 'LAW'], ['name' => 'Law & Justice']);

        $subjects = collect([
            Subject::firstOrCreate(['name' => 'Software Engineering', 'department_id' => $cse->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Data Science', 'department_id' => $cse->id], ['capacity' => 50]),
            Subject::firstOrCreate(['name' => 'Power Systems', 'department_id' => $eee->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Electronics', 'department_id' => $eee->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Accounting', 'department_id' => $bba->id], ['capacity' => 80]),
            Subject::firstOrCreate(['name' => 'Marketing', 'department_id' => $bba->id], ['capacity' => 80]),
            Subject::firstOrCreate(['name' => 'Literature', 'department_id' => $eng->id], ['capacity' => 50]),
            Subject::firstOrCreate(['name' => 'Criminal Law', 'department_id' => $law->id], ['capacity' => 40]),
        ]);

        // 2. Create Two Sessions
        $spring26 = AdmissionSession::firstOrCreate(
            ['name' => 'Spring 2026'],
            ['start_date' => now()->subDays(30), 'end_date' => now()->addDays(30)]
        );

        $summer26 = AdmissionSession::firstOrCreate(
            ['name' => 'Summer 2026'],
            ['start_date' => now()->addMonths(4), 'end_date' => now()->addMonths(6)]
        );

        $sessions = collect([$spring26, $summer26]);

        // 3. Create Applications
        // We want 100 applications total, distributed across sessions
        
        $statuses = ['submitted', 'under_review', 'waitlisted', 'offered', 'rejected', 'admitted'];
        $boards = ['Dhaka', 'Chittagong', 'Rajshahi', 'Sylhet', 'Comilla'];
        $groups = ['Science', 'Commerce', 'Humanities'];

        for ($i = 0; $i < 100; $i++) {
            $session = $sessions->random();
            $status = $statuses[array_rand($statuses)];
            $assignedSubjectId = null;
            $paymentStatus = 'pending';
            $regId = null;

            // Logic for realistic data consistency
            if (in_array($status, ['offered', 'admitted'])) {
                $assignedSubjectId = $subjects->random()->id;
            }

            if ($status === 'admitted') {
                $paymentStatus = 'approved';
                $regId = 'REG-' . date('Y') . '-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            } elseif ($status === 'offered') {
                 // Some offered students might have paid, some pending
                 $paymentStatus = rand(0, 1) ? 'approved' : 'pending';
                 if ($paymentStatus === 'approved') {
                     $regId = 'REG-' . date('Y') . '-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
                 }
            } elseif ($status === 'rejected') {
                 $paymentStatus = 'rejected';
            }

            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
            ]);

            $application = Application::factory()->create([
                'user_id' => $user->id,
                'admission_session_id' => $session->id,
                'status' => $status,
                'assigned_subject_id' => $assignedSubjectId,
                'payment_status' => $paymentStatus,
                'registration_id' => $regId,
                'payment_amount' => $paymentStatus === 'approved' ? 15000 : null,
                'payment_method' => $paymentStatus === 'approved' ? fake()->randomElement(['bkash', 'nagad', 'bank']) : null,
                'payment_trx_id' => $paymentStatus === 'approved' ? strtoupper(fake()->bothify('??######')) : null,
                
                // Realistic academic scores
                'ssc_gpa' => fake()->randomFloat(2, 4.0, 5.0),
                'hsc_gpa' => fake()->randomFloat(2, 3.5, 5.0),
                'ssc_board' => fake()->randomElement($boards),
                'hsc_board' => fake()->randomElement($boards),
                'hsc_group' => fake()->randomElement($groups),
            ]);

            // Create preferences
            $numPreferences = rand(1, 3);
            $shuffledSubjects = $subjects->shuffle();
            
            for ($j = 0; $j < $numPreferences; $j++) {
                ApplicationPreference::create([
                    'application_id' => $application->id,
                    'subject_id' => $shuffledSubjects[$j]->id,
                    'priority_order' => $j + 1,
                ]);
            }
        }
    }
}
