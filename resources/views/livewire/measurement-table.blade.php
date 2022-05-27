<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    <!-- Search Headings Row 1-->
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
            <select wire:model.lazy="method" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="all" >All Methods</option>
                <option value="auto">All Auto</option>
                <option value="man">All Manual</option>
                @if(!$actualOnly)
                    @foreach(\App\Models\Measurement::methodEnums() as $methods)
                        <option value="{{ $methods }}"> {{ $methods }} </option>
                    @endforeach
                @endif
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        @if(!$actualOnly)
            <div class="w-1/6 relative mx-1">
                <select wire:model="types" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option disabled>Types of Measurements to view---</option>
                    <option value="0" selected>Raw Measurements</option>
                    <option value="1">Raw Calibrations</option>
                    <option value="2">Both Raw Meas & Cal</option>
                    <option value="3">Only Actual Values</option>
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
        @endif

        <!-- Table Actions -->
        <div class="w-1/6 pt-0.5 pl-1 flex bg-blue-300 border border-1 border-blue-500 shadow-gray-500 shadow-md">
            <div class="w-1/3 relative">
                <a wire:click="excel">
                    <x-buttons.excel>CSV</x-buttons.excel>
                </a>
            </div>
            <div class="w-1/3 relative ">
                <a wire:click="measurementFormNew()">
                    <x-buttons.new>New</x-buttons.new>
                </a>
            </div>
            <div class="w-1/3 relative">
                <a wire:click="calibrateMeasurements"
{{--                   x-data="{showCalibrationButton: true}"--}}
{{--                   x-show="showCalibrationButton"--}}
{{--                   x-init="@this.on('hideCalibrationButton',() => { showCalibrationButton = false; setTimeout(() => { showCalibrationButton = true; },5000);  })" --}}
                >
                    <x-buttons.calculate>Cal</x-buttons.calculate>
                </a>
                <div class="font-bold text-xs text-blue-700 text-center bg-gray-200 py-4"
                     x-data="{showCalibrating: false}"
                     x-show="showCalibrating"
                     x-transition.opacity.out.duration.250ms
                     x-init="@this.on('calibrating',() => { showCalibrating = true; setTimeout(() => { showCalibrating = false; },1000);  })"
                     style="display: none">
                    Updating Calibrations...
            </div>

            <div class="font-bold w-full text-xs text-green-700 text-center bg-gray-200 py-4"
                 x-data="{doneCalibrating: false}"
                 x-show="doneCalibrating"
                 x-transition.opacity.out.duration.750ms
                 x-init="@this.on('calibrationComplete',() => { doneCalibrating = true; setTimeout(() => { doneCalibrating = false; },3000);  })"
                 style="display: none">
                Calibrations Complete!
            </div>
        </div>
        </div>

    </div>

    <!-- Search Headings Row 2-->
    <div class="w-full flex pb-10">
        <div class="w-2/6 relative mx-1 flex">
            <label for="start_datetime"
                   class="appearance-none block w-1/4 text-gray-700 py-3 px-2 leading-tight"
            >Starting Date</label>
            <input wire:model="start_datetime" type="datetime-local" id="start_datetime"
                   class="appearance-none block w-3/4 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            >
        </div>
        <div class="w-2/6 relative mx-1 flex">
            <label for="end_datetime"
                   class="appearance-none block w-1/4 text-gray-700 py-3 px-2 leading-tight"
            >Ending Date</label>
            <input wire:model="end_datetime" type="datetime-local" id="end_datetime"
                   class="appearance-none block w-3/4 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
    </div>

    <!-- Returned Table Data -->
    @if(count($measurements))

        <table class="table-auto w-full mb-6 bg-gray-50">

            <x-measurement-table-header :show-actions="1" :method="$method" :types="$types"></x-measurement-table-header>
            <tbody>
                @foreach($measurements as $measurement)
                    <x-measurement-table-row :measurement="$measurement" :method="$method" :types="$types" :show-actions="1" :scaled-colorimetric="$scaledColorimetric"></x-measurement-table-row>

{{--                    @php(Debugbar::info($measurement->attributesToArray()))--}}
                @endforeach
            </tbody>
        </table>

        {!! $measurements->links() !!}

    @else
        <p class="text-center">Sorry!   We need a recount... No Measurements found...   😿</p>
    @endif


</div>
