@props([
    'timeDisplay',
    'showActions' => 0,
    'timeColumns' => 4,
    'valueDisplayAtTime',
    'valueHoldover',
    'valueDataType',
    'valueNone',
    ])

<tr class="even:bg-gray-50">
    <td class="sticky left-0 md:px-3 md:py-2 sm:py-1 py-0 sm:px-2 xs:py-0 px-1 leading-tight whitespace-nowrap xl:text-lg lg:text-sm md:text-sm text-xs font-bold text-blue-800 sticky left-0">
        {{$metric_name}}
    </td>

    @for($i = 0; $i < $timeColumns; $i++)
        <td class="md:px-3 md:py-2 sm:px-2 sm:py-1 whitespace-nowrap lg:text-lg md:text-sm text-xs text-gray-500">

            @if($valueDataType[$i] != 'calc')
                {{ round($valueDisplayAtTime[$i],3) }}
                @if($valueNone[$i])
                    <x-datahelpers.icon-tooltip>
                        <x-slot name="datafield">
                            x
                        </x-slot>
                        <x-slot name="tooltipfield">No older values</x-slot>
                    </x-datahelpers.icon-tooltip>
                @elseif($valueHoldover[$i])
                    <x-datahelpers.icon-tooltip>
                        <x-slot name="datafield">
                            >
                        </x-slot>
                        <x-slot name="tooltipfield">Data from older period</x-slot>
                    </x-datahelpers.icon-tooltip>
                @endif
            @endif

            @if($valueDataType[$i] == 'calc')
                <x-datahelpers.data-tooltip>
                    <x-slot name="datafield">
                        {{ $valueDisplayAtTime[$i] }}
                    </x-slot>
                    <x-slot name="tooltipfield">
                        @if($valueNone[$i])
                            Calculation not possible
                        @else
                            Calculated Data Field
                        @endif
                    </x-slot>
                </x-datahelpers.data-tooltip>
            @endif


        </td>
    @endfor

    @if($showActions)
        <td class="unselectable md:px-3 md:py-2 sm:px-2 sm:py-1 whitespace-nowrap lg:text-lg md:text-sm text-xs text-gray-500 flex flex-row flex-row-reverse md:space-x-4">
            <x-buttons.view/>
        </td>
    @endif
</tr>
