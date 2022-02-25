<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Bumblebees direct'}}
    </x-slot>

    <livewire:measurement-table/>

</x-app-layout>
