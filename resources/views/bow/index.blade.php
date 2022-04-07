<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Bodies of Water'}}
    </x-slot>

    @livewire('body-of-water-table')


</x-app-layout>
