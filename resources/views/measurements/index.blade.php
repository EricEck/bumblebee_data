<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Measurements direct'}}
    </x-slot>

    <livewire:measurement-table/>

</x-app-layout>
