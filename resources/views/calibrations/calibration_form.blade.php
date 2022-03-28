<x-app-layout xmlns:x-slot="http://www.w3.org/1999/xlink">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($calibration) && $calibration->bumblebee_id > 0)
                {{ __('Calibration for ').ucwords($calibration->metric)."'s ".ucwords($calibration->method).__(' Module for ').$calibration->bumblebee->serial_number}}
            @else
                {{ __('New Calibration Entry') }}
            @endif
        </h2>
    </x-slot>


{{--    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">--}}

{{--        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
            @livewire('calibration-form', [
                    'allow_edit' => $allow_edit,
                    'create_new' => $create_new,
                    'measurement' => $measurement,
                    'calibration' => $calibration,
                    ])
{{--        </div>--}}

{{--    </div>--}}

        @if(isset($measurement) && $measurement->id > 0)
            <div class="bg-blue-100 px-4 mt-4 shadow-lg shadow-black ">

                <div class="py-6 bg-blend-lighten overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="col-span-12">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('This Measurement')}}</h3>
                            </div>
                            <div class="my-4">
                                <x-measurement-table-single :measurement="$measurement" :show-actions="0"></x-measurement-table-single>
                            </div>
                        </div>
                    </div>
                </div>

                @if($measurement->colorimetricMethod() && !$measurement->calibration_value)
                    @php($calibrationMeasurement = $measurement->previousCalibrationMeasurement())
                    @if($calibrationMeasurement)
                        <div class="py-6 bg-blend-lighten overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="md:grid md:grid-cols-3 md:gap-6">
                                <div class="col-span-12">
                                    <div class="px-4 sm:px-0">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Colorimetric Calibration Measurement')}}</h3>
                                    </div>
                                    <div class="my-4">
                                        <x-measurement-table-single :measurement="$calibrationMeasurement" :show-actions="0"></x-measurement-table-single>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if($prev_meas = $measurement->previousManualMeasurement())
                    <div class="py-6 bg-blend-lighten overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Previous Manual Measurement')}}</h3>
                                </div>
                                <div class="my-4">
                                    <x-measurement-table-single :measurement="$prev_meas" :show-actions="0"></x-measurement-table-single>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($next_meas = $measurement->nextManualMeasurement())
                    <div class="py-6 bg-blend-lighten overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Next Manual Measurement')}}</h3>
                                </div>
                                <div class="my-4">
                                    <x-measurement-table-single :measurement="$next_meas" :show-actions="0"></x-measurement-table-single>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endif

</x-app-layout>
