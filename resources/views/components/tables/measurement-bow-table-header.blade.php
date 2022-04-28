@props([
    'showActions' => 0,
    'timeColumns' => 4,
    'timeList',
    ])
<thead>
<tr>
    <th scope="col" class="sticky top-0 left-0 z-10 bg-gray-50 md:px-6 md:py-3 sm:px-2 sm:py-1 flex flex-row md:space-x-4 sm:space-x-1">
        <span class="sr-only">Metric</span>
    </th>

    @for($i = 0; $i < $timeColumns; $i++)
        <th scope="col" class="sticky top-0 left-0 z-10 bg-gray-50 md:px-6 md:py-3 sm:px-2 sm:py-1 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
            @if(isset($timeList))
                {{ $timeList[$i] }}
            @else
                {{ __('Time '.$i) }}
            @endif
        </th>
    @endfor

    <th scope="col" class="sticky top-0 bg-gray-50 md:px-6 md:py-3 sm:px-2 sm:py-1  flex flex-row  flex-row-reverse md:space-x-4 sm:space-x-1">
        @if($showActions)
            <span class="sr-only">Actions</span>
        @endif
    </th>

</tr>
</thead>
