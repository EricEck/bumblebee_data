<div class="justify-center bg-gray-100 border-gray-300 border-b-2 px-6 py-4">
    {{-- Success is as dangerous as failure. --}}
    <x-label>A Test Livewire Component</x-label>
    <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow" wire:click="increment">
        {{$buttonText}}
    </button>
    <h1>Count: {{$count}}</h1>

</div>
