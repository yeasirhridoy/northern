<?php

use Livewire\Volt\Component;
use App\Models\Application;

new class extends Component {
    public Application $application;
    public ?int $waitlistPosition = null;

    // Payment Form Properties
    public $payment_method;
    public $payment_amount;
    public $payment_trx_id;

    public function mount(Application $application)
    {
        // Ensure user owns the application
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $this->application = $application->load(['session', 'assignedSubject', 'preferences.subject']);
        $this->calculateWaitlistPosition();
        
        // Initialize payment form
        $this->payment_method = 'Bank';
    }

    public function calculateWaitlistPosition()
    {
        if ($this->application->status === 'waitlisted') {
            $this->waitlistPosition = \App\Models\Application::where('status', 'waitlisted')
                ->where('admission_session_id', $this->application->admission_session_id)
                ->where('merit_score', '>=', $this->application->merit_score)
                ->count();
        } else {
            $this->waitlistPosition = null;
        }
    }

    public function acceptAdmission()
    {
        if ($this->application->status === 'offered') {
            $this->application->update(['status' => 'admitted']);
            $this->application = $this->application->refresh();
        }
    }

    public function declineAdmission()
    {
        if ($this->application->status === 'offered') {
            $this->application->update(['status' => 'rejected']);
            $this->application = $this->application->refresh();
        }
    }

    public function submitPayment()
    {
        $this->validate([
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric|min:10',
            'payment_trx_id' => 'required|string',
        ]);

        $this->application->update([
            'payment_method' => $this->payment_method,
            'payment_amount' => $this->payment_amount,
            'payment_trx_id' => $this->payment_trx_id,
            'payment_status' => 'pending',
        ]);

        $this->application = $this->application->refresh();
        $this->reset(['payment_method', 'payment_amount', 'payment_trx_id']);
    }

    public function getWaitlistPositionProperty()
    {
        return $this->waitlistPosition;
    }
}; ?>

<div class="p-6">
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
                            
                            @if($application->status === 'offered')
                                <div class="flex gap-2 mt-4">
                                    <flux:button color="green" class="w-full" variant="primary" wire:click="acceptAdmission">
                                        {{ __('Accept') }}
                                    </flux:button>
                                    
                                    <flux:button color="red" class="w-full" variant="ghost" wire:confirm="Are you sure you want to decline this offer?" wire:click="declineAdmission">
                                        {{ __('Decline') }}
                                    </flux:button>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($application->status === 'waitlisted')
                        <div class="mt-6 p-4 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg border border-yellow-200 dark:border-yellow-800">
                            <flux:text size="sm" color="yellow" font-weight="semibold">{{ __('Waiting List Status') }}</flux:text>
                            <p class="text-yellow-800 dark:text-yellow-400 mt-1">
                                {{ __('Your position on the waiting list:') }} <strong>{{ $waitlistPosition }}</strong>
                            </p>
                        </div>
                    @endif

                    @if($application->status === 'admitted')
                        <div class="mt-6 p-4 bg-blue-100 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800">
                            @if($application->payment_status === 'approved')
                                <flux:heading size="sm" class="mb-2 text-green-800 dark:text-green-400">{{ __('Enrolled') }}</flux:heading>
                                <p class="text-green-800 dark:text-green-400">
                                    {{ __('Registration ID:') }} <strong>{{ $application->registration_id }}</strong>
                                </p>
                            @elseif($application->payment_status === 'pending')
                                <flux:heading size="sm" class="mb-2 text-yellow-800 dark:text-yellow-400">{{ __('Payment Pending') }}</flux:heading>
                                <p class="text-yellow-800 dark:text-yellow-400">
                                    {{ __('Your payment is under review.') }}
                                </p>
                            @else
                                <flux:heading size="sm" class="mb-4 text-blue-800 dark:text-blue-400">{{ __('Submit Payment Details') }}</flux:heading>
                                
                                @if($application->payment_status === 'rejected')
                                    <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">
                                        {{ __('Your previous payment was rejected. Please try again.') }}
                                    </div>
                                @endif

                                <form wire:submit="submitPayment" class="space-y-4">
                                    <flux:select wire:model="payment_method" label="Payment Method" placeholder="Select method">
                                        <option value="Bank">Bank Deposit</option>
                                        <option value="bKash">bKash</option>
                                        <option value="Nagad">Nagad</option>
                                        <option value="Cash">Cash</option>
                                    </flux:select>
                                    
                                    <flux:input wire:model="payment_amount" label="Amount" type="number" placeholder="Enter amount" />
                                    
                                    <flux:input wire:model="payment_trx_id" label="Transaction ID" placeholder="TrxID / Ref No" />
                                    
                                    <flux:button type="submit" variant="primary" class="w-full">{{ __('Submit Payment') }}</flux:button>
                                </form>
                            @endif
                        </div>
                    @endif

                    @if($application->status === 'rejected')
                        <div class="mt-6 p-4 bg-red-100 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-800">
                            <flux:text size="sm" color="red" font-weight="semibold">{{ __('Application Rejected') }}</flux:text>
                            <p class="text-red-800 dark:text-red-400 mt-1">
                                {{ __('This application has been rejected or withdrawn.') }}
                            </p>
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
