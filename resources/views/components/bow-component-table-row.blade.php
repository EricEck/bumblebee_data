@props(['showActions' => 0, 'showBow' => false])

<tr class="text-xs">
    @if($showBow)
        <td class="border px-1 py-1 ">{{ $component->bodyOfWater->id}}</td>
        <td class="border px-1 py-1 ">{{ $component->bodyOfWater->name }}</td>
    @endif
    <td class="border px-1 py-1 ">{{ $component->id}}</td>
    <td class="border px-1 py-1 ">{{ $component->name}}</td>
    <td class="border px-1 py-1 ">{{ $component->installed_now ? 'Yes' : 'No'}}</td>
    <td class="border px-1 py-1 ">{{ $component->componentLocation->name}}</td>
    <td class="border px-1 py-1 ">{{ __('mfg by')}}</td>
    <td class="border px-1 py-1 ">{{ $component->model_number}}</td>
    <td class="border px-1 py-1 ">{{ $component->serial_number}}</td>

    @if($showActions)
        <td class="border px-1 py-1 flex">
            <a class="flex-1 w-1/2" href="{{route('body_of_water_edit',['bow_id' => $bow->id])}}" >
                <x-buttons.edit/></a>
            <a class="flex-1 w-1/2" href="{{route('body_of_water_show',['bow_id' => $bow->id])}}" >
                <x-buttons.view/></a>
        </td>
    @endif
</tr>
