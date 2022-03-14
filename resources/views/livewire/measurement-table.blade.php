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
        <div class="w-1/12 relative mx-1">
            <a wire:click="excel"><x-buttons.excel></x-buttons.excel></a>
        </div>
        <div class="w-1/12 relative px-6">
            <a wire:click="measurementFormNew()"><x-buttons.new></x-buttons.new></a>
        </div>
    </div>
    <!-- Search Headings Row 2-->
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

    </div>

    <!-- Returned Table Data -->
    @if(count($measurements))

        <table class="table-auto w-full mb-6 bg-gray-50">

            <x-measurement-table-header :show-actions="1" :method="$method"></x-measurement-table-header>

            <tbody>
            @foreach($measurements as $measurement)
                <x-measurement-table-row :measurement="$measurement" :method="$method" :show-actions="1" :scaled-colorimetric="$scaledColorimetric"></x-measurement-table-row>
            @endforeach
            </tbody>
        </table>
        {!! $measurements->links() !!}

    @else
        <p class="text-center">Sorry!   We need a recount... No Measurements found...   😿</p>
    @endif


</div>
