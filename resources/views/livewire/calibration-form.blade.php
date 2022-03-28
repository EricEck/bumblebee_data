<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <!-- Content Markup -->
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">
        <div class="mx-auto sm:px-6 lg:px-8">

            <!--  Form Title -->
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $create_new ? 'New Calibration Data' : 'Edit Calibration Data' }}</h3>
            </div>

            <div class="overflow-hidden shadow-sm sm:rounded-lg">

                <!--Message Event Handler -->
                <div class="font-extrabold text-xl text-green-700"
                     x-data="{show: false}"
                     x-show="show"
                     x-transition.opacity.out.duration.1500ms
                     x-init="@this.on('message',() => { show = true; setTimeout(() => { show = false; },2000);  })"
                     style="display: none">
                    {{$message}}
                </div>

                <!-- Process Buttons -->
                <div class="flex flex-row items-center m-4 py-2 px-4 mr-4 ">
                    <div class="basis-1/3">
                        @if(!$changed)
                            <a href="javascript:window.history.back()">
                                <x-buttons.back>Back</x-buttons.back>
                            </a>
                        @endif
                    </div>
                    <div class="basis-2/3">
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
                        @if($saved)
                            <a wire:click.debounce.500ms="runCalibration">
                                <x-buttons.calculate>Run Calibration</x-buttons.calculate>
                            </a>
                        @endif
                    </div>
                </div>

                <!--  Form Markup -->
                <form  >

                    <!-- Fields -->
                    <div class="shadow overflow-hidden sm:rounded-md">

                        @if($calibration->id > 0)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Calibration ID"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <x-input type="number"
                                             disabled
                                             value="{{$calibration->id}}"/>
                                </div>
                            </div>
                        @endif

                        @if(!$newCalibration)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Calibration Enabled"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <select wire:model.lazy="calibration.effective"
                                            wire:change="changed"
                                            {{ $allow_edit ? '' : 'disabled' }}
                                            class="{{ $allow_edit ?  'bg-white' :'bg-indigo-50'  }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Measurements Calibrated with this"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <x-input type="number"
                                             disabled
                                             value="{{ $calibratedMeasurementsCount }}"/>
                                </div>
                            </div>
                        @endif

                        @if($newCalibration)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Potentially Effected Measurements"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <x-input type="number"
                                             disabled
                                             value="{{ $effectedMeasurementsCount }}"/>
                                </div>
                            </div>
                        @endif

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Bumblebee"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="calibration.bumblebee_id"
                                        wire:change="changed"
                                        {{ $no_changes ?  'disabled' : ''}}
                                        class="{{ $no_changes ?  'bg-indigo-50' :'bg-white'  }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option selected value="0" disabled>--Which Bumblebee to Calibrate (required)</option>

                                    @foreach($bumblebees as $bumblebee)
                                        <option value="{{ $bumblebee->id }}">{{ $bumblebee->serial_number }}, Current owner: ({{ $bumblebee->owner->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Calibrator"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="calibration.calibrator_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ? 'bg-white' : 'bg-indigo-50' }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option selected value="0" disabled>--Who performed calibration (required)</option>

                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} {{$user->id == Auth::user()->id ? '(You)' : ''}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Metric"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="calibration.metric"
                                        wire:change="changed"
                                        {{ $no_changes ?  'disabled' : ''}}
                                        class="{{ $no_changes ?  'bg-indigo-50' :'bg-white'  }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option selected value="0" disabled>--Metric to calibrate (required)</option>

                                    @foreach($metrics as $metric)
                                        <option value="{{ $metric }}">{{ $metric }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Method"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="calibration.method"
                                        wire:change="changed"
                                        {{ $no_changes ?  'disabled' : ''}}
                                        class="{{ $no_changes ?  'bg-indigo-50' :'bg-white'  }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option selected value="0" disabled>--Which Measurement Method to Calibrate (required)</option>

                                    @foreach($meas_methods as $meas_method)
                                        <option value="{{ $meas_method }}">{{ $meas_method }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Type of Calibration"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="calibration.calibration_type"
                                        wire:change="changed"
                                        {{ ($allow_edit && count($calibrationTypes) > 1) ?  '' : 'disabled' }}
                                        class="{{ ($allow_edit && count($calibrationTypes) > 1) ? 'bg-white' : 'bg-indigo-50' }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option selected value="0" disabled>-- Calibration Type (required)</option>

                                    @foreach($calibrationTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Default Output Units"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="calibration.default_output_units"
                                        wire:change="changed"
                                        {{ ($allow_edit && count($default_output_units) > 1) ? '' : 'disabled' }}
                                        class="{{ ($allow_edit && count($default_output_units) > 1) ? 'bg-white' :  'bg-indigo-50'}} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option selected value="0" disabled>-- Calibrated Output Units (required)</option>

                                    @foreach($default_output_units as $default_output_unit)
                                        <option value="{{ $default_output_unit }}">{{ $default_output_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Calibration Effective Timestamp"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="datetime-local"
                                         :disabled="$no_changes"
                                         wire:model.lazy="calibration_datetime"
                                         wire:change="changed"
                                />
                            </div>
                        </div>

                        <!-- Helper Calculation -->
                        <div class="col-span-6 sm:col-span-3 mt-4 mb-4 ml-12 mr-12 py-4 px-4 border border-1 border-gray-100 bg-gray-50 shadow-md shadow-gray-600">
                            @if($calibration->calibration_type == "linear")
                                <!-- Linear Calibration Type -->

                                <h3 class="text-lg font-medium leading-6 text-gray-900">Linear Calibration...</h3>

                                <div class="py-4 px-10 bg-gray-100 mt-6 mb-6">
                                    <h2 class="text-lg">Calibrated Output({{ ( $calibration->slope_m == null || $calibration->offset_b == null) ? '' : round($measurement->valueDecodeNumber() * $calibration->slope_m + $calibration->offset_b,3) }}{{" ".$calibration->default_output_units." "}}) = Slope( {{ $calibration->slope_m == null ? '' : $calibration->slope_m }}{{" ".$calibration->default_output_units." "." / "." ".$measurement->unit." "}}) * Measurement( {{ $measurement->id == 0 ? '' : round($measurement->valueDecodeNumber(), 3).' '.$measurement->unit }} ) + Offset( {{ $calibration->offset_b == null ? '' : $calibration->offset_b }}{{" ".$calibration->default_output_units." "}})</h2>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label value="Slope of Equation"/>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                        <x-input type="text"
                                                 :disabled="!$allow_edit"
                                                 wire:model.lazy="calibration.slope_m"
                                                 wire:change="changed"
                                                 placeholder="enter slope of linear equation (required)"/>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label value="Offset of Equation"/>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                        <x-input type="text"
                                                 :disabled="!$allow_edit"
                                                 wire:model.lazy="calibration.offset_b"
                                                 wire:change="changed"
                                                 placeholder="enter offset (y intercept) of linear equation (required)"/>
                                    </div>
                                </div>



                            @elseif($calibration->calibration_type == "color absorption")
                                <!-- Color Absorption Type -->
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Color Absorption for {{ ucwords($calibration->metric) }}</h3>

                                <div class="py-4 px-10 bg-gray-100 mt-6 mb-6">
                                    <h2 class="text-lg">Calibrated Output({{ ( $calibration->slope_m == null || $calibration->offset_b == null) ? '' : round($measurement->colorimetricValue() * $calibration->slope_m + $calibration->offset_b,3) }}{{" ".$calibration->default_output_units." "}}) = Slope( {{ $calibration->slope_m == null ? '' : $calibration->slope_m }}{{" ".$calibration->default_output_units." "." / "." ".$measurement->unit." "}}) * Measurement( {{ $measurement->id == 0 ? '' : round($measurement->colorimetricValue(), 3).' '.$measurement->unit }} ) + Offset( {{ $calibration->offset_b == null ? '' : $calibration->offset_b }}{{" ".$calibration->default_output_units." "}})</h2>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label value="Slope of Equation"/>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                        <x-input type="text"
                                                 :disabled="!$allow_edit"
                                                 wire:model.lazy="calibration.slope_m"
                                                 wire:change="changed"
                                                 placeholder="enter slope of linear equation (required)"/>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label value="Offset of Equation"/>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                        <x-input type="text"
                                                 :disabled="!$allow_edit"
                                                 wire:model.lazy="calibration.offset_b"
                                                 wire:change="changed"
                                                 placeholder="enter offset (y intercept) of linear equation (required)"/>
                                    </div>
                                </div>

                            @else
                                    <h3 class="text-lg font-medium leading-6 text-red-800">Select a calibration type above...</h3>
                            @endif
                        </div>

                    </div>

                </form>

                <!-- Errors Display Markup -->
                @if ($errors->any())
                    <div class="bg-red-700 m-4 py-4 px-4 border border-1 border-red-900 shadow-md shadow-gray-500">
                        <h1 class="text-xl text-white">Entry Errors(s)</h1>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="px-10 text-white">==> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif

                <!-- Process Buttons -->
                <div class="flex flex-row items-center m-4 py-2 px-4 mr-4 ">
                    <div class="basis-1/3">
                        @if(!$changed)
                            <a href="javascript:window.history.back()">
                                <x-buttons.back>Back</x-buttons.back>
                            </a>
                        @endif
                    </div>
                    <div class="basis-2/3">
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
                        @if($saved)
                            <a wire:click.debounce.500ms="runCalibration">
                                <x-buttons.calculate>Run Calibration</x-buttons.calculate>
                            </a>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>



