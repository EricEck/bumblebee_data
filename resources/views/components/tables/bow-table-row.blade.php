@props(['bow', 'showActions' => 0])

<tr class="text-xs">
    <td class="border px-1 py-1 ">{{ $bow->id }}</td>
    <td class="border px-1 py-1 ">{{ $bow->owner->name }}</td>
    <td class="border px-1 py-1 ">{{ $bow->name }}</td>
    <td class="border px-1 py-1 ">{{ $bow->address->oneLineAddress() }}</td>
    <td class="border px-1 py-1 ">{{ \App\Models\BowComponent::countForBodyOfWaterId($bow->id) }}</td>
    <td class="border px-1 py-1 ">#</td>
    <td class="border px-1 py-1 ">{{$bow->bowLocationType->name}}</td>
    <td class="border px-1 py-1 ">{{$bow->indoor ? 'Yes' : 'No'}}</td>
    <td class="border px-1 py-1 ">{{$bow->commerical ? 'Yes' : 'No'}}</td>

    @if($showActions)
        <td class="border px-1 py-1 flex">
            <a class="flex-1 w-1/3" href="{{route('body_of_water_edit',['bow_id' => $bow->id])}}" >
                <x-buttons.edit/></a>
            <a class="flex-1 w-1/3" href="{{route('body_of_water_show',['bow_id' => $bow->id])}}" >
                <x-buttons.view/></a>
            <a class="flex-1 w-1/3" href="{{route('bow_components_list',['bow_id' => $bow->id])}}" >
                <x-buttons.gears/></a>
        </td>
    @endif
</tr>
