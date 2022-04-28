<x-buttons.text {{ $attributes->merge(['class'=>'shadow md:shadow-md sm:shadow-sm']) }} >
    <img width="18" class="pt-1" src="{{asset('images/buttons/edit-pen-write-svgrepo-com.svg')}}" >
    {{ $slot ?? __('Edit') }}
</x-buttons.text>


