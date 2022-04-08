<div>
{{-- Be like water. --}}

<!--  Form Title -->
    <div class="px-4 sm:px-0">
        <h3 class="text-lg italic font-medium leading-6 text-black ">{{ $create_new ? 'New Component Product Manufacturer' : 'Edit Component Product Manufacturer' }}</h3>
    </div>
    <!-- Form Container -->
    <div class="overflow-hidden shadow-sm sm:rounded-lg">

        <!--Message Event Handler -->
        <div class="font-extrabold text-xl text-green-700"
             x-data="{show: false}"
             x-show="show"
             x-transition.opacity.out.duration.1500ms
             x-init="@this.on('message',() => { show = true; setTimeout(() => { show = false; },2000);  })"
             style="display: none">
            {{$message}}
        </div>

        <!--  Form Markup -->
        <form >

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-b sm:border-gray-200 sm:pt-5">
                <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Name"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                    <input type="text"
                           onkeydown="return event.key !== 'Enter';"
                           wire:model.lazy="componentManufacturer.name"
                           wire:change="changed"
                           placeholder="branding name of manufacturer"
                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-b sm:border-gray-200 sm:pt-5">
                <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Description"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                        <textarea
                            wire:model.lazy="componentManufacturer.description"
                            wire:change="changed"
                            placeholder="description of company"
                            {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                            class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                        </textarea>
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-b sm:border-gray-200 sm:pt-5">
                <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Main Website"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                    <input type="text"
                           wire:model.lazy="componentManufacturer.website_main_url"
                           onkeydown="return event.key !== 'Enter';"
                           wire:change="changed"
                           placeholder="main consumer oriented website"
                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-b sm:border-gray-200 sm:pt-5">
                <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Service Website"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                    <input type="text"
                           wire:model.lazy="componentManufacturer.website_service_url"
                           onkeydown="return event.key !== 'Enter';"
                           wire:change="changed"
                           placeholder="website for professionals and service"
                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                </div>
            </div>

        </form>

        <!-- Errors Display Markup -->
        @if ($errors->any())
            <div class="bg-red-700 m-4 py-4 px-4 border border-1 border-red-900 shadow-md shadow-gray-500">
                <h1 class="text-xl text-white">Entry Errors(s)</h1>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="px-10 text-white">==> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif


    <!-- Process Buttons -->
        <div class="flex flex-row items-end mt-4 mb-1">
            <div class="basis-1/3">
                @if(!$changed && ($showBack || $showClose))
                    @if($showBack)
                        <a href="javascript:window.history.back()">
                            <x-buttons.back>Back</x-buttons.back>
                        </a>
                    @endif
                    @if($showClose)
                        <a wire:click="closeForm">
                            <x-buttons.close>Close</x-buttons.close>
                        </a>
                    @endif
                @endif
            </div>
            <div class="basis-1/3">
                @if($changed)
                    <a wire:click="discard">
                        <x-buttons.close>Discard Changes</x-buttons.close>
                    </a>
                @endif
            </div>
            <div class="basis-1/3">
                @if($allow_edit && $changed && $readyToSave)
                    <a wire:click="save">
                        <x-buttons.save type="button">Save</x-buttons.save>
                    </a>
                @endif
            </div>
        </div>

    </div>


</div>
