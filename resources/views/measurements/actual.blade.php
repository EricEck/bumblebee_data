<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Actual Measurements'}}
    </x-slot>

    @livewire('measurement-table',[
                'actualOnly' => 1,
            ])

</x-app-layout>
