<x-buttons.text >
    <img width="18" class="pt-1" src="{{asset('images/buttons/plus-svgrepo-com.svg')}}" >
    {{ strlen($slot) ? $slot : 'New' }}
</x-buttons.text>


