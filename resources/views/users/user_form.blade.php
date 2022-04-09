<x-app-layout>
    <x-slot name="header">
        <div class="flow-root">
            <div class="float-left">
                {{ request()->get('niblet') ?? 'User Information'}}
            </div>
            @if(isset($showBack))
                <div class="float-right">
                    <a href="javascript:history.back()"><x-buttons.back/></a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @livewire('user-form', [
                        'user' => $user,
                        'allow_edit' => $allow_edit,
                        'showBack' => $showBack,
                        'create_new' => $create_new,
                        ])
            </div>
        </div>
    </div>
</x-app-layout>
