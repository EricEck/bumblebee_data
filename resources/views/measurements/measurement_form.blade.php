<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Measurement Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
{{--                create_new:  {{isset($create_new) ? "set" : "wtf"}}<br>--}}
{{--                allow_edit:  {{isset($allow_edit) ? "set" : "wtf"}}<br>--}}
{{--                measurement:  {{isset($measurement) ? "set" : "wtf"}}<br>--}}
                @livewire('measurement-form', [
                        'measurement' => $measurement,
                        'allow_edit' => $allow_edit,
                        'create_new' => $create_new,
                        ])
            </div>
        </div>
    </div>
</x-app-layout>
