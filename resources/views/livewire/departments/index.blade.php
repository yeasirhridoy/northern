<?php

use Livewire\Volt\Component;
use App\Models\Department;

new class extends Component {
    
    public $departments;
    public $selectedDepartmentId; 

    public function mount()
    {
        $this->departments = Department::orderBy('name')->get();
        $this->selectedDepartmentId = $this->departments->first()?->id;
    }

    public function selectDepartment($id)
    {
        $this->selectedDepartmentId = $id;
    }
    
    public function with(): array
    {
        return [
            'selectedDepartment' => $this->departments->where('id', $this->selectedDepartmentId)->first(),
        ];
    }
}; ?>

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Departments</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-400">Explore our academic departments and their offerings.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Sidebar / Tabs -->
            <div class="md:col-span-1 border-r border-zinc-200 dark:border-zinc-700 pr-4">
                <div class="flex flex-col space-y-2">
                    @foreach($departments as $dept)
                        <button 
                            wire:click="selectDepartment({{ $dept->id }})"
                            class="text-left px-4 py-3 rounded-lg text-sm font-medium transition-colors
                            {{ $selectedDepartmentId === $dept->id 
                                ? 'bg-zinc-100 dark:bg-zinc-700 text-zinc-900 dark:text-white border-l-4 border-blue-600' 
                                : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800' }}"
                        >
                            {{ $dept->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Content Area -->
            <div class="md:col-span-3">
                @if($selectedDepartment)
                    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-sm border border-zinc-200 dark:border-zinc-700">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $selectedDepartment->name }}</h2>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 mt-2">
                                    {{ $selectedDepartment->code }}
                                </span>
                            </div>
                        </div>

                        <div class="prose prose-zinc dark:prose-invert max-w-none mb-8">
                            <h3 class="text-lg font-semibold mb-2">About the Department</h3>
                            <div class="space-y-4">
                                {!! $selectedDepartment->description ?? 'No description available.' !!}
                            </div>
                        </div>

                        @if($selectedDepartment->costing)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4 text-zinc-900 dark:text-white">Costing & Fees</h3>
                                <div class="overflow-hidden ring-1 ring-black ring-opacity-5 rounded-lg">
                                    <table class="min-w-full divide-y divide-zinc-300 dark:divide-zinc-700">
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-800">
                                            @foreach($selectedDepartment->costing as $cost)
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-zinc-900 dark:text-white sm:pl-6">
                                                        {{ $cost['label'] ?? '' }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $cost['type'] ?? '' }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-zinc-900 dark:text-white font-semibold text-right">
                                                        {{ $cost['amount'] ?? '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                           <p class="text-zinc-500 italic">Costing information coming soon.</p>
                        @endif
                        
                         <div class="mt-8 border-t border-zinc-200 dark:border-zinc-700 pt-6">
                             <flux:button variant="primary" icon="arrow-right">
                                Apply Now
                             </flux:button>
                         </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center p-12 text-center text-zinc-500">
                        <flux:icon.building-library class="size-12 mb-4 opacity-50" />
                        <p class="text-lg">Select a department to view details</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
