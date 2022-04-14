<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Bumblebees'}}
    </x-slot>

    @livewire('bumblebee-table')

</x-app-layout>
