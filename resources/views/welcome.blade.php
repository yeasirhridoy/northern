<x-layouts.app>
    <div class="relative flex flex-col selection:bg-[#FF2D20] selection:text-white">

        <!-- Hero Section -->
        <div class="flex-1 flex flex-col items-center justify-center py-12 text-center lg:py-16">
            <div class="max-w-3xl mx-auto space-y-8">
                <div class="space-y-4">
                    <h1 class="text-5xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">
                        Shape Your Future at <br>
                        <span class="text-blue-600 dark:text-blue-500">Northern University</span>
                    </h1>
                    <p class="text-xl text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
                        Join a community of innovators and leaders. Applications are now open for the upcoming academic session.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" variant="primary" icon-trailing="arrow-right">
                            Go to Dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('register') }}" variant="primary" icon-trailing="arrow-right">
                            Apply Now
                        </flux:button>
                    @endauth
                </div>

                <!-- Latest Notices -->
                @php
                    $latestNotices = \App\Models\Notice::where('is_active', true)->latest()->take(5)->get();
                @endphp
                @if($latestNotices->isNotEmpty())
                    <div class="mt-12 max-w-2xl mx-auto">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Latest Notices</h2>
                            <flux:button href="{{ route('notices.index') }}" variant="ghost" size="sm">View All</flux:button>
                        </div>
                        <div class="space-y-4 text-left">
                            @foreach($latestNotices as $notice)
                                <a href="{{ route('notices.show', $notice) }}" class="block p-4 rounded-xl bg-white dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800 hover:border-blue-500 dark:hover:border-blue-500 transition-all group shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                                                <flux:icon.calendar class="size-3" />
                                                <span>{{ $notice->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <h3 class="font-semibold text-zinc-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-1">
                                                {{ $notice->title }}
                                            </h3>
                                        </div>
                                        <flux:icon.chevron-right class="size-4 text-zinc-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all" />
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Features / Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 text-left">
                    <div class="p-6 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800">
                        <div class="h-10 w-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-4 text-blue-600 dark:text-blue-400">
                            <flux:icon.book-open-text />
                        </div>
                        <h3 class="text-lg font-bold mb-2">World-Class Curriculum</h3>
                        <p class="text-zinc-500 dark:text-zinc-400">Modern syllabus designed to meet global standards and industry demands.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800">
                        <div class="h-10 w-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-4 text-green-600 dark:text-green-400">
                            <flux:icon.folder-git-2 />
                        </div>
                        <h3 class="text-lg font-bold mb-2">Easy Application</h3>
                        <p class="text-zinc-500 dark:text-zinc-400">Streamlined digital admission process. Apply from anywhere in minutes.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-800">
                        <div class="h-10 w-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mb-4 text-purple-600 dark:text-purple-400">
                            <flux:icon.layout-grid />
                        </div>
                        <h3 class="text-lg font-bold mb-2">Merit-Based</h3>
                        <p class="text-zinc-500 dark:text-zinc-400">Transparent evaluation system based on your academic achievements.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
