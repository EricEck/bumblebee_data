<div>
    {{-- Do your work, then step back. --}}

    <div class="mt-10 sm:mt-0">
        <!-- Header Markup -->
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $create_new ? 'Add a New Manual Measurement' : 'Measurement for '.$measurement->metric }}</h3>
                    {{--                    <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>--}}
                </div>
            </div>
        </div>

        <!-- Content Markup -->
        <div class="mt-5 md:mt-0 md:col-span-6">

            <!--  Form Markup -->
            <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">

                <div class="shadow overflow-hidden sm:rounded-md">

                    <!-- Form Data -->
                    <div class="px-4 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="id" class="text-sm font-medium text-gray-700">Measurement ID</label>
                                <input type="number" name="id" id="id"
{{--                                       wire:model.lazy="measurement.id"--}}
                                       value="{{ $measurement->id }}"
                                       placeholder="{{ $create_new ?? '' ? 'Will be assigned after save' : '' }}"
                                       disabled
                                       autocomplete=""
                                       class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="bumblebee_id" class="block text-sm font-medium text-gray-700">Bumblebee</label>
                                <select name="bumblebee_id" id="bumblebee_id"
                                        wire:model.lazy="measurement.bumblebee_id"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
{{--                                    <option selected disabled>Select Bumblebee being used in Pool</option>--}}
                                    {{ $create_new ? '<option selected disabled>Select Bumblebee being used in for Pool</option>' : '' }}
                                    @foreach($bumblebees as $bumblebee)
                                        <option value="{{ $bumblebee->id }}">{{ $bumblebee->serial_number }} owner: ({{ $bumblebee->owner->name }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="measurement_timestamp" class="text-sm font-medium text-gray-700">Measurement Date</label>
                                <input type="datetime-local" name="measurement_timestamp" id="measurement_timestamp"
                                       wire:model.lazy="measurement_datetime"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       autofocus
                                       class="mt-1 px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="metric" class="block text-sm font-medium text-gray-700">Metric</label>
                                <select name="metric" id="metric"
                                        wire:model.lazy="measurement.metric"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value='' disabled>Select Metric---</option>
                                    @php($metrics = \App\Models\Measurement::metricEnums())
                                    @foreach($metrics as $metric)
                                        <option value="{{ $metric }}">{{ $metric }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="metric_sequence" class="text-sm font-medium text-gray-700">Metric Sequence <span class="text-xs">(automatically created)</span></label>
                                <input type="number" name="metric_sequence" id="metric_sequence"
                                       wire:model.lazy="measurement.metric_sequence"
                                       disabled
                                       placeholder="{{ $create_new ?? '' ? 'Will be assigned after save' : '' }}"
                                       class="px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="method" class="block text-sm font-medium text-gray-700">Method</label>
                                <select name="method" id="method"
                                        wire:model.lazy="measurement.method"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value='' disabled>Select Method---</option>
                                    @php($methods = \App\Models\Measurement::methodEnums())
                                    @foreach($methods as $method)
                                        <option {{ $measurement->isManualMethod($method) ? '' : 'disabled' }} value="{{ $method }}">{{ $method }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="process" class="text-sm font-medium text-gray-700">Measurement Process <span class="text-xs">(created automatically for Bumblebees)</span></label>
                                <textarea  name="process" id="process"
                                           wire:model.lazy="measurement.process"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           placeholder="{{ $create_new ?? '' ? 'describe the process' : '' }}"
                                           class="px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="value" class="text-sm font-medium text-gray-700">{{ $create_new ? 'Manual Measurment Value' : 'Raw Data Value <span class="text-xs">(calibrated in system)' }}</span></label>
                                <textarea type="text" name="value" id="value"
                                       wire:model.lazy="measurement.value"
                                       {{ $allow_edit ?  '' : 'disabled'}}
                                       class="px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="unit" class="block text-sm font-medium text-gray-700">Units</label>
                                <select name="unit" id="unit"
                                        wire:model.lazy="measurement.unit"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value='' disabled>Select Units---</option>
                                    @php($units = \App\Models\Measurement::unitEnums())
                                    @foreach($units as $unit)
                                        <option  value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2">
                                <label for="details" class="text-sm font-medium text-gray-700">Details/Notes <span class="text-xs">(not used for automatic data process)</span></label>
                                <textarea type="text" name="details" id="details"
                                          wire:model.lazy="measurement.details"
                                          {{ $allow_edit ?  '' : 'disabled'}}
                                          class="px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </textarea>
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-2 flex">
                                <label for="uncalibration_valueit" class="block text-sm font-medium text-gray-700">This is a Calibration Measurement</label>
                                <select name="calibration_value" id="calibration_value"
                                        wire:model.lazy="measurement.calibration_value"
                                        disabled
                                        class="mt-1 px-3 text-black  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value='0'>No</option>
                                    <option value='1'>Yes</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <!-- Only for Existing Measurements -->
                    @if(!$create_new)

                        <!-- Colorimetric Data -->
                        @if($measurement->colorimetricMethod())
                            <div class="mt-4 border py-2 bg-gray-200">

                                <div class="px-4 py-5 mt-2 ">
                                <h4 class="text-lg font-medium leading-6 text-gray-900">This Colorimetric Spectrum Data</h4>
                                <div class="w-1/6 relative mx-3 my-3">
                                    <select wire:model="scaledColorimetric"
                                            class="block appearance-none bg-indigo-50 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                        <option disabled>Colorimetric Data Scaling</option>
                                        <option value="0" selected>Raw Colorimetric</option>
                                        <option value="1">Scaled to Clear</option>
                                        <option value="2">Scaled to Peak</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>

                                <div class="border ml-1 px-1 py-2 text-xs">
                                    <p class="">Measurement ID: {{$measurement->id}}</p>
                                    <p class="">{{ date('l',strtotime($measurement->measurement_timestamp)) }} {{  date('m-d-Y',strtotime($measurement->measurement_timestamp)) }} at {{ date('g:i a',strtotime($measurement->measurement_timestamp)) }}</p>
                                </div>

                                <table class="table-auto w-full mb-6 bg-gray-50 mt-2">
                                    <thead>
                                    <tr>
                                        <th colspan="8" class="border bg-indigo-50">Visible Light Spectrum (nm)</th>
                                        <th class="border">Non Vis</th>
                                        <th class="border">Wideband</th>
                                    </tr>
                                    <tr>
                                        <th class=" border bg-indigo-50">VIO (415)</th>
                                        <th class=" border bg-indigo-50">IND (445)</th>
                                        <th class="border bg-indigo-50">BLU (490)</th>
                                        <th class=" border bg-indigo-50">CYN (525)</th>
                                        <th class="border bg-indigo-50">GRN (565)</th>
                                        <th class=" border bg-indigo-50">YLW (600)</th>
                                        <th class=" border bg-indigo-50">ORG (640)</th>
                                        <th class=" border bg-indigo-50">RED (690)</th>
                                        <th class=" border ">IRD (910)</th>
                                        <th class=" border ">CLEAR (all)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($colorValue = $measurement->valueDecodeColor($scaledColorimetric))
                                    <tr>
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
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                                <!-- Display Last Calibration Value -->
                                @if(!$measurement->calibration_value)
                                <div class="px-4 py-5 mt-4">
                                    <h4 class="text-lg font-medium leading-6 text-gray-900">Last Calibration Data (no reagents)</h4>
                                    @php($last_cal_measurement = $measurement->previousCalibrationMeasurement())
                                    <div class="border ml-1 px-1 py-2 text-xs hover:bg-gray-50">
                                        <a  href="{{route('measurementFormShow', ['measurement_id' => $last_cal_measurement->id])}}">
                                            <p class="">Measurement ID: {{$last_cal_measurement->id}}</p>
                                            <p class="">{{ date('l',strtotime($last_cal_measurement->measurement_timestamp)) }} {{  date('m-d-Y',strtotime($last_cal_measurement->measurement_timestamp)) }} at {{ date('g:i a',strtotime($last_cal_measurement->measurement_timestamp)) }}</p>
                                        </a>
                                    </div>

                                    <table class="table-auto w-full mb-6 bg-gray-50 mt-2">
                                        <thead>
                                        <tr>
                                            <th colspan="8" class="border bg-indigo-50">Visible Light Spectrum (nm)</th>
                                            <th class="border">Non Vis</th>
                                            <th class="border">Wideband</th>
                                        </tr>
                                        <tr>
                                            <th class=" border bg-indigo-50">VIO (415)</th>
                                            <th class=" border bg-indigo-50">IND (445)</th>
                                            <th class="border bg-indigo-50">BLU (490)</th>
                                            <th class=" border bg-indigo-50">CYN (525)</th>
                                            <th class="border bg-indigo-50">GRN (565)</th>
                                            <th class=" border bg-indigo-50">YLW (600)</th>
                                            <th class=" border bg-indigo-50">ORG (640)</th>
                                            <th class=" border bg-indigo-50">RED (690)</th>
                                            <th class=" border ">IRD (910)</th>
                                            <th class=" border ">CLEAR (all)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($colorValue = $last_cal_measurement->valueDecodeColor($scaledColorimetric))
                                        <tr>
                                            <!-- Color Spectrum -->
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->violet }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->indigo }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->blue  }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->cyan }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->green }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->yellow }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->orange  }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->red  }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->nearIR  }}</td>
                                            <td class="border px-1 py-2 text-xs">{{ $colorValue->clear  }}</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            @endif

                            </div>
                        @endif

                        <!-- Last Manual Method Data -->
                        <div class="mt-4 border px-2 py-2 bg-gray-200">
                        <h4 class="py-4 text-lg font-medium leading-6 text-gray-900">Nearest Manual Measurements</h4>
                        @php($last_man_measurement = $measurement->previousManualMeasurement())
                        @if(isset($last_man_measurement))
                            <table class="table-auto w-full mb-6 bg-gray-50">
                                <thead>
                                <tr>
                                    <th colspan="7"></th>

                                    <th class="border bg-blue-100">Probe</th>
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
                                    <th class=" bg-indigo-50">Actual</th>
                                    <th class=" bg-indigo-50">Unit</th>
                                    <th class="">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->id }}</td>
                                        <td class="border px-1 py-2 text-xs">{{ date('l',strtotime($last_man_measurement->measurement_timestamp)) }}<br>{{  date('m-d-Y',strtotime($last_man_measurement->measurement_timestamp)) }}<br>{{ date('g:i a',strtotime($last_man_measurement->measurement_timestamp)) }}</td>
                                        <td class="border px-1 py-2 font-thin text-xs text-center hover:bg-gray-50">
                                            <a  href="{{route('bumblebeeFormShow', ['bumblebee_id' => $last_man_measurement->bumblebee->id])}}">
                                                <b>{{ $last_man_measurement->bumblebee->serial_number }}</b><br>({{ $last_man_measurement->bumblebee->owner->name }})
                                            </a>
                                        </td>
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->calibration_value ? 'Yes' : 'No' }}</td>
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->method }}</td>
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->metric_sequence }}</td>
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->metric }}</td>

                                        <!-- Calibrated or Manual Number -->
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->manualMethod() ? $last_man_measurement->valueDecodeNumber() : '' }}</td>
                                        <td class="border px-1 py-2 text-xs">{{ $last_man_measurement->unit }}</td>
                                        <td class="border px-1 py-2 flex-auto">
                                            <a href="{{route('measurementFormShow', ['measurement_id' => $last_man_measurement->id])}}"><x-buttons.view ></x-buttons.view></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <p class="px-4 py-5 font-bold text-red-700">No Previous Manual Measurement Available</p>
                        @endif

                        @php($next_man_measurement = $measurement->nextManualMeasurement())
                        @if(isset($next_man_measurement))
                            <table class="table-auto w-full mb-6 bg-gray-50">
                                <thead>
                                <tr>
                                                                        <th colspan="7"></th>

                                                                        <th class="border bg-blue-100">Probe</th>
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
                                    <th class=" bg-indigo-50">Actual</th>
                                    <th class=" bg-indigo-50">Unit</th>
                                    <th class="">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->id }}</td>
                                    <td class="border px-1 py-2 text-xs">{{ date('l',strtotime($next_man_measurement->measurement_timestamp)) }}<br>{{  date('m-d-Y',strtotime($next_man_measurement->measurement_timestamp)) }}<br>{{ date('g:i a',strtotime($next_man_measurement->measurement_timestamp)) }}</td>
                                    <td class="border px-1 py-2 font-thin text-xs text-center hover:bg-gray-50">
                                        <a  href="{{route('bumblebeeFormShow', ['bumblebee_id' => $next_man_measurement->bumblebee->id])}}">
                                            <b>{{ $next_man_measurement->bumblebee->serial_number }}</b><br>({{ $next_man_measurement->bumblebee->owner->name }})
                                        </a>
                                    </td>
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->calibration_value ? 'Yes' : 'No' }}</td>
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->method }}</td>
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->metric_sequence }}</td>
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->metric }}</td>

                                    <!-- Calibrated or Manual Number -->
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->manualMethod() ? $next_man_measurement->valueDecodeNumber() : '' }}</td>
                                    <td class="border px-1 py-2 text-xs">{{ $next_man_measurement->unit }}</td>
                                    <td class="border px-1 py-2 flex-auto">
                                        <a href="{{route('measurementFormShow', ['measurement_id' => $next_man_measurement->id])}}"><x-buttons.view ></x-buttons.view></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <p class="px-4 py-5  font-bold text-red-700">No Subsequent Manual Measurement Available</p>
                        @endif

                    </div>

                    @endif


                    <!-- Process Buttons -->
                    <div class="flow-root mt-6 items-center">

                        @if($allow_edit ?? '')
                            <div class="float-right">
                                <x-buttons.save></x-buttons.save>
                            </div>
                            <div class="float-right">
                                <x-buttons.reset>Reset</x-buttons.reset>
                            </div>
                        @endif
                        <div class="float-left">
                            <a href="javascript:history.back()"><x-buttons.back></x-buttons.back></a>
                        </div>
                    </div>

                </div>

            </form>


            <!-- Errors Display Markup -->
            @if ($errors->any())
                <div class="bg-gray-100 py-8 px-8">
                    <h1 class="text-7xl py-4">ERROR(s)</h1>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="px-10">==> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

    </div>

</div>
