<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-zinc-900">
        <div class="flex min-h-screen w-full">
             {{-- Left: Branding --}}
            <div class="hidden lg:flex w-1/2 bg-zinc-900 text-white flex-col justify-between p-12 relative overflow-hidden">
                 <div class="absolute inset-0">
                     <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop" class="object-cover w-full h-full opacity-50" alt="University Campus" />
                     <div class="absolute inset-0 bg-zinc-900/60 mix-blend-multiply"></div>
                     <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                 </div>

                 {{-- Logo --}}
                 <div class="relative z-10 flex items-center gap-3 font-bold text-xl">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10 backdrop-blur-sm border border-white/20">
                        <x-app-logo-icon class="size-6 fill-white" />
                    </div>
                    {{ config('app.name') }}
                 </div>

                 {{-- Quote --}}
                 <div class="relative z-10 max-w-lg">
                    <blockquote class="space-y-4">
                        <p class="text-xl font-medium leading-relaxed font-serif italic">
                            &ldquo;Education is the most powerful weapon which you can use to change the world.&rdquo;
                        </p>
                        <footer class="text-sm font-medium text-white/80 flex items-center gap-2">
                             <div class="h-px w-8 bg-white/50"></div>
                             Nelson Mandela
                        </footer>
                    </blockquote>
                 </div>
            </div>

            {{-- Right: Form --}}
            <div class="flex w-full lg:w-1/2 flex-col items-center justify-center p-8 lg:p-12 bg-white dark:bg-zinc-900">
                 <div class="w-full max-w-sm space-y-10">
                    {{-- Mobile Logo --}}
                    <div class="flex lg:hidden items-center gap-2 font-bold text-xl mb-8">
                        <x-app-logo-icon class="size-8 fill-current text-zinc-900 dark:text-white" />
                        {{ config('app.name') }}
                    </div>

                    {{ $slot }}
                 </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
