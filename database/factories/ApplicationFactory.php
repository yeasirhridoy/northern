<?php

namespace Database\Factories;

use App\Models\AdmissionSession;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'admission_session_id' => AdmissionSession::factory(),
            'status' => $this->faker->randomElement(['submitted', 'under_review', 'waitlisted', 'offered', 'rejected', 'admitted']),
            'merit_score' => $this->faker->optional()->randomFloat(2, 60, 100),
            'assigned_subject_id' => null,
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'dob' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'ssc_board' => 'Dhaka',
            'ssc_roll' => $this->faker->numerify('######'),
            'ssc_reg' => $this->faker->numerify('##########'),
            'ssc_year' => $this->faker->year(),
            'ssc_gpa' => $this->faker->randomFloat(2, 3, 5),
            'hsc_board' => 'Dhaka',
            'hsc_roll' => $this->faker->numerify('######'),
            'hsc_reg' => $this->faker->numerify('##########'),
            'hsc_year' => $this->faker->year(),
            'hsc_gpa' => $this->faker->randomFloat(2, 3, 5),
            'hsc_group' => 'Science',
        ];
    }
}
