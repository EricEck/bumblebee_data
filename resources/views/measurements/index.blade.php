<x-app-layout>
    <x-slot name="header">
        {{ request()->get('niblet') ?? 'Users direct'}}
    </x-slot>


    <livewire:users-table></livewire:users-table>

</x-app-layout>
