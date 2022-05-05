<x-buttons.text {{ $attributes->merge(['class'=>'shadow md:shadow-md sm:shadow-sm']) }} >
    <img width="18" class="pt-1" src="{{asset('images/buttons/empty-set-mathematics-svgrepo-com.svg')}}" >
    {{ $slot ?? __('Empty Set') }}
</x-buttons.text>


