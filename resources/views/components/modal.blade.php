<div x-data="{
        show: @entangle($attributes->wire('model')).defer
    }"
     x-show="show"
     x-on:keydown.escape.window="show = false"
    class="fixed inset-0 overflow-y-auto py-32 px-6 md:py-24 sm:px-0 z-40">
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
    <div x-show="show"
         x-on:click="show = false"
         class="fixed inset-0 transform">
        <div class="absolute inset-0 bg-blue-400 opacity-40"></div>
    </div>
    <div x-show="show" class="shadow-black shadow-lg bg-white rounded-lg overflow-hidden transform sm:w-full sm:mx-auto max-w-lg">
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
