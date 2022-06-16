@props(['measurement', 'showActions' => 0, 'method' => 'all', 'scaledColorimetric' => 0, 'types' => 0])

@php($bumblebee = $measurement->bumblebee)
@php($owner = $measurement->bumblebee->owner())
@php($value = $measurement->val)
<tr>
    <td class="border px-1 py-2 text-xs">{{ $measurement->id }}</td>
    <td class="border px-1 py-2 text-xs">{{ date('l',strtotime($measurement->measurement_timestamp)) }}<br>{{  date('m-d-Y',strtotime($measurement->measurement_timestamp)) }}<br>{{ date('g:i a',strtotime($measurement->measurement_timestamp)) }}</td>
    <td class="border px-1 py-2 font-thin text-xs text-center">
        <a href="{{route('bumblebeeFormShow', ['bumblebee_id' => $bumblebee->id])}}">
            <b>{{ $bumblebee->serial_number }}</b><br>({{ $bumblebee->owner->name }})
        </a>
    </td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->bodies_of_water_id ? $measurement->bodies_of_water_id : '--' }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->calibration_value ? 'Yes' : 'No' }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->method }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->metric_sequence }}</td>
    <td class="border px-1 py-2 text-xs">{{ $measurement->metric }}</td>

@php( $colorValue = $measurement->valueDecodeColor($scaledColorimetric) )
@if(($method == "all" | $method == "auto" | $method == "colorimetric")  && $types < 3 )
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
{{--        <td class="text-blue-700 border border-l-4 border-r-4 px-1 py-2 text-xs">{{ $measurement->spectralSummation() }}</td>--}}
        <td class="text-blue-700 border border-r-4 border-r-4 px-1 py-2 text-xs">{{ $measurement->colorimetricMethod() && !$measurement->manualMethod() & !$measurement->calibration_value ? $measurement->metricColorimetryValue() : ''}}</td>
@endif
@if(($method == "all" | $method == "auto" | $method == "probe" | $method == "") && $types < 3)
    <!-- Probe Value -->
        <td class="border px-1 py-2 text-xs">{{ $measurement->probeMethod() ? round($measurement->valueDecodeNumber(),3) : '' }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->probeMethod() ? $measurement->unit : ''}}</td>
@endif
<!-- Calibrated or Manual Number -->

    @if($measurement->isManualMethod())
        <!-- Manual Value -->
        <td class="border px-1 py-2 text-xs"></td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->valueDecodeNumber() }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->unit }}</td>
    @else
        <!-- Calibration Value -->
        <td class="border px-1 py-2 text-xs text-center border-r-green-100">{{ $measurement->calibration_id && !$measurement->calibration_value ? $measurement->calibration_id : ''   }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->calibration_id && !$measurement->calibration_value ? round($measurement->calibrated_value, 2) : ''  }}</td>
        <td class="border px-1 py-2 text-xs">{{ $measurement->calibration_id && !$measurement->calibration_value ? $measurement->calibrated_unit : '' }}</td>
    @endif

    @if($showActions)
        <td class="border px-1 py-2 flex-auto">
            <a wire:click="measurementFormShow({{ $measurement->id }})"><x-buttons.view>View</x-buttons.view></a>
            @if(!($measurement->isManualMethod() || $measurement->calibration_value))
                @if($measurement->calibration_id == 0)
                    <a wire:click="calibrationFormNew({{ $measurement->id }})"><x-buttons.calibration>Cal</x-buttons.calibration></a>
                @else
                    <a wire:click="calibrationFormExisting({{ $measurement->id }})"><x-buttons.calibration>Re-Cal</x-buttons.calibration></a>
                @endif
            @endif
        </td>
    @endif
</tr>
