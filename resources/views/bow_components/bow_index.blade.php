<x-app-layout>
    <x-slot name="header">
        <div class="flow-root">
            <div class="float-left">
                {{ request()->get('niblet') ?? 'Body of Water Components'}}
            </div>
            @if(isset($showBack))
                <div class="float-right">
                    <a href="javascript:history.back()"><x-buttons.back/></a>
                </div>
            @endif
        </div>
    </x-slot>


    <!-- Page Content -->
    <div class="flow-root">
        <div class="float-left">
            <h2 class="text-xl md:mb-2">Body of Water Details</h2>
        </div>
        <div class="float-right">
            <a href="{{route('body_of_water_show', ['bow_id'=>$bow->id, 'showBack'=>true])}}">
                <x-buttons.view/></a>
        </div>
    </div>
    <!-- Bow Details Reference -->
    <div class="md:pl-4 md:mt-4">
        <div class="grid md:grid-cols-4 bg-yellow-50 sm:text-sm md:text-xl">
            <x-grid-box-1 label="Owner" value="{{$bow->owner->name}}"/>
            <x-grid-box-1 label="BoW Name" value="{{$bow->name}}"/>
            <x-grid-box-1 class="col-span-2" label="Location" value="{{$bow->address->oneLineAddress()}}"/>
            <x-grid-box-1 label="Construction" value="{{$bow->bowConstructionType->name}}"/>
            <x-grid-box-1 label="Const. Date" value="{{$bow->construction_date}}"/>
            <x-grid-box-1 label="Type" value="{{$bow->bowLocationType->name}}"/>
            <x-grid-box-1 label="Filtration" value="{{$bow->bowFiltrationType->name}}"/>
            <x-grid-box-1 label="Commercial" value="{{$bow->commercial ? 'Yes' : 'No'}}"/>
            <x-grid-box-1 label="Indoor" value="{{$bow->indoor ? 'Yes' : 'No'}}"/>
            <x-grid-box-1 label="Volume" value="{{$bow->gallons.' gals'}}"/>
        </div>
    </div>

    <div class="overflow-y-auto bg-gray-50 md:mt-4">
        <div class="flow-root">
            <div class="float-left">
                <h2 class="text-xl mt-2 md:mb-2">Components</h2>
            </div>
            <div class="float-right">
                <a href="{{route('bow_component_new', ['bow_id'=>$bow->id])}}">
                    <x-buttons.new/></a>
            </div>
        </div>

        <div class="md:ml-4 bg-gray-50">
            @livewire('component-table', ['components' => \App\Models\BowComponent::whereBowId($bow->id)])
        </div>
    </div>


</x-app-layout>
