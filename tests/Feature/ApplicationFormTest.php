<?php

use App\Models\AdmissionSession;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Application;
use App\Models\User;
use Livewire\Volt\Volt;
use function Pest\Laravel\actingAs;

it('can submit an application with merged academic steps', function () {
    // Setup
    $user = User::factory()->create();
    $session = AdmissionSession::factory()->create([
        'is_active' => true, 
        'start_date' => now()->subDay(), 
        'end_date' => now()->addDay()
    ]);
    $department = Department::factory()->create();
    $subjects = Subject::factory()->count(3)->create(['department_id' => $department->id]);

    actingAs($user);

    $component = Volt::test('application-form')
        // Step 1: Personal
        ->set('father_name', 'John Doe Sr.')
        ->set('mother_name', 'Jane Doe')
        ->set('dob', '2000-01-01')
        ->set('phone', '1234567890')
        ->set('address', '123 Main St')
        ->call('nextStep')
        ->assertSet('step', 2);

    // Step 2: Academic (Merged SSC & HSC)
    $component
        // Setting SSC Data
        ->set('ssc_board', 'Dhaka')
        ->set('ssc_roll', '1001')
        ->set('ssc_reg', '2001')
        ->set('ssc_year', '2016')
        ->set('ssc_gpa', '5.00')
        // Setting HSC Data
        ->set('hsc_board', 'Dhaka')
        ->set('hsc_roll', '1002')
        ->set('hsc_reg', '2002')
        ->set('hsc_year', '2018')
        ->set('hsc_gpa', '5.00')
        ->set('hsc_group', 'Science')
        ->call('nextStep')
        ->assertSet('step', 3);

    // Step 3: Subjects
    $component
        ->call('addSubject', $subjects[0]->id)
        ->call('nextStep')
        ->assertSet('step', 4);

    // Step 4: Submit
    $component
        ->call('submit')
        ->assertRedirect(route('application.show', Application::first()->id));

    expect(Application::count())->toBe(1);
    expect(Application::first()->status)->toBe('submitted');
});
