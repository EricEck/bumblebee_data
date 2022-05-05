@props([])
{{-- Use to add tooltip to data that is selectable easily--}}
{{-- Use icon-toolip for non selectable tooptip--}}
<span {{ $attributes->merge(['class' => "ml-2 h-5 w-5 cursor-pointer"]) }}
      x-data="{ tooltip: false }"
      x-on:mouseover="tooltip = true"
      x-on:mouseleave="tooltip = false">
{{--Data goes here --}}
    <span {{ $attributes->merge(['class' => "font-thin text-xs px-0 mx-0"]) }}>
        {{$datafield}}
    </span>
{{--Tooltip goes here --}}
  <div {{ $attributes->merge(['class' => "text-xs text-white absolute bg-blue-400 rounded-lg md:p-2 p-1 transform -translate-y-8 translate-x-8"]) }}
       x-show="tooltip">
      {{$tooltipfield}}
  </div>
</span>

