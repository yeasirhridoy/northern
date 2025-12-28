<?php

use Livewire\Volt\Component;
use App\Models\Application;

new class extends Component {
    public Application $application;

    public function mount(Application $application)
    {
        // Ensure user owns the application
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $this->application = $application->load(['session', 'assignedSubject', 'preferences.subject']);
    }

    public function acceptAdmission()
    {
        if ($this->application->status === 'offered') {
            $this->application->update(['status' => 'admitted']);
            $this->application = $this->application->refresh();
        }
    }
}; ?>

<x-layouts.app>
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <flux:heading size="xl">{{ __('Application Details') }}</flux:heading>
                <flux:text variant="subtle">{{ $application->session->name }} Session</flux:text>
            </div>
            <flux:badge color="blue" size="lg">{{ str($application->status)->headline() }}</flux:badge>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <!-- Personal Info -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <flux:heading size="lg" class="mb-4">{{ __('Personal Information') }}</flux:heading>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <flux:text variant="subtle">{{ __('Father\'s Name') }}</flux:text>
                            <p class="font-medium">{{ $application->father_name }}</p>
                        </div>
                        <div>
                            <flux:text variant="subtle">{{ __('Mother\'s Name') }}</flux:text>
                            <p class="font-medium">{{ $application->mother_name }}</p>
                        </div>
                        <div>
                            <flux:text variant="subtle">{{ __('Date of Birth') }}</flux:text>
                            <p class="font-medium">{{ $application->dob->format('d M Y') }}</p>
                        </div>
                        <div>
                            <flux:text variant="subtle">{{ __('Phone') }}</flux:text>
                            <p class="font-medium">{{ $application->phone }}</p>
                        </div>
                        <div class="col-span-2">
                            <flux:text variant="subtle">{{ __('Address') }}</flux:text>
                            <p class="font-medium">{{ $application->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Info -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <flux:heading size="lg" class="mb-4">{{ __('Academic Information') }}</flux:heading>
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="sm" class="mb-2 text-blue-600">{{ __('SSC / Equivalent') }}</flux:heading>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div><flux:text variant="subtle">{{ __('Board') }}</flux:text><p class="font-medium">{{ $application->ssc_board }}</p></div>
                                <div><flux:text variant="subtle">{{ __('Year') }}</flux:text><p class="font-medium">{{ $application->ssc_year }}</p></div>
                                <div><flux:text variant="subtle">{{ __('GPA') }}</flux:text><p class="font-medium">{{ $application->ssc_gpa }}</p></div>
                            </div>
                        </div>
                        <flux:separator />
                        <div>
                            <flux:heading size="sm" class="mb-2 text-blue-600">{{ __('HSC / Equivalent') }}</flux:heading>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div><flux:text variant="subtle">{{ __('Board') }}</flux:text><p class="font-medium">{{ $application->hsc_board }}</p></div>
                                <div><flux:text variant="subtle">{{ __('Year') }}</flux:text><p class="font-medium">{{ $application->hsc_year }}</p></div>
                                <div><flux:text variant="subtle">{{ __('Group') }}</flux:text><p class="font-medium">{{ $application->hsc_group }}</p></div>
                                <div><flux:text variant="subtle">{{ __('GPA') }}</flux:text><p class="font-medium">{{ $application->hsc_gpa }}</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Status & Action -->
                <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-xl border border-blue-200 dark:border-blue-800">
                    <flux:heading size="md" class="mb-2">{{ __('Merit Score') }}</flux:heading>
                    <flux:text size="xl" font-weight="bold" color="blue">{{ $application->merit_score ?? __('Not Calculated') }}</flux:text>
                    
                    @if($application->assignedSubject)
                        <div class="mt-6 p-4 bg-green-100 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-800">
                            <flux:text size="sm" color="green" font-weight="semibold">{{ __('Admission Offered In:') }}</flux:text>
                            <flux:heading size="sm">{{ $application->assignedSubject->name }}</flux:heading>
                            
                            @if($application->status !== 'admitted')
                                <flux:button color="green" class="mt-4 w-full" variant="primary" wire:click="acceptAdmission">
                                    {{ __('Accept & Confirm Admission') }}
                                </flux:button>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Preferences -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <flux:heading size="md" class="mb-4">{{ __('Subject Preferences') }}</flux:heading>
                    <div class="space-y-3">
                        @foreach($application->preferences->sortBy('priority_order') as $pref)
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-xs font-bold">
                                    {{ $pref->priority_order }}
                                </div>
                                <flux:text size="sm">{{ $pref->subject->name }}</flux:text>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <flux:button href="{{ route('dashboard') }}" icon="arrow-left" variant="ghost">{{ __('Back to Dashboard') }}</flux:button>
        </div>
    </div>
</x-layouts.app>
