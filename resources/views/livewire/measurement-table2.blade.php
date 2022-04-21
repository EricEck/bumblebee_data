
{{-- If your happiness depends on money, you will never be happy with yourself. --}}

<!-- Select Body of Water -->

<div class="w-full flex pb-10">
{{--        <div class="w-1/6 relative mx-1">--}}
{{--            <select--}}
{{--                wire:model="pool_owner_id"--}}
{{--                wire:change="changed('pool_owner_id')"--}}
{{--                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">--}}
{{--                <option selected disabled value="0">-- Pool Owner</option>--}}
{{--                @foreach($poolOwners as $poolOwner)--}}
{{--                    <option value="{{$poolOwner->id}}">{{$poolOwner->name}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">--}}
{{--                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="w-1/2 relative mx-1">
            <select
                wire:model="bow_id"
                wire:change="changed('bow_id')"
                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option selected disabled value="0">-- Body of Water</option>
                @foreach($bodiesOfWater as $bowItem)
                    <option value="{{$bowItem->id}}">{{$bowItem->name}} [<span class="italic text-xs">owner: {{$bowItem->owner->name}}</span>]</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
</div>


@if($bodyOfWaterFound && $latestMeasurement)
FOUND
    <!-- Time Shift Arrows -->
    <div class="md:pb-3 sm:pb-1 flex flex-row ">
        <div class="flex flex-row grow">
            <x-buttons.arrow_fast_backward />
            <x-buttons.arrow_backward/>
        </div>
        <div class="flex flex-row-reverse grow">
            <x-buttons.arrow_fast_forward/>
            <x-buttons.arrow_forward/>
        </div>
    </div>

{{--    https://play.tailwindcss.com/7GvN4coLpm--}}
    <table class="min-w-full divide-y divide-gray-200 relative">

        <x-tables.measurement-2-table-header
            :show-actions="true"
            :time-columns="$timeSlotCount"
            :time-list="$timeSlots"
        />

        <tbody class="bg-white divide-y divide-gray-200">

        @for($j = 0; $j < count($metricsToDisplay); $j++)
            @if($metricsToDisplay[$j]['values'])
                <x-tables.measurement-2-table-row
                    :show-actions="true"
                    :time-columns="$timeSlotCount"
                    :value-display-at-time="$metricsToDisplay[$j]['values']">

                    <x-slot name="metric_name">
                        {{$metricsToDisplay[$j]['metric']}} ({{$metricsToDisplay[$j]['unit']}})<br/>
                        <span class="text-xs italic">{{'('.$metricsToDisplay[$j]['method'].')'}}</span>
                    </x-slot>
                </x-tables.measurement-2-table-row>
            @endif
        @endfor

        </tbody>
    </table>

@endif


