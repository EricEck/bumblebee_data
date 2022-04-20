@props(['showActions' => 0, 'bumblebee' => new \App\Models\Bumblebee()])
@php($lastMeasurement = $bumblebee->measurements->last())
<tr>
    <td class="border px-4 py-2">{{ $bumblebee->id }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->serial_number }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->manufactured_date }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->current_version }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->ellipticProduct ? 'Yes' : 'No' }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->owner ? $bumblebee->owner->name : '--' }}</td>
    <td class="border px-4 py-2">{!! $bumblebee->removed_from_service  !!}</td>
    <td class="border px-4 py-2">{{ $bumblebee->bodyOfWater() ? $bumblebee->bodyOfWater()->name : 'None' }}</td>
    <td class="border px-4 py-2">{{ empty($lastMeasurement) ? 'No Measurements' : $lastMeasurement->created_at->diffForHumans() }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->updated_at->diffForHumans() }}</td>
    <td class="border px-4 py-2">{{ $bumblebee->created_at->diffForHumans() }}</td>

    @if($showActions)
        <td class="border px-4 py-2 flex">

            @if(!empty($lastMeasurement))
                <a class="flex-1 w-1/3" href="{{ route('measurements_bumblebee',['bumblebee_id' => $bumblebee->id]) }}" >
                    <x-buttons.measurement/></a>
            @endif
            <a class="flex-1 w-1/3" wire:click="bumblebeeFormShow({{ $bumblebee->id }})"  >
                <x-buttons.view/></a>
            <a class="flex-1 w-1/3" wire:click="bumblebeeFormEdit({{ $bumblebee->id }})"  >
                <x-buttons.edit/></a>
        </td>
    @endif
</tr>
