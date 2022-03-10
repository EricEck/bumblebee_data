@props(['measurement', 'showActions' => 0, 'method' => 'all', 'scaledColorimetric' => 0])

@php($bumblebee = $measurement->bumblebee)
@php($owner = $measurement->bumblebee->owner)
@php($value = $measurement->val)
<tr>
    <td class="border px-1 py-2 text-xs">{{ $measurement->id }}</td>
    <td class="border px-1 py-2 text-xs">{{ date('l',strtotime($measurement->measurement_timestamp)) }}<br>{{  date('m-d-Y',strtotime($measurement->measurement_timestamp)) }}<br>{{ date('g:i a',strtotime($measurement->measurement_timestamp)) }}</td>
    <td class="border px-1 py-2 font-thin text-xs text-center">
        <a href="{{route('bumblebeeFormShow', ['bumblebee_id' => $bumblebee->id])}}">
            <b>{{ $bumblebee->serial_number }}</b><br>({{ $owner->name }})
        </a>
    </td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->calibration_value ? 'Yes' : 'No' }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->method }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->metric_sequence }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->metric }}</td>
@php( $colorValue = $measurement->valueDecodeColor($scaledColorimetric) )
@if($method == "all" | $method == "auto" | $method == "colorimetric" )
    <!-- Color Spectrum -->
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->violet : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->indigo : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->blue : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->cyan : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->green : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->yellow : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->orange : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->red : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->nearIR : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() ?$colorValue->clear : ''  }}</td>
@endif
@if($method == "all" | $method == "auto" | $method == "probe" | $method == "")
    <!-- Probe Value -->
        <td class="border px-1 py-2 text-xs">{{ $measurement->probeMethod() ? round($measurement->valueDecodeNumber(),3) : '' }}</td>
@endif
<!-- Calibrated or Manual Number -->
    <td class="border px-1 py-2 text-xs">{{ $measurement->manualMethod() ? $measurement->valueDecodeNumber() : '' }}</td>

    <td class="border px-1 py-2 text-xs">{{ $measurement->unit }}</td>
    @if($showActions)
        <td class="border px-1 py-2 flex-auto">
            <a wire:click="measurementFormShow({{ $measurement->id }})"><x-buttons.view ></x-buttons.view></a>
            @if(!($measurement->isManualMethod() || $measurement->calibration_value))
                <a wire:click="calibrationFormNew({{ $measurement->id }})"><x-buttons.calibration></x-buttons.calibration></a>
            @endif
        </td>
    @endif
</tr>