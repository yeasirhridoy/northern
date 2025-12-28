<?php

use Livewire\Volt\Component;
use App\Models\AdmissionSession;
use App\Models\Application;
use App\Models\Subject;
use App\Models\ApplicationPreference;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public int $step = 1;
    public ?AdmissionSession $activeSession = null;

    // Form Data
    public $father_name = '';
    public $mother_name = '';
    public $dob = '';
    public $phone = '';
    public $address = '';

    public $ssc_board = '';
    public $ssc_roll = '';
    public $ssc_reg = '';
    public $ssc_year = '';
    public $ssc_gpa = '';

    public $hsc_board = '';
    public $hsc_roll = '';
    public $hsc_reg = '';
    public $hsc_year = '';
    public $hsc_gpa = '';
    public $hsc_group = '';

    public array $selectedSubjects = []; // IDs of subjects in order of priority

    public function mount()
    {
        $this->activeSession = AdmissionSession::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (! $this->activeSession) {
            return redirect()->route('dashboard');
        }

        // Check if application already exists
        $existing = Application::where('user_id', auth()->id())
            ->where('admission_session_id', $this->activeSession->id)
            ->first();

        if ($existing) {
            return redirect()->route('application.show', $existing->id);
        }
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'father_name' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'dob' => 'required|date',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'ssc_board' => 'required|string',
                'ssc_roll' => 'required|string',
                'ssc_reg' => 'required|string',
                'ssc_year' => 'required|numeric',
                'ssc_gpa' => 'required|numeric|between:1,5',
                'hsc_board' => 'required|string',
                'hsc_roll' => 'required|string',
                'hsc_reg' => 'required|string',
                'hsc_year' => 'required|numeric',
                'hsc_gpa' => 'required|numeric|between:1,5',
                'hsc_group' => 'required|string',
            ]);
        } elseif ($this->step === 3) {
            if (empty($this->selectedSubjects)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'selectedSubjects' => 'Please select at least one subject.',
                ]);
            }
        }
    }

    public function addSubject($id)
    {
        if (!in_array($id, $this->selectedSubjects)) {
            $this->selectedSubjects[] = $id;
        }
    }

    public function removeSubject($id)
    {
        $this->selectedSubjects = array_values(array_filter($this->selectedSubjects, fn($sid) => $sid != $id));
    }

    public function submit()
    {
        $this->validateStep();

        DB::transaction(function () {
            $application = Application::create([
                'user_id' => auth()->id(),
                'admission_session_id' => $this->activeSession->id,
                'status' => 'submitted',
                'father_name' => $this->father_name,
                'mother_name' => $this->mother_name,
                'dob' => $this->dob,
                'phone' => $this->phone,
                'address' => $this->address,
                'ssc_board' => $this->ssc_board,
                'ssc_roll' => $this->ssc_roll,
                'ssc_reg' => $this->ssc_reg,
                'ssc_year' => $this->ssc_year,
                'ssc_gpa' => $this->ssc_gpa,
                'hsc_board' => $this->hsc_board,
                'hsc_roll' => $this->hsc_roll,
                'hsc_reg' => $this->hsc_reg,
                'hsc_year' => $this->hsc_year,
                'hsc_gpa' => $this->hsc_gpa,
                'hsc_group' => $this->hsc_group,
                'merit_score' => ($this->ssc_gpa * 8) + ($this->hsc_gpa * 12), // Sample merit calculation
            ]);

            foreach ($this->selectedSubjects as $index => $subjectId) {
                ApplicationPreference::create([
                    'application_id' => $application->id,
                    'subject_id' => $subjectId,
                    'priority_order' => $index + 1,
                ]);
            }

            return redirect()->route('application.show', $application->id);
        });
    }

    public function with()
    {
        return [
            'allSubjects' => Subject::with('department')->get(),
            'boards' => ['Dhaka', 'Chittagong', 'Rajshahi', 'Sylhet', 'Barisal', 'Comilla', 'Dinajpur', 'Jessore', 'Mymensingh', 'Madrasah', 'Technical'],
            'groups' => ['Science', 'Humanities', 'Business Studies'],
        ];
    }
}; ?>

