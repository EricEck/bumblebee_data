<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'All Measurements for Body of Water: '.$bodyOfWater->name}}
    </x-slot>

    @livewire('measurement-table2', [
        'bodyOfWater' => $bodyOfWater,
        'params' => $params,
            ])

</x-app-layout>
