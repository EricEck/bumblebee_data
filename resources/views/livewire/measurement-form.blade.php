<x-forms.form>

    <x-slot name="form_title">
        {{ $create_new ? 'New' : ($allow_edit ? 'Edit' : 'Information about ') }} Measurement
    </x-slot>

    <!--Message Event Handler -->
    <div class="font-extrabold text-xl text-green-700"
         x-data="{show: false}"
         x-show="show"
         x-transition.opacity.out.duration.1500ms
         x-init="@this.on('message',() => { show = true; setTimeout(() => { show = false; },2000);  })"
         style="display: none">
        {{$message}}
    </div>

    <!-- Top Process Buttons -->
    <div class="flex flex-row items-end mt-4 mb-1">
        <div class="basis-1/3">
                                    @if(!$changed && $showBack)
                                        <a href="javascript:window.history.back()">
                                            <x-buttons.back>Back</x-buttons.back>
                                        </a>
                                    @endif
        </div>
        <div class="basis-1/3">
            @if($changed)
                <a wire:click.debounce.500ms="discard">
                    <x-buttons.close>Discard Changes</x-buttons.close>
                </a>
            @endif
        </div>
        <div class="basis-1/3">
            @if($allow_edit && $changed && $readyToSave)
                <a wire:click.debounce.500ms="save">
                    <x-buttons.save>Save</x-buttons.save>
                </a>
            @endif
        </div>
    </div>

    <!--  Form Markup -->
    <form onkeydown="return event.key !== 'Enter';">



        <!-- Fields Markup -->
        <div class="shadow overflow-hidden sm:rounded-md">

            @if($measurement->id > 0)
                <x-forms.field-display-only
                    label="Measurement ID"
                    value="{{ $measurement->id }}"/>
            @endif

            <x-forms.field-input-select-start
                label="Body of Water"
                model-method="bow_id"
                change-method="changed"
                explanation="which body of water was measured"
                select-heading="-- Select Body of Water "
                allow-edit={{$allow_edit}} />

            @foreach($bodiesOfWater as $bodyOfWater)
                <option value="{{ $bodyOfWater->id }}">{{ $bodyOfWater->name }}, (owner: {{ $bodyOfWater->owner->name }})</option>
            @endforeach

            <x-forms.field-input-select-end
                explanation="which body of water was measured"/>

            <x-forms.field-input-select-start
                label="Bumblebee"
                model-method="measurement.bumblebee_id"
                change-method="changed"
                explanation="which Bumblebee is also in body of water"
                select-heading="-- Select Bumblebee "
                allow-edit={{$allow_edit}} />

            @foreach($bumblebees as $bumblebee)
                <option value="{{ $bumblebee->id }}">{{ $bumblebee->serial_number }} owner: ({{ $bumblebee->owner()->name }})</option>
            @endforeach

            <x-forms.field-input-select-end
                explanation="which Bumblebee is also in body of water"/>

            <x-forms.field-input-timestamp
                label="Measurement Date"
                model-method="measurement_datetime"
                change-method="changed"
                explanation="exact time of measurement"
                allow-edit={{$allow_edit}} />

            <x-forms.field-input-select-start
                label="Metric"
                model-method="measurement.metric"
                change-method="changed"
                explanation="which metric was measured"
                select-heading="-- Select Metric"
                allow-edit={{$allow_edit}} />

            @foreach($metrics as $metric)
                <option value="{{ $metric }}">{{ $metric }}</option>
            @endforeach

            <x-forms.field-input-select-end
                explanation="which metric was measured"/>

            @if($measurement->id > 0)
                <x-forms.field-display-only
                    label="Metric's Sequence"
                    value="{{ $measurement->metric_sequence }}"/>
            @endif

            <x-forms.field-input-select-start
                label="Method"
                model-method="measurement.method"
                change-method="changed"
                explanation="how the metric was measured"
                select-heading="-- Select Method"
                allow-edit={{$allow_edit}} />

            @foreach($methods as $method)
                <option {{ $measurement->isManualMethod($method) ? '' : 'disabled' }} value="{{ $method }}">{{ $method }}</option>
            @endforeach

            <x-forms.field-input-select-end
                explanation="how the metric was measured"/>

            <x-forms.field-input-textarea
                label="{{ $create_new ? 'Manual Value' : 'Raw Data Value' }}"
                model-method="measurement.value"
                change-method="changed"
                explanation=""
                placeholder="enter numeric value of measurement..."
                allow-edit={{$allow_edit}} />

            <x-forms.field-input-select-start
                label="Units"
                model-method="measurement.unit"
                change-method="changed"
                explanation="select matching unit to measurement"
                select-heading="-- Select Units"
                allow-edit={{$allow_edit}} />

            @foreach($units as $unit)
                <option  value="{{ $unit }}">{{ $unit }}</option>
            @endforeach

            <x-forms.field-input-select-end
                explanation="select matching unit to measurement"/>


            <x-forms.field-input-textarea
                label="{{ $create_new ? 'Manual Process' : 'Bumblebee Process' }}"
                model-method="measurement.process"
                change-method="changed"
                explanation=""
                placeholder="describe the process used to acquire measurement..."
                allow-edit={{$allow_edit}} />

            <x-forms.field-input-textarea
                label="Details/Notes"
                model-method="measurement.details"
                change-method="changed"
                explanation=""
                placeholder="any information about the taking of the measurement or observations..."
                allow-edit={{$allow_edit}} />

            <x-forms.field-input-select-start
                label="Is Calibration Measurement?"
                model-method="measurement.calibration_value"
                change-method="changed"
                explanation="yes for all manual measurements"
                select-heading=""
                allow-edit="false"/>

            <option value='0'>No</option>
            <option value='1'>Yes</option>

            <x-forms.field-input-select-end
                explanation="yes for all manual measurements"/>

        </div>

    </form>

    <!-- Errors Display Markup -->
    @if ($errors->any())
        <x-form-error-block :errors="$errors"/>
    @endif


    <!-- Bottom Process Buttons -->
    <div class="flex flex-row items-end mt-4 mb-1">
        <div class="basis-1/3">
            @if(!$changed && $showBack)
                <a href="javascript:window.history.back()">
                    <x-buttons.back>Back</x-buttons.back>
                </a>
            @endif
        </div>
        <div class="basis-1/3">
            @if($changed)
                <a wire:click.debounce.500ms="discard">
                    <x-buttons.close>Discard Changes</x-buttons.close>
                </a>
            @endif
        </div>
        <div class="basis-1/3">
            @if($allow_edit && $changed && $readyToSave)
                <a wire:click.debounce.500ms="save">
                    <x-buttons.save>Save</x-buttons.save>
                </a>
            @endif
        </div>
    </div>

    <!-- Reference Information Only for Existing Measurements -->
    <x-slot name="reference-information">

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
                                    <b>{{ $last_man_measurement->bumblebee->serial_number }}</b><br>({{ $last_man_measurement->bumblebee->owner()->name }})
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
                                    <b>{{ $next_man_measurement->bumblebee->serial_number }}</b><br>({{ $next_man_measurement->bumblebee->owner()->name }})
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

    </x-slot>

</x-forms.form>

