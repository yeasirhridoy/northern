<x-layouts.app.header :title="$title ?? null">
    <flux:main class="flex-1 w-full !p-0">
        {{ $slot }}
    </flux:main>


    <livewire:chat-widget />
</x-layouts.app.header>
