@props(['bow', 'showActions' => 0])

<tr class="text-xs">
    <td class="border px-1 py-1 ">{{ $bow->id }}</td>
    <td class="border px-1 py-1 "><a href="{{route('user_form_edit', ['user_id' => $bow->owner->id])}}" class="underline">{{ $bow->owner->name }}</a></td>
    <td class="border px-1 py-1 ">{{ $bow->name }}</td>
    <td class="border px-1 py-1 ">{{ $bow->address->oneLineAddress() }}</td>
    <td class="border px-1 py-1 ">{{ \App\Models\BowComponent::countForBodyOfWaterId($bow->id) }}</td>
    <td class="border px-1 py-1 ">#</td>
    <td class="border px-1 py-1 ">{{$bow->bowLocationType->name}}</td>
{{--    <td class="border px-1 py-1 ">{{$bow->indoor ? 'Yes' : 'No'}}</td>--}}
{{--    <td class="border px-1 py-1 ">{{$bow->commerical ? 'Yes' : 'No'}}</td>--}}

    @if($showActions)
        <td class="border px-2 lg:pb-3 md:pb-2 pb-0">
            <div class="flex flex-row">
                <x-datahelpers.icon-tooltip class="basis-1/4">
                    <x-slot name="datafield" >
                        <a href="{{route('measurementBowId',['bow_id' => $bow->id])}}" >
                            <x-buttons.measurement href="{{route('measurementBowId',['bow_id' => $bow->id])}}"/></a>
                    </x-slot>
                    <x-slot name="tooltipfield">
                        Measurements
                    </x-slot>
                </x-datahelpers.icon-tooltip>

                <x-datahelpers.icon-tooltip class="basis-1/4">
                    <x-slot name="datafield" >
                        <a  href="{{route('body_of_water_edit',['bow_id' => $bow->id])}}" >
                            <x-buttons.edit/></a>
                    </x-slot>
                    <x-slot name="tooltipfield">
                        Edit
                    </x-slot>
                </x-datahelpers.icon-tooltip>

                <x-datahelpers.icon-tooltip class="basis-1/4">
                    <x-slot name="datafield" >
                        <a  href="{{route('body_of_water_show',['bow_id' => $bow->id])}}" >
                            <x-buttons.view/></a>
                    </x-slot>
                    <x-slot name="tooltipfield">
                        View
                    </x-slot>
                </x-datahelpers.icon-tooltip>

                <x-datahelpers.icon-tooltip class="basis-1/4">
                    <x-slot name="datafield" >
                        <a  href="{{route('bow_components_list',['bow_id' => $bow->id])}}" >
                            <x-buttons.gears/></a>
                    </x-slot>
                    <x-slot name="tooltipfield">
                        Components
                    </x-slot>
                </x-datahelpers.icon-tooltip>

            </div>
        </td>
    @endif
</tr>

