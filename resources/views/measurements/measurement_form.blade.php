<x-app-layout>
    <x-slot name="header">
        <div class="flow-root">
            <div class="float-left">
                {{ request()->get('niblet') ?? 'Measurement Information'}}
            </div>
            @if($showBack)
                <div class="float-right">
                    <a href="javascript:history.back()"><x-buttons.back/></a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="md:py-1">
        <div class="md:max-w-7xl sm:max-w-2xl mx-auto md:px-6 md:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @livewire('measurement-form', [
                        'measurement' => $measurement,
                        'allow_edit' => $allow_edit,
                        'create_new' => $create_new,
                        'showBack' => $showBack,
                        ])
            </div>
        </div>
    </div>
</x-app-layout>
