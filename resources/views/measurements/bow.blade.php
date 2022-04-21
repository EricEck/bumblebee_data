<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'All Measurements for a Body of Water'}}
    </x-slot>

    @livewire('measurement-table2', [
        'params' => $params,
            ])

</x-app-layout>
