<x-layouts.app.header :title="$title ?? null">
    <flux:main container>
        {{ $slot }}
    </flux:main>
    <livewire:chat-widget />
</x-layouts.app.header>
