{{--<button {!! $attributes->merge(['type' => 'button', 'class' => 'text-xs mt-1 mt-1 ml-1 flex bg-blue-100 font-bold py-1 px-1 rounded text-blue-600 hover:bg-gray-100']) !!}>--}}
{{--    {{ $slot }}--}}
{{--</button>--}}

<button {{ $attributes->merge(['type' => 'button', 'class' => 'text-xs uppercase mt-1 mt-1 ml-1 flex bg-blue-100 font-bold py-1 px-1 rounded text-blue-600 hover:bg-gray-100']) }}>
    {{ $slot }}
</button>
