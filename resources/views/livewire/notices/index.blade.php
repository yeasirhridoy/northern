<?php

use Livewire\Volt\Component;
use App\Models\Notice;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public function with(): array
    {
        return [
            'notices' => Notice::where('is_active', true)->latest()->paginate(10),
        ];
    }
}; ?>

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Notices</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-400">Stay updated with the latest news and announcements from Northern University.</p>
        </div>

        <div class="grid gap-6">
            @foreach ($notices as $notice)
                <div wire:key="notice-{{ $notice->id }}" class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row">
                        @if ($notice->image)
                            <div class="md:w-48 h-48 md:h-auto overflow-hidden">
                                <img src="{{ asset('storage/' . $notice->image) }}" alt="{{ $notice->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-6 flex-1">
                            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 mb-2">
                                <flux:icon.calendar class="size-4" />
                                <span>{{ $notice->created_at->format('M d, Y') }}</span>
                            </div>
                            <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">
                                <a href="{{ route('notices.show', $notice) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $notice->title }}
                                </a>
                            </h2>
                            <div class="prose prose-zinc dark:prose-invert max-w-none line-clamp-3 mb-4">
                                {!! strip_tags($notice->content) !!}
                            </div>
                            <flux:button href="{{ route('notices.show', $notice) }}" variant="ghost" icon-trailing="arrow-right">
                                Read More
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $notices->links() }}
        </div>
    </div>
</div>
