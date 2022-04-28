<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'System Bumblebee Calibrations'}}
    </x-slot>

    @livewire('calibration-table')


</x-app-layout>
