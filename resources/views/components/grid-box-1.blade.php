@props(['label', 'value' ])

<p {!! $attributes->merge(['class' => "px-1 py-1 border"]) !!}>{{$label}}: <span class="text-orange-700">{{$value}}</span></p>
