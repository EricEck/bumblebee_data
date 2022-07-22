@props(['label' => '', 'value' => ''])

<div {{ $attributes->merge(['class' => 'grid grid-cols-5 gap-2 items-start border-t border-gray-200 mt-1 pt-1']) }}>
    <x-label class="mt-0.5 col-span-3 text-lg"
             value="{{$label }}"/>
    <div class="md:mt-0.5 mt-0 col-span-2">
        <div class="bg-indigo-50 mt-1 px-2 py-2 text-black block w-full text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
            {{ $value }}
        </div>
    </div>
</div>
