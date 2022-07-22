<x-app-layout>
    <x-slot name="header">
        @php
            $bow = \App\Models\BodiesOfWater::find($bow_id);
        @endphp
        @if(strlen($bow->name))
            Summary for {{ $bow->name }}
        @else
            {{ request()->get('niblet') ?? 'BoW Summary'}}
        @endif

    </x-slot>

    @livewire('bow-summary', ['bow_id' => $bow_id])

</x-app-layout>
