@props(['showActions' => true, 'showBow' => false])

<tr class="text-xs">
    @if($showBow)
        <td class="border px-1 py-1 ">{{ $bowComponent->bodyOfWater->id}}</td>
        <td class="border px-1 py-1 ">
            <a href="{{route('body_of_water_show', ['bow_id' => $bowComponent->bodyOfWater->id])}}" >
                <x-buttons.view class="basis-1/5">{{ $bowComponent->bodyOfWater->name }}</x-buttons.view></a>
        </td>
    @endif
    <td class="border px-1 py-1 ">{{ $bowComponent->id}}</td>
    <td class="border px-1 py-1 ">{{ $bowComponent->name}}</td>
    <td class="border px-1 py-1 ">{{ $bowComponent->installed_now ? 'Yes' : 'No'}}</td>
    <td class="border px-1 py-1 ">{{ $bowComponent->componentLocation->name}}</td>
    <td class="border px-1 py-1 ">{{ $bowComponent->brand->name}}</td>
    <td class="border px-1 py-1 ">{{ $bowComponent->modelNumber()}}</td>
    <td class="border px-1 py-1 ">{{ $bowComponent->serialNumber()}}</td>

    @if($showActions)
        <td class="border px-1 py-1 flex">
            <a class="flex-1 w-1/2" href="{{route('bow_component_edit',['bow_component_id' => $bowComponent->id])}}" >
                <x-buttons.edit/></a>
            <a class="flex-1 w-1/2" href="{{route('bow_component_show',['bow_component_id' => $bowComponent->id])}}" >
                <x-buttons.view/></a>
        </td>
    @endif
</tr>
