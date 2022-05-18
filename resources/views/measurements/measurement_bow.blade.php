<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'All Measurements for a Body of Water'}}
    </x-slot>

    @livewire('measurement-bow', ['bow_id' => $bow_id])

</x-app-layout>
