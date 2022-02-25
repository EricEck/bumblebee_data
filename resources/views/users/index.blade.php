<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Users'}}
    </x-slot>

    <livewire:users-table />

</x-app-layout>


