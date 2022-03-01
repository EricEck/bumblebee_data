<div>
    {{-- Because she competes with no one, no one can compete with her. --}}


    <!-- Search Heading -->
    <div class="w-full flex pb-10">

        <div class="w-1/6 relative mx-1">
            <select wire:model="bumblebeeID" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="0" selected>All Bumblebees</option>
                @foreach($bumblebees as $bumblebee)
                    <option value="{{$bumblebee->id}}">{{ $bumblebee->serial_number }} (owner: {{ $bumblebee->owner->name }})</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
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
                <option value="all" selected>All Methods</option>
                <option value="auto">All Auto</option>
                <option value="man">All Manual</option>
                @foreach(\App\Models\Measurement::methodEnums() as $method)
                    <option value="{{ $method }}"> {{ $method }} </option>
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
        <div class="w-3/6 relative mx-1">
            <input wire:model.debounce.500ms="searchString" type="text"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   placeholder="Search...">
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
                <option value="seq" selected>Sequence</option>
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

            <table class="table-auto w-full mb-6">
                <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Timestamp</th>
                    <th class="px-4 py-2">Bumblebee</th>
                    <th class="px-4 py-2">Calibration</th>
                    <th class="px-4 py-2">Method</th>
                    <th class="px-4 py-2">Sequence</th>
                    <th class="px-4 py-2">Metric</th>
                    <th class="px-4 py-2">Value</th>
                    <th class="px-4 py-2">Unit</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($measurements as $measurement)
                    @php($bumblebee = $measurement->bumblebee)
                    @php($value = $measurement->val)
                    <tr>
                        <td class="border px-4 py-2">{{ $measurement->id }}</td>
                        <td class="border px-4 py-2 text-xs">{{ date('l',strtotime($measurement->measurement_timestamp)) }}<br>{{  date('d-m-Y',strtotime($measurement->measurement_timestamp)) }}<br>{{ date('h:m',strtotime($measurement->measurement_timestamp)) }}</td>
                        <td class="border px-4 py-2">{{ $bumblebee->serial_number }}</td>
                        <td class="border px-4 py-2">{{ $measurement->calibration_value ? 'Yes' : 'No' }}</td>
                        <td class="border px-4 py-2">{{ $measurement->method }}</td>
                        <td class="border px-4 py-2">{{ $measurement->metric_sequence }}</td>
                        <td class="border px-4 py-2">{{ $measurement->metric }}</td>
                        <td class="border px-4 py-2">{{ $measurement->valueDecodeTable() }}</td>
                        <td class="border px-4 py-2">{{ $measurement->unit }}</td>
                        <td class="border px-4 py-2 flex-auto">
                            <a wire:click=""  ><x-buttons.view ></x-buttons.view></a>
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
