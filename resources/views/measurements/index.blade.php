<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Measurements'}}
    </x-slot>

    <livewire:measurement-table/>

</x-app-layout>
