<x-buttons.text {{ $attributes->merge(['class'=>'shadow md:shadow-md sm:shadow-sm']) }} >
    <img width="18" class="pt-1" src="{{asset('images/buttons/delete-svgrepo-com.svg')}}" >
    {{ $slot ?? __('Delete') }}
</x-buttons.text>


