<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Measurement for '.$bumblebee_select->serial_number.' owned by '.$bumblebee_select->owner->name }}
    </x-slot>

    @livewire('measurement-table',[
                'bumblebee_select' => $bumblebee_select
            ])

</x-app-layout>
