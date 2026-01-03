<?php

use Livewire\Volt\Component;
use App\Models\Notice;

new class extends Component {
    public Notice $notice;
}; ?>

<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <flux:button href="{{ route('notices.index') }}" variant="ghost" icon="arrow-left" class="mb-4">
                Back to Notices
            </flux:button>
            
            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                <flux:icon.calendar class="size-4" />
                <span>Published on {{ $notice->created_at->format('M d, Y') }}</span>
            </div>
            
            <h1 class="text-4xl font-extrabold text-zinc-900 dark:text-white leading-tight">
                {{ $notice->title }}
            </h1>
        </div>

        @if ($notice->image)
            <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                <img src="{{ asset('storage/' . $notice->image) }}" alt="{{ $notice->title }}" class="w-full h-auto object-cover">
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8 shadow-sm">
            <div class="prose prose-zinc dark:prose-invert max-w-none">
                {!! $notice->content !!}
            </div>
        </div>
    </div>
</div>
