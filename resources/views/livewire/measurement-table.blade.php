<div>
    {{-- Because she competes with no one, no one can compete with her. --}}


    <!-- Search Heading -->
    <div class="w-full flex pb-10">

        <div class="w-1/6 relative mx-1">

            @if(isset($bumblebee_select))
                <div class="block text-xs appearance-none w-full bg-blue-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight" id="grid-state">
                    <b>{{ $bumblebee_select->serial_number}}</b><br>owned by {{ $bumblebee_select->owner->name }}
                </div>
            @else
                <select wire:model="bumblebeeID" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="0" selected>All Bumblebees</option>
                    @foreach($bumblebees as $bumblebee)
                        <option value="{{$bumblebee->id}}">{{ $bumblebee->serial_number }} (owner: {{ $bumblebee->owner->name }})</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            @endif
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="metric" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="all" selected>All Metrics</option>
                @foreach(\App\Models\Measurement::metricEnums() as $metric)
                    <option value="{{ $metric }}"> {{ $metric }} </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="method" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="all" >All Methods</option>
                <option value="auto">All Auto</option>
                <option value="man">All Manual</option>
                @foreach(\App\Models\Measurement::methodEnums() as $methods)
                    <option value="{{ $methods }}"> {{ $methods }} </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="types" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="0" selected>Measurements</option>
                <option value="1">Calibrations</option>
                <option value="2">Both Meas & Cal</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1 ">
            <select wire:model="scaledColorimetric" class="block appearance-none w-full bg-indigo-50 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option disabled>Colorimetric Data Scaling</option>
                <option value="0" selected>Raw Colorimetric</option>
                <option value="1">Scaled to Clear</option>
                <option value="2">Scaled to Peak</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/12 relative px-6">
            <a wire:click="measurementFormNew()"><x-buttons.new></x-buttons.new></a>
        </div>
    </div>

    <div class="w-full flex pb-10">

        <div class="w-2/6 relative mx-1 flex">
            <label for="start_datetime"
                   class="appearance-none block w-0.5 text-gray-700 py-3 px-2 leading-tight"
            >Starting</label>
            <input wire:model="start_datetime" type="datetime-local" id="start_datetime"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            >
        </div>
        <div class="w-2/6 relative mx-1 flex">
            <label for="end_datetime"
                   class="appearance-none block w-0.5 text-gray-700 py-3 px-2 leading-tight"
            >Ending</label>
            <input wire:model="end_datetime" type="datetime-local" id="end_datetime"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            >
        </div>

        <div class="w-1/6 relative mx-1">
            <select wire:model="sort_by" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option disabled>Sort by</option>
                <option value="seq">Sequence</option>
                <option value="time">Timestamp</option>
                <option value="id">ID</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderAscending" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option disabled>Order in</option>
                <option value="asc">Ascending</option>
                <option value="desc" selected>Descending</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="measurementsPerPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option disabled>Show Per Page</option>
                <option selected>10</option>
                <option>15</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>

{{--        <div class="w-1/6 mx-1 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">--}}
{{--            <label for="measurementMetric">Measurements</label>--}}
{{--            <input name="measurementMetric" id="measurementMetric" type="checkbox"--}}
{{--                   wire:model="measurementMetric">--}}
{{--        </div>--}}
{{--        <div class="w-1/6 mx-1 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">--}}
{{--            <label for="calibrationMetric">Calibrations</label>--}}
{{--            <input name="calibrationMetric" id="calibrationMetric" type="checkbox"--}}
{{--                   wire:model="calibrationMetric">--}}
{{--        </div>--}}
    </div>

    <!-- Return Data -->
    @if(count($measurements))

        <table class="table-auto w-full mb-6 bg-gray-50">
            <thead>
            <tr>
                <th colspan="7"></th>

                @if($method == "all" | $method == "auto" | $method == "colorimetric" )
                    <th colspan="10" class="border bg-indigo-50">COLORIMETRIC DATA</th>
                @endif
                @if($method == "all" | $method == "auto" | $method == "probe" | $method == "")
                    <th class="border bg-blue-100">Probe</th>
                @endif
                <th colspan="2" class="border bg-gray-200 text-xs">MEASUREMENT</th>

                <th></th>
            </tr>
            <tr>
                <th class="">ID</th>
                <th class="">Time<br>Stamp</th>
                <th class="">BB<br>Unit</th>
                <th class="">Cal?</th>
                <th class="">Method</th>
                <th class="">Seq</th>
                <th class="">Metric</th>
                @if($method == "all" | $method == "auto" | $method == "colorimetric" )
                    <th class=" bg-indigo-50">VIO</th>
                    <th class=" bg-indigo-50">IND</th>
                    <th class=" bg-indigo-50">BLU</th>
                    <th class=" bg-indigo-50">CYN</th>
                    <th class=" bg-indigo-50">GRN</th>
                    <th class=" bg-indigo-50">YLW</th>
                    <th class=" bg-indigo-50">ORG</th>
                    <th class=" bg-indigo-50">RED</th>
                    <th class=" bg-indigo-50">IRD</th>
                    <th class=" bg-indigo-50">CLEAR</th>
                @endif
                @if($method == "all" | $method == "auto" | $method == "probe" | $method == "")
                    <th class=" bg-blue-100">VOLT</th>
                @endif
                <th class=" bg-gray-200">Actual</th>
                <th class=" bg-gray-200">Unit</th>
                <th class="">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($measurements as $measurement)
                @php($bumblebee = $measurement->bumblebee)
                @php($owner = $bumblebee->owner)
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
                    <td class="border px-1 py-2 flex-auto">
                        <a wire:click="measurementFormShow({{ $measurement->id }})"><x-buttons.view ></x-buttons.view></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $measurements->links() !!}

    @else
        <p class="text-center">Sorry!   We need a recount... No Measurements found...   😿</p>
    @endif


</div>
