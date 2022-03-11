<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $create_new ? 'New Calibration Data' : 'Calibration Data' }}</h3>
            </div>
        </div>
    </div>

    <!-- Content Markup -->
    <div class="mt-5 md:mt-0 md:col-span-6">

        <!--  Form Markup -->
        <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">

            <!-- Fields -->
            <div class="shadow overflow-hidden sm:rounded-md">

{{--                @php($no_changes = $allow_edit)--}}
{{--                @php(debugbar()->info($allow_edit))--}}
{{--                @php(debugbar()->info($measurement->id))--}}
                @php($measurement->bumblebee_id == 0 ? $no_changes = false : $no_changes = true )
{{--                @php(debugbar()->info($no_changes))--}}


                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="bumblebee_id" class="block text-sm font-medium text-gray-700">Bumblebee</label>
                    <select name="bumblebee_id" id="bumblebee_id"
                            wire:model.lazy="calibration.bumblebee_id"
                            @if($no_changes)
                                disabled
                                class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @else
                                class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @endif
                            <option selected value="0" disabled>--Which Bumblebee to Calibrate</option>
                        @foreach($bumblebees as $bumblebee)
                            <option value="{{ $bumblebee->id }}">{{ $bumblebee->serial_number }}, Current owner: ({{ $bumblebee->owner->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="calibrator_id" class="block text-sm font-medium text-gray-700">Calibrator</label>
                    @php($users = \App\Models\User::all())
                    <select name="calibrator_id" id="calibrator_id"
                            wire:model.lazy="calibration.calibrator_id"
                            @if($no_changes)
                                disabled
                                class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @else
                                class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @endif
                        <option selected value="0" disabled>--Who performed the calibration</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} {{$user->id == Auth::user()->id ? '(You)' : ''}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="metric" class="block text-sm font-medium text-gray-700">Metric</label>
                    <select name="metric" id="metric"
                            wire:model.lazy="calibration.metric"
                            @if($no_changes)
                                disabled
                                class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @else
                                class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @endif
                            <option selected disabled>-- Which Metric to Calibrate---</option>
                        @php($metrics = \App\Models\Measurement::metricEnums())
                        @foreach($metrics as $metric)
                            <option value="{{ $metric }}">{{ $metric }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="meas_method" class="block text-sm font-medium text-gray-700">Method</label>
                    <select name="meas_method" id="meas_method"
                            wire:model.lazy="calibration.method"
                            @if($no_changes)
                            disabled
                            class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @else
                            class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @endif
                        <option selected disabled>-- Which Measurement Method to Calibrate</option>
                        @php($meas_methods = $calibration->calibrationMethodEnums())
                        @foreach($meas_methods as $meas_method)
                            <option value="{{ $meas_method }}">{{ $meas_method }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="calibrationType" class="block text-sm font-medium text-gray-700">Type of Calibration</label>
                    @php($calibrationTypes = $calibration->calibrationTypesForMethod())
                    <select name="calibrationType" id="calibrationType"
                            wire:model.lazy="calibration.calibration_type"
                            autofocus
                            @if(!$allow_edit || count($calibrationTypes) == 1) )
                                disabled
                                class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @else
                                class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @endif
                        <option selected disabled>-- Calibration Type---</option>

                        @foreach($calibrationTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="default_output_units" class="block text-sm font-medium text-gray-700">Default Output Units</label>
                    @php($default_output_units = $measurement->validOutputUnitsForMetric())
                    <select name="default_output_units" id="default_output_units"
                            wire:model.lazy="calibration.default_output_units"
                            @if(!$allow_edit || count($default_output_units) == 1) )
                                disabled
                                class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @else
                                class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @endif
                        <option selected disabled>-- Calibrated Output Units</option>

                        @foreach($default_output_units as $default_output_unit)
                            <option value="{{ $default_output_unit }}">{{ $default_output_unit }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-span-6 sm:col-span-3 mt-4 ml-4 mr-4 border border-4 border-r border-black py-4 px-4 bg-gray-50 shadow-lg shadow-black">
                    @if($calibration->calibration_type == "linear")
                        <!-- Linear Calibration Type -->

                                <h3 class="text-lg font-medium leading-6 text-gray-900">Linear Calibration...</h3>

                                <div class="py-4 px-10 bg-gray-100 mt-6 mb-6">
                                    <h2 class="text-lg">Calibrated Output({{ ( $calibration->slope_m == null || $calibration->offset_b == null) ? '' : round($measurement->valueDecodeNumber() * $calibration->slope_m + $calibration->offset_b,3) }}{{" ".$calibration->default_output_units." "}}) = Slope( {{ $calibration->slope_m == null ? '' : $calibration->slope_m }}{{" ".$calibration->default_output_units." "." / "." ".$measurement->unit." "}}) * Measurement( {{ $measurement->id == 0 ? '' : round($measurement->valueDecodeNumber(), 3).' '.$measurement->unit }} ) + Offset( {{ $calibration->offset_b == null ? '' : $calibration->offset_b }}{{" ".$calibration->default_output_units." "}})</h2>
                                </div>
                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="slope_m" class="text-sm font-medium text-gray-700">Slope of Equation</label>
                                    <input type="text" name="slope_m" id="slope_m"
                                           wire:model.lazy="calibration.slope_m"
                                           class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:bg-white focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="offset_b" class="text-sm font-medium text-gray-700">Offset of Equation</label>
                                    <input type="text" name="offset_b" id="offset_b"
                                           wire:model.lazy="calibration.offset_b"
                                           class="mt-1 px-3 text-black bg-indigo-50 focus:ring-indigo-500 focus:bg-white focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>


                    @elseif($calibration->calibration_type == "color absorption")
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Color Absorption Not Ready Yet...</h3>
                    @elseif($calibration->calibration_type == "color shift")
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Color Shift Not Ready Yet...</h3>
                                        }
                    @else
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Select a calibration type above...</h3>
                    @endif
                </div>


                <div class="col-span-6 sm:col-span-3 mt-2">
                    <label for="calibration_datetime" class="text-sm font-medium text-gray-700">Calibration Effective Timestamp</label>
                    <input type="datetime-local" name="calibration_datetime" id="calibration_datetime"
                           wire:model.lazy="calibration_datetime"
                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                           class="mt-1 px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

            </div>

            <!-- Process Buttons -->
            <div style="display: grid; grid-template-columns: 30% 30% 30%;" class="mt-8 mb-3">
                <div><a href="javascript:history.back()"><x-buttons.back></x-buttons.back></a></div>
                <div style="justify-self: center">
{{--                    <x-buttons.reset>Reset</x-buttons.reset>--}}
                </div>
                @if($allow_edit ?? '')
                    <div style="justify-self: right"><x-buttons.save></x-buttons.save></div>
                @endif
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