<div class="p-6">
    <div class="mb-8">
        <flux:heading size="xl">{{ __('Admission Application') }}</flux:heading>
            <flux:text variant="subtle">{{ $activeSession->name }} Session</flux:text>
        </div>

        <!-- Stepper UI -->
        <div class="flex items-center justify-between mb-8 overflow-x-auto pb-4">
            @foreach(['Personal', 'Academic', 'Subjects', 'Review'] as $i => $label)
                <div class="flex items-center {{ $step >= $i + 1 ? 'text-blue-600' : 'text-gray-400' }}">
                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center font-bold mr-2 {{ $step >= $i + 1 ? 'border-blue-600 bg-blue-50' : 'border-gray-300' }}">
                        {{ $i + 1 }}
                    </div>
                    <span class="whitespace-nowrap">{{ __($label) }}</span>
                    @if($i < 3)
                        <div class="w-8 h-px bg-gray-300 mx-4"></div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            @if($step === 1)
                <div class="space-y-6">
                    <flux:heading size="lg">{{ __('Personal Information') }}</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:input label="{{ __('Father\'s Name') }}" wire:model="father_name" />
                        <flux:input label="{{ __('Mother\'s Name') }}" wire:model="mother_name" />
                        <flux:input type="date" label="{{ __('Date of Birth') }}" wire:model="dob" />
                        <flux:input label="{{ __('Phone Number') }}" wire:model="phone" />
                    </div>
                    <flux:textarea label="{{ __('Present Address') }}" wire:model="address" />
                </div>
            @elseif($step === 2)
                <div class="space-y-6">
                    <flux:heading size="lg">{{ __('Academic Information') }}</flux:heading>
                    
                    <div class="border-b pb-2 mb-4">
                        <flux:heading size="md">{{ __('SSC / Equivalent Information') }}</flux:heading>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <flux:select label="{{ __('Board') }}" wire:model="ssc_board">
                            <option value="">Select Board</option>
                            @foreach($boards as $board) <option value="{{ $board }}">{{ $board }}</option> @endforeach
                        </flux:select>
                        <flux:input label="{{ __('Roll Number') }}" wire:model="ssc_roll" />
                        <flux:input label="{{ __('Registration Number') }}" wire:model="ssc_reg" />
                        <flux:input label="{{ __('Passing Year') }}" wire:model="ssc_year" />
                        <flux:input label="{{ __('GPA') }}" wire:model="ssc_gpa" placeholder="5.00" />
                    </div>

                    <div class="border-b pb-2 mb-4">
                        <flux:heading size="md">{{ __('HSC / Equivalent Information') }}</flux:heading>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:select label="{{ __('Board') }}" wire:model="hsc_board">
                            <option value="">Select Board</option>
                            @foreach($boards as $board) <option value="{{ $board }}">{{ $board }}</option> @endforeach
                        </flux:select>
                        <flux:input label="{{ __('Roll Number') }}" wire:model="hsc_roll" />
                        <flux:input label="{{ __('Registration Number') }}" wire:model="hsc_reg" />
                        <flux:input label="{{ __('Passing Year') }}" wire:model="hsc_year" />
                        <flux:input label="{{ __('GPA') }}" wire:model="hsc_gpa" placeholder="5.00" />
                        <flux:select label="{{ __('Group') }}" wire:model="hsc_group">
                            <option value="">Select Group</option>
                            @foreach($groups as $group) <option value="{{ $group }}">{{ $group }}</option> @endforeach
                        </flux:select>
                    </div>
                </div>
            @elseif($step === 3)
                <div class="space-y-6">
                    <flux:heading size="lg">{{ __('Subject Preference') }}</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <flux:text font-weight="medium" class="mb-2">{{ __('Available Subjects') }}</flux:text>
                            <div class="space-y-2 border rounded-lg p-4 h-64 overflow-y-auto">
                                @foreach($allSubjects as $subject)
                                    @if(!in_array($subject->id, $selectedSubjects))
                                        <div class="flex justify-between items-center p-2 bg-gray-50 dark:bg-gray-700/50 rounded">
                                            <span>{{ $subject->name }} ({{ $subject->department->code }})</span>
                                            <flux:button size="xs" dusk="add-subject-{{ $subject->id }}" wire:click="addSubject({{ $subject->id }})">{{ __('Add') }}</flux:button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <flux:text font-weight="medium" class="mb-2">{{ __('Your Preferences (In Order)') }}</flux:text>
                            <div class="space-y-2 border rounded-lg p-4 h-64 overflow-y-auto">
                                @forelse($selectedSubjects as $index => $sid)
                                    @php $subject = $allSubjects->firstWhere('id', $sid); @endphp
                                    <div class="flex justify-between items-center p-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                                        <span>{{ $index + 1 }}. {{ $subject->name }}</span>
                                        <flux:button size="xs" variant="danger" wire:click="removeSubject({{ $sid }})">{{ __('Remove') }}</flux:button>
                                    </div>
                                @empty
                                    <flux:text variant="subtle" class="text-center py-10">{{ __('No subjects selected yet.') }}</flux:text>
                                @endforelse
                                @error('selectedSubjects') <flux:error>{{ $message }}</flux:error> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($step === 4)
                <div class="space-y-6">
                    <flux:heading size="lg">{{ __('Review Your Application') }}</flux:heading>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                        <div class="space-y-4">
                            <div class="border-b pb-2"><flux:heading size="sm">{{ __('Personal Details') }}</flux:heading></div>
                            <p><strong>Father:</strong> {{ $father_name }}</p>
                            <p><strong>Mother:</strong> {{ $mother_name }}</p>
                            <p><strong>DOB:</strong> {{ $dob }}</p>
                            <p><strong>Phone:</strong> {{ $phone }}</p>
                            
                            <div class="border-b pb-2 pt-4"><flux:heading size="sm">{{ __('SSC Details') }}</flux:heading></div>
                            <p><strong>Board:</strong> {{ $ssc_board }} ({{ $ssc_year }})</p>
                            <p><strong>GPA:</strong> {{ $ssc_gpa }}</p>
                        </div>
                        <div class="space-y-4">
                            <div class="border-b pb-2"><flux:heading size="sm">{{ __('HSC Details') }}</flux:heading></div>
                            <p><strong>Board:</strong> {{ $hsc_board }} ({{ $hsc_year }})</p>
                            <p><strong>Group:</strong> {{ $hsc_group }}</p>
                            <p><strong>GPA:</strong> {{ $hsc_gpa }}</p>

                            <div class="border-b pb-2 pt-4"><flux:heading size="sm">{{ __('Subject Preferences') }}</flux:heading></div>
                            <div class="space-y-1">
                                @foreach($selectedSubjects as $index => $sid)
                                    @php $subject = $allSubjects->firstWhere('id', $sid); @endphp
                                    <p>{{ $index + 1 }}. {{ $subject->name }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex justify-between mt-8">
                @if($step > 1)
                    <flux:button wire:click="prevStep" variant="ghost">{{ __('Previous') }}</flux:button>
                @else
                    <div></div>
                @endif

                @if($step < 4)
                    <flux:button wire:click="nextStep" variant="primary">{{ __('Next') }}</flux:button>
                @else
                    <flux:button wire:click="submit" variant="primary" color="green">{{ __('Submit Application') }}</flux:button>
                @endif
            </div>
        </div>
    </div>
