@props([
    'timeDisplay',
    'showActions' => 0,
    'timeColumns' => 4,
    'valueDisplayAtTime',
    ])

<tr class="even:bg-gray-50">
    <td class="sticky left-0 md:px-3 md:py-2 sm:px-2 md:py-1 leading-tight whitespace-nowrap xl:text-lg lg:text-sm md:text-sm text-xs font-bold text-blue-800 sticky left-0">
        {{$metric_name}}
    </td>

    @for($i = 0; $i < $timeColumns; $i++)
        <td class="md:px-3 md:py-2 sm:px-2 sm:py-1 whitespace-nowrap lg:text-lg md:text-sm text-xs text-gray-500">
          @if(isset($valueDisplayAtTime))
                {{ $valueDisplayAtTime[$i] }}
          @endif
        </td>
    @endfor

    @if($showActions)
        <td class="md:px-3 md:py-2 sm:px-2 sm:py-1 whitespace-nowrap lg:text-lg md:text-sm text-xs text-gray-500 flex flex-row flex-row-reverse md:space-x-4">
            <x-buttons.view/>
        </td>
    @endif
</tr>
