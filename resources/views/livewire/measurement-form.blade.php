<div>
    {{-- Do your work, then step back. --}}

    <div class="mt-10 sm:mt-0">
        <!-- Header Markup -->
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Measurement for {{ $measurement->metric }}</h3>
                    {{--                    <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>--}}
                </div>
            </div>
        </div>

        <!-- Content FormMarkup -->
        <div class="mt-5 md:mt-0 md:col-span-6">

            <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">

                <div class="shadow overflow-hidden sm:rounded-md">

                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            @php(debugbar()->info($measurement->attributesToArray()))


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
{{--                                            {{ $allow_edit ?  '' : 'disabled'}}--}}
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
                                       class="px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                <label for="value" class="text-sm font-medium text-gray-700">Raw Value <span class="text-xs">(only "actual" if manual method)</span></label>
                                <textarea type="text" name="value" id="value"
                                       wire:model.lazy="measurement.value"
                                       {{ $allow_edit ?  '' : 'disabled'}}--}}
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
                                          {{ $allow_edit ?  '' : 'disabled'}}--}}
                                          class="px-3 text-black {{ $allow_edit ?? '' ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </textarea>
                            </div>



                        </div>
                    </div>


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

{{--            @if ($errors->any())--}}
{{--                <div class="bg-gray-100 py-8 px-8">--}}
{{--                    <h1 class="text-7xl py-4">ERROR(s)</h1>--}}
{{--                    <ul>--}}
{{--                        @foreach ($errors->all() as $error)--}}
{{--                            <li class="px-10">==> {{ $error }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>
</div>
