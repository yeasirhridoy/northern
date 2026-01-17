<x-layouts.app.header :title="$title ?? null">
    <flux:main container class="flex-1 w-full">
        {{ $slot }}
    </flux:main>


    <livewire:chat-widget />
</x-layouts.app.header>
