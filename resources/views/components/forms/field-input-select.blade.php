@props(['label' => '',
'first_option' => '',
'first_option_value' => 0,
'allow_edit' => true,
'autofocus' => false,
'modelMethod' => '',
'changeMethod' => ''])

<div {{ $attributes->merge(['class' => 'sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5']) }}>
    <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
             value="{{$label }}"/>

    <div class="md:mt-0.5 sm:mt-0 {{isset($explanation) ? 'sm:col-span-2' : 'sm:col-span-4'}}">

        <select
            wire:model.lazy="{{$modelMethod}}"
            wire:change="{{$changeMethod}}"
            {{ $allowEdit == true ?  '' : 'disabled'}}
            {{ $autofocus == true ? 'autofocus' : ''}}
            class="{{ $allowEdit == true ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">

            @if(strlen($first_option) > 0)
                <option disabled selected value="{{ $first_option_value }}">
                    {{$first_option}}
                </option>
            @endif

            <span>
                {{ $select_options }}
            </span>
        </select>
    </div>

    @if(isset($explanation))
        <div {{$explanation->attributes->merge(['class' => "md:mt-0.5 sm:mt-0 sm:col-span-2 text-sm italic text-indigo-400 flex-wrap"]) }}>
            {{$explanation}}
        </div>
    @endif

</div>
