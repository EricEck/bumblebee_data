<x-buttons.text {{$attributes->merge(['class' => 'shadow md:shadow-md sm:shadow-sm'])}}>
    <img width="18" class="pt-1" src="{{asset('images/buttons/forward-svgrepo-com.svg')}}" >
    {{ $slot }}
</x-buttons.text>


