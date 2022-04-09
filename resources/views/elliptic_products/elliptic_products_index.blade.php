<x-app-layout>
    <x-slot name="header">
        <div class="flow-root">
            <div class="float-left">
                {{ request()->get('niblet') ?? 'Elliptic Works\' Products'}}
            </div>
            @if($showBack)
                <div class="float-right">
                    <a href="javascript:history.back()"><x-buttons.back/></a>
                </div>
            @endif
        </div>
    </x-slot>


    <!-- Page Content -->

    <div class="overflow-y-auto md:mt-4">
        <div class="flow-root">
            <div class="float-left">
                <h2 class="text-xl mt-2 md:mb-2">Product List</h2>
            </div>
            <div class="float-right">
                <a href="{{route('elliptic_product_new')}}">
                    <x-buttons.new/>
                </a>
            </div>
        </div>

        <div class="md:ml-4 bg-gray-50">
            @livewire('elliptic-product-table')
        </div>
    </div>

</x-app-layout>
