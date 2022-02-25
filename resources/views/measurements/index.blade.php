<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Bumblebees direct'}}
    </x-slot>


    <livewire:bumblebee-table></livewire:bumblebee-table>

</x-app-layout>
