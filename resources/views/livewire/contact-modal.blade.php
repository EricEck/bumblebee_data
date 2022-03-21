<div>
    {{-- Be like water. --}}
    <x-modal wire:model="show">
             {{ $text }}

        <a wire:click.prevent="clicked"><x-buttons.calculate>Click Me</x-buttons.calculate></a>


    </x-modal>
</div>
