<?php

use Livewire\Volt\Component;
use App\Models\AdmissionSession;
use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {
    public Collection $activeSessions;
    public Collection $applications;

    public function mount()
    {
        $this->activeSessions = AdmissionSession::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        $this->applications = Application::where('user_id', auth()->id())
            ->whereIn('admission_session_id', $this->activeSessions->pluck('id'))
            ->get()
            ->keyBy('admission_session_id');
    }
}; ?>

<div class="p-6">
    <flux:heading size="xl" class="mb-6">{{ __('Applicant Dashboard') }}</flux:heading>

    @if ($activeSessions->isNotEmpty())
        <div class="space-y-6">
            @foreach ($activeSessions as $session)
                @php
                    $application = $applications->get($session->id);
                @endphp
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <flux:heading size="lg">{{ $session->name }}</flux:heading>
                            <flux:text variant="subtle">{{ __('Admission is currently open') }}</flux:text>
                        </div>
                        <flux:badge color="green" inset="top">{{ __('Active') }}</flux:badge>
                    </div>

                    <flux:separator class="my-4" />

                    @if ($application)
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <flux:text font-weight="medium">{{ __('Application Status:') }}</flux:text>
                                <flux:badge color="blue">{{ str($application->status)->headline() }}</flux:badge>
                            </div>

                            @if ($application->merit_score)
                                <div class="flex justify-between items-center">
                                    <flux:text font-weight="medium">{{ __('Merit Score:') }}</flux:text>
                                    <flux:text>{{ $application->merit_score }}</flux:text>
                                </div>
                            @endif

                            @if ($application->assignedSubject)
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                    <flux:text font-weight="semibold" color="blue">{{ __('Offered Subject:') }}</flux:text>
                                    <flux:heading size="md" color="blue">{{ $application->assignedSubject->name }}</flux:heading>
                                </div>
                            @endif

                            <flux:button href="{{ route('application.show', $application->id) }}" variant="primary" class="w-full">
                                {{ __('View Application Details') }}
                            </flux:button>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <flux:text class="mb-4">{{ __('You haven\'t started your application for this session yet.') }}</flux:text>
                            {{-- Pass session_id to the create route --}}
                            <flux:button href="{{ route('application.create', ['session_id' => $session->id]) }}" variant="primary">
                                {{ __('Start Application') }}
                            </flux:button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-6 rounded-xl border border-yellow-200 dark:border-yellow-800 text-center">
            <flux:heading size="lg" color="yellow">{{ __('No Active Admission Session') }}</flux:heading>
            <flux:text class="mt-2">{{ __('There are currently no open admission sessions. Please check back later.') }}</flux:text>
        </div>
    @endif
</div>
