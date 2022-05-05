<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <!-- Select a Body of Water -->
    <div class="w-full flex flex-auto md:pb-4 sm:pb-1 border-b-2 border-gray-100">
        <div class="w-1/4 relative mx-1">
            <select
                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                wire:model="pool_owner_id"
                wire:change="changed('pool_owner_id')"
                autofocus>
                <option disabled selected value="0">-- Filter by Pool Owner</option>
                <option value="-1">All Pool Owners</option>
                @foreach($poolOwners as $poolOwner)
                    <option value="{{$poolOwner->id}}">{{$poolOwner->name}}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-3/4 relative mx-1">
            <select
                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                wire:model="bow_id"
                wire:change="changed('bow_id')">
                <option disabled selected value="0">-- Select Body of Water</option>
                @foreach($bodiesOfWater as $bow)
                    <option value="{{$bow->id}}">{{$bow->name}} [<span class="italic text-gray-200">owner: {{$bow->owner->name}}</span> ]</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </div>

    <!-- Display Horizontal Table for BoW Measurements -->
    @if($bodyOfWaterFound)
        @if($measurementsFoundforBow)

            <!-- Time Shift Bar and Controls-->
            <div class="md:pb-3 sm:pb-1 flex flex-row content-center">
                <div class="flex flex-row basis-1/6">
                    <x-buttons.arrow_fast_backward
                        class="{{$atNewest ? 'hidden' : ''}}"
                        wire:click="newestShift"/>
                    <x-buttons.arrow_backward
                        class="{{$atNewest ? 'hidden' : ''}}"
                        wire:click="newerShift"/>
                </div>
                <div class="flex flex-row basis-1/6 bg-indigo-50 border-gray-200 border border-1 align-middle">
                    <div class="flex flex-col items-center">
                        <div class="text-blue-800 m-auto text-xs">Newest: {{$latestMeasurementTime->longRelativeToNowDiffForHumans()}}</div>
                        <div class="text-blue-800 m-auto text-xs">{{$latestMeasurement->measurement_timestamp}}</div>
                    </div>
                </div>
                <div class="flex flex-row basis-1/6 bg-indigo-50 border-gray-200 border border-1 shadow shadow-sm shadow-gray-500">
                    <select class="block text-xs text-center appearance-none w-full bg-indigo-50 border border-gray-200 text-gray-700 sm:px-1 px-0.5 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            wire:model="minutesBetweenTimeSlots"
                            wire:change="changed('minutes_between_slots')">
                        <option value="15">15 Minute Period</option>
                        <option value="30">30 Minute Period</option>
                        <option value="60">1 Hour Period</option>
                        <option value="120">2 Hour Period</option>
                        <option value="240">4 Hour Period</option>
                        <option value="480">8 Hour Period</option>
                        <option value="720">12 Hour Period</option>
                        <option value="1440">24 Hour Period</option>
                    </select>
                </div>
                <div class="flex flex-row basis-1/6 bg-indigo-50 border-gray-200 border border-1 shadow shadow-sm shadow-gray-500">
                    <select class="block text-xs text-center appearance-none w-full bg-indigo-50 border border-gray-200 text-gray-700 sm:px-1 px-0.5 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            wire:model="data_display_type"
                            wire:change="changed('data_display_type')">
                        <option value="raw">Not Calibrated</option>
                        <option value="cal">Calibrated</option>
                    </select>
                </div>
                <div class="flex flex-row basis-1/6 bg-indigo-50 border-gray-200 border border-1">
                    <div class="">
                        <p class="text-blue-800 text-center text-xs">Oldest: {{$oldestMeasurementTime->longRelativeToNowDiffForHumans()}}</p>
                        <p class="text-blue-800 text-center text-xs">{{$oldestMeasurement->measurement_timestamp}}</p>
                    </div>
                </div>
                <div class="flex flex-row-reverse basis-1/6">
                    <x-buttons.arrow_fast_forward
                        class="{{$atOldest ? 'hidden' : ''}}"
                        wire:click="oldestShift"/>
                    <x-buttons.arrow_forward
                        class="{{$atOldest ? 'hidden' : ''}}"
                        wire:click="olderShift"/>
                </div>
            </div>

            <!-- Measurement Table -->
            <table class="min-w-full divide-y divide-gray-200 relative">

                <x-tables.measurement-bow-table-header
                    :show-actions="true"
                    :time-columns="$timeSlotCount"
                    :time-list="$timeSlots"/>

                <tbody class="bg-white divide-y divide-gray-200">

                @for($j = 0; $j < count($metricsToDisplay); $j++)
{{--                    Only display if there exist values AND display is requested --}}
                    @if(count($metricsToDisplay[$j]['values']) && $metricsToDisplay[$j]['displayDefault'])
{{--                    Do not display calculation rows when the data is not calibrated--}}
                        @if(!($metricsToDisplay[$j]['dataType'][0] == 'calc' && $metricsToDisplay[$j]['none'][0] == true))

                            <x-tables.measurement-bow-table-row
                                :show-actions="false"
                                :time-columns="$timeSlotCount"
                                :value-display-at-time="$metricsToDisplay[$j]['values']"
                                :value-data-type="$metricsToDisplay[$j]['dataType']"
                                :value-none="$metricsToDisplay[$j]['none']"
                                :value-holdover="$metricsToDisplay[$j]['holdOver']">

                                <x-slot name="metric_name">
                                    {{$metricsToDisplay[$j]['metric']}} ({{$metricsToDisplay[$j]['unit']}})<br/>
                                    <span class="text-xs italic">{{'('.$metricsToDisplay[$j]['method'].')'}}</span>
                                </x-slot>
                            </x-tables.measurement-bow-table-row>
                        @endif
                    @endif
                @endfor

                </tbody>
            </table>

        @else
        <p>No Measurements found for that Body of Water</p>
        @endif

    @endif
</div>
