<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'All Measurements'}}
    </x-slot>

    @livewire('measurement-table')

</x-app-layout>
