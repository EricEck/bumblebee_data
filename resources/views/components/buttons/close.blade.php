<x-buttons.text>
    <img width="18" class="{{$slot->isNotEmpty() ? 'pt-1' : ''}}" src="{{asset('images/buttons/close-svgrepo-com.svg')}}" >
    @if($slot->isNotEmpty())
        <div class="ml-1">
            {{$slot}}
        </div>
    @endif
</x-buttons.text>


