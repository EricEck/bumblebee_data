@props(['showActions' => 0, 'ellipticProduct' => new \App\Models\EllipticProduct()])

<tr class="text-xs">
    <td class="border px-1 py-1 ">{{ $ellipticProduct->id}}</td>
    <td class="border px-1 py-1 ">{{ $ellipticProduct->ellipticModel ? $ellipticProduct->ellipticModel->name : '--'}}</td>
    @if($ellipticProduct->bumblebee)
        <td class=" px-1 py-1 flex">
            <a href="{{route('bumblebeeFormEdit', [$ellipticProduct->bumblebee_id])}}">
                <x-buttons.edit class="float-left" /></a>
            <a href="{{route('bumblebeeFormShow', [$ellipticProduct->bumblebee_id])}}">
                <x-buttons.view class="float-right"/></a>
        </td>
    @else
        <td class="border px-1 py-1 ">No</td>
    @endif

    @if($ellipticProduct->bumblebee)
        <td class="border px-1 py-1 ">{{ $ellipticProduct->bumblebee->serial_number}}</td>
        <td class="border px-1 py-1 ">{{ $ellipticProduct->bumblebee->manufactured_date}}</td>
    @else
        <td class="border px-1 py-1 ">{{ $ellipticProduct->serialNumber()}}</td>
        <td class="border px-1 py-1 ">{{ $ellipticProduct->manufactured_on}}</td>
    @endif
    <td class="border px-1 py-1 ">{{ $ellipticProduct->ellipticManufacturer ? $ellipticProduct->ellipticManufacturer->name : '--'}}</td>

    @if($ellipticProduct->owner())
        <td class="border px-1 py-1 ">{{ $ellipticProduct->owner()->name }}</td>
    @else
        <td class="border px-1 py-1 ">Not Assigned</td>
    @endif

    @if($ellipticProduct->bodyOfWater)
        <td class=" px-1 py-1 flex flex-auto">
            <span class="flex-auto -mt-8">{{ $ellipticProduct->bodyOfWater->name }}</span>
            <a class="flex-auto -mt-10" href="{{route('body_of_water_show', ['bow_id' => $ellipticProduct->bodyOfWater->id])}}">
                <x-buttons.view/></a>
        </td>
    @else
        <td class="border px-1 py-1 ">No Assigned</td>
    @endif
    <td class="border px-1 py-1 ">{{ $ellipticProduct->current_construction_version}}</td>
    <td class="border px-1 py-1 ">{{ $ellipticProduct->current_software_version}}</td>

    @if($showActions)
        <td class=" px-1 py-1 flex">
            <a class="flex-1 w-1/2" href="{{route('elliptic_product_edit',['id' => $ellipticProduct->id])}}" >
                <x-buttons.edit/></a>
            <a class="flex-1 w-1/2" href="{{route('elliptic_product_show',['id' => $ellipticProduct->id])}}" >
                <x-buttons.view/></a>
        </td>
    @endif
</tr>
