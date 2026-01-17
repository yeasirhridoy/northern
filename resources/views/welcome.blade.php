<x-layouts.app>
    <!-- Hero Section -->
    <section class="relative pt-20 pb-32 overflow-hidden bg-white dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-zinc-900 dark:text-white mb-8">
                Shape Your Future at <br>
                <span class="text-blue-600 dark:text-blue-500">Northern University</span>
            </h1>
            <p class="text-xl text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Join a community of innovators and leaders. Applications are now open for the upcoming academic session. Experience world-class education in the heart of the city.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <flux:button href="{{ route('dashboard') }}" variant="primary" icon-trailing="arrow-right" class="font-semibold !py-3 !px-6">
                        Go to Dashboard
                    </flux:button>
                @else
                    <flux:button href="{{ route('register') }}" variant="primary" icon-trailing="arrow-right" class="font-semibold !py-3 !px-6">
                        Apply Now
                    </flux:button>
                    <flux:button href="{{ route('departments.index') }}" variant="ghost" class="font-semibold !py-3 !px-6">
                        Explore Departments
                    </flux:button>
                @endauth
            </div>
        </div>
        
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none opacity-50 dark:opacity-20">
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl mix-blend-multiply filter"></div>
            <div class="absolute bottom-10 right-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl mix-blend-multiply filter"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-zinc-900 text-white relative overflow-hidden">
        <div class="absolute inset-0">
             <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop" class="object-cover w-full h-full opacity-10" alt="Stats Background" />
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-1">10k+</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider font-semibold">Students</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">15+</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider font-semibold">Years of Excellence</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">50+</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider font-semibold">Modern Labs</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">20k+</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider font-semibold">Alumni</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-24 bg-white dark:bg-zinc-900 border-b border-zinc-100 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">Empowering Minds,<br>Transforming Lives</h2>
                    <p class="text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        At Northern University, we believe in the transformative power of education. For over a decade, we have been a beacon of learning, research, and innovation. Our campus is a melting pot of ideas, cultures, and ambitions.
                    </p>
                    <p class="text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed">
                         Whether you dream of engineering the future, advocating for justice, or leading global businesses, we provide the foundation you need to succeed.
                    </p>
                    <div class="pt-4">
                        <flux:button variant="subtle" icon-trailing="arrow-right">Learn More About Us</flux:button>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-zinc-100 dark:bg-zinc-800 rounded-2xl transform rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=2070&auto=format&fit=crop" alt="Students in library" class="relative rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 w-full" />
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Departments -->
    <section class="py-24 bg-zinc-50 dark:bg-zinc-800/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-4">Featured Departments</h2>
                <p class="text-zinc-600 dark:text-zinc-400">Discover our varied academic programs designed to equip you with the skills for tomorrow's challenges.</p>
            </div>

            @php
                $featuredDepts = \App\Models\Department::whereIn('code', ['CSE', 'EEE', 'PHARM', 'LAW'])->get();
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredDepts as $dept)
                    <a href="{{ route('departments.index') }}" class="group bg-white dark:bg-zinc-900 rounded-xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="h-12 w-12 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mb-6 text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            @if($dept->code === 'CSE') <flux:icon.command-line />
                            @elseif($dept->code === 'EEE') <flux:icon.bolt />
                            @elseif($dept->code === 'PHARM') <flux:icon.beaker />
                            @elseif($dept->code === 'LAW') <flux:icon.scale />
                            @else <flux:icon.academic-cap />
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">{{ $dept->name }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3">
                            {!! strip_tags($dept->description) !!}
                        </p>
                    </a>
                @endforeach
            </div>
             <div class="mt-12 text-center">
                <flux:button href="{{ route('departments.index') }}" variant="ghost" icon-trailing="arrow-right">View All Departments</flux:button>
            </div>
        </div>
    </section>

    <!-- Latest Notices (Refined) -->
    @php
        $latestNotices = \App\Models\Notice::where('is_active', true)->latest()->take(3)->get();
    @endphp
    @if($latestNotices->isNotEmpty())
        <section class="py-24 bg-white dark:bg-zinc-900">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="flex items-center justify-between mb-12">
                     <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">Notice Board</h2>
                     <flux:button href="{{ route('notices.index') }}" variant="subtle" size="sm">All Notices</flux:button>
                 </div>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     @foreach($latestNotices as $notice)
                         <a href="{{ route('notices.show', $notice) }}" class="flex flex-col p-6 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 hover:border-blue-500 hover:shadow-md transition-all group h-full">
                             <div class="flex-1 space-y-3">
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                                     {{ $notice->created_at->format('M d, Y') }}
                                 </span>
                                 <h3 class="font-bold text-lg text-zinc-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                     {{ $notice->title }}
                                 </h3>
                                 <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-3">
                                    Click to view more details about this notice.
                                 </p>
                             </div>
                             <div class="mt-6 flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform">
                                 Read More <flux:icon.arrow-right class="ml-1 size-3" />
                             </div>
                         </a>
                     @endforeach
                 </div>
             </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="py-20 bg-blue-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pattern-dots"></div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
            <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto">
                Applications for the Spring 2026 session are closing soon. Don't miss your chance to be part of Northern University.
            </p>
             @guest
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                     <flux:button href="{{ route('register') }}" class="!bg-white !text-blue-600 !border-white hover:!bg-blue-50" icon-trailing="arrow-right">
                        Apply Online
                    </flux:button>
                    <flux:button href="#" class="!bg-blue-700 !text-white !border-blue-500 hover:!bg-blue-800">
                        Contact Admissions
                    </flux:button>
                </div>
            @else
                <flux:button href="{{ route('dashboard') }}" class="!bg-white !text-blue-600 !border-white hover:!bg-blue-50" icon-trailing="arrow-right">
                    Go to Application Portal
                </flux:button>
            @endguest
        </div>
    </section>
</x-layouts.app>
