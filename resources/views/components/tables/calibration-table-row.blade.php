@props(['calibration' => new \App\Models\Calibration(), 'showActions' => 0])

<tr class="text-xs">
    <td class="border px-1 py-1">{{ $calibration->id }}</td>
    <td class="border px-1 py-1">{{ $calibration->effective ? 'Yes' : 'No' }}</td>
    <td class="border px-1 py-1">{{ $calibration->effective_timestamp }}</td>
    <td class="border px-1 py-1">{{ $calibration->bumblebee->id }}</td>
    <td class="border px-1 py-1 lg:table-cell hidden">{{ $calibration->bumblebee->bodyOfWater() ? $calibration->bumblebee->bodyOfWater()->id : '--' }}</td>
{{--    <td class="border px-1 py-1 md:table-cell hidden">{{ $calibration->calibratedMeasurements->count() }}</td>--}}
{{--    <td class="border px-1 py-1 md:table-cell hidden">{{ $calibration->effectedMeasurements()->count() }}</td>--}}
    <td class="border px-1 py-1 ">{{ $calibration->metric }}</td>
    <td class="border px-1 py-1 ">{{ $calibration->method }}</td>
    <td class="border px-1 py-1 lg:table-cell hidden">{{ $calibration->default_output_units }}</td>
    <td class="border px-1 py-1 lg:table-cell hidden">{{$calibration->slope_m}}</td>
    <td class="border px-1 py-1 lg:table-cell hidden">{{$calibration->offset_b}}</td>

    @if($showActions)
        <td class="border px-1 py-1 flex flex-row justify-between">
            <x-buttons.edit
                wire:click.debounce="editCalibration({{$calibration->id}})"/>
            <x-buttons.delete
                wire:click.debounce="removeCalibration({{$calibration->id}})"/>
            <x-buttons.calibration
                wire:click.debounce="runCalibration({{$calibration->id}})"/>
        </td>
    @endif
</tr>
