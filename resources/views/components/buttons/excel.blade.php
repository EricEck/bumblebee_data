<x-buttons.text >
    <img width="18" class="pt-1" src="{{asset('images/buttons/excel-svgrepo-com.svg')}}" >
    {{ strlen($slot) ? $slot  : 'CSV' }}
</x-buttons.text>


