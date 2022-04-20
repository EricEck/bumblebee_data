
{{-- If your happiness depends on money, you will never be happy with yourself. --}}

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

{{--https://play.tailwindcss.com/7GvN4coLpm--}}
<table class="min-w-full divide-y divide-gray-200 relative">

    <x-tables.measurement-2-table-header
        :show-actions="true"
        :time-columns="$timeSlotCount"
        :time-list="$timeSlots"
    />

    <tbody class="bg-white divide-y divide-gray-200">

    @for($j = 0; $j < count($metricsToDisplay); $j++)
        <x-tables.measurement-2-table-row
            :show-actions="true"
            :time-columns="$timeSlotCount"
            :value-display-at-time="$metricsToDisplay[$j]['values']"
            {{--            :value-display-at-time="$metricsToDisplay['values']"--}}
        >

            <x-slot name="metric_name">
                {{$metricsToDisplay[$j]['metric']}} ({{$metricsToDisplay[$j]['unit']}})<br/>
                <span class="text-xs italic">{{'('.$metricsToDisplay[$j]['method'].')'}}</span>
            </x-slot>
        </x-tables.measurement-2-table-row>
    @endfor

    </tbody>
</table>


