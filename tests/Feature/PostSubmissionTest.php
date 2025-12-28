<?php

use App\Models\AdmissionSession;
use App\Models\Application;
use App\Models\Subject;
use App\Models\User;
use Livewire\Volt\Volt;
use function Pest\Laravel\actingAs;

it('shows waitlist position correctly', function () {
    $session = AdmissionSession::factory()->create();
    
    // Create higher ranking waitlisted applicant
    Application::factory()->create([
        'admission_session_id' => $session->id,
        'status' => 'waitlisted',
        'merit_score' => 90,
    ]);

    // Target applicant
    $user = User::factory()->create();
    $application = Application::factory()->create([
        'user_id' => $user->id,
        'admission_session_id' => $session->id,
        'status' => 'waitlisted',
        'merit_score' => 80,
    ]);

    // Lower ranking waitlisted applicant
    Application::factory()->create([
        'admission_session_id' => $session->id,
        'status' => 'waitlisted',
        'merit_score' => 70,
    ]);

    actingAs($user);

    Volt::test('application-details', ['application' => $application])
        ->assertSee('Waitlisted')
        ->assertSee('Your position on the waiting list:')
        ->assertSeeHtml('<strong>2</strong>');
});

it('can decline an admission offer', function () {
    $user = User::factory()->create();
    $session = AdmissionSession::factory()->create();
    $subject = Subject::factory()->create();
    
    $application = Application::factory()->create([
        'user_id' => $user->id,
        'admission_session_id' => $session->id,
        'status' => 'offered',
        'assigned_subject_id' => $subject->id,
    ]);

    actingAs($user);

    Volt::test('application-details', ['application' => $application])
        ->call('declineAdmission')
        ->assertSee('Application Rejected'); // Or whatever status text we decide
    
    expect($application->refresh()->status)->toBe('rejected');
});

it('shows fee payment instructions when admitted', function () {
    $user = User::factory()->create();
    $session = AdmissionSession::factory()->create();
    $subject = Subject::factory()->create();
    
    $application = Application::factory()->create([
        'user_id' => $user->id,
        'admission_session_id' => $session->id,
        'status' => 'admitted',
        'assigned_subject_id' => $subject->id,
    ]);

    actingAs($user);

    Volt::test('application-details', ['application' => $application])
        ->assertSee('Submit Payment Details')
        ->assertSee('Bank Deposit')
        ->assertSee('bKash');
});
