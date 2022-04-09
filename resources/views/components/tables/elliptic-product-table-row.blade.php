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
        <td class="border px-1 py-1 ">{{ $ellipticProduct->serial_number}}</td>
        <td class="border px-1 py-1 ">{{ $ellipticProduct->manufactured_on}}</td>
    @endif
    <td class="border px-1 py-1 ">{{ $ellipticProduct->ellipticManufacturer ? $ellipticProduct->ellipticManufacturer->name : '--'}}</td>

    @if($ellipticProduct->owner)
        <td class="border px-1 py-1 ">{{ $ellipticProduct->owner->name }}</td>
    @else
        <td class="border px-1 py-1 "><x-buttons.new/></td>
    @endif

    <td class="border px-1 py-1 "><x-buttons.new/></td>
    <td class="border px-1 py-1 ">{{ $ellipticProduct->current_construction_version}}</td>
    <td class="border px-1 py-1 ">{{ $ellipticProduct->current_software_version}}</td>

    @if($showActions)
        <td class="border px-1 py-1 flex">
            <a class="flex-1 w-1/2" href="{{route('elliptic_product_edit',['id' => $ellipticProduct->id])}}" >
                <x-buttons.edit/></a>
            <a class="flex-1 w-1/2" href="{{route('elliptic_product_show',['id' => $ellipticProduct->id])}}" >
                <x-buttons.view/></a>
        </td>
    @endif
</tr>
