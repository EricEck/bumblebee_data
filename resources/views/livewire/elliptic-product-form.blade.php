<div>
{{-- If your happiness depends on money, you will never be happy with yourself. --}}
<!-- Content Markup Container -->
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">

        <!-- Sub Container -->
        <div class="mx-auto sm:px-6 lg:px-8">

            <!--  Form Title -->
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $create_new ? 'New Elliptic Product' : 'Edit Elliptic Product'}}</h3>
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

                <!-- Process Buttons -->
                <div class="flex flex-row items-end mt-4 mb-1">
                    <div class="basis-1/3">
                        {{--                        @if(!$changed && $showBack)--}}
                        {{--                            <a href="javascript:window.history.back()">--}}
                        {{--                                <x-buttons.back>Back</x-buttons.back>--}}
                        {{--                            </a>--}}
                        {{--                        @endif--}}
                    </div>
                    <div class="basis-1/3">
                        @if($changed)
                            <a wire:click.debounce.500ms="discard">
                                <x-buttons.close>Discard Changes</x-buttons.close>
                            </a>
                        @endif
                    </div>
                    <div class="basis-1/3">
                        @if($allow_edit && $changed && $readyToSave)
                            <a wire:click.debounce.500ms="save">
                                <x-buttons.save>Save</x-buttons.save>
                            </a>
                        @endif
                    </div>
                </div>

                <!--  Form Markup -->
                <form onkeydown="return event.key != 'Enter';">

                    <!-- Fields Markup -->
                    <div class="shadow overflow-hidden sm:rounded-md">

                        @if($ellipticProduct->id)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="Elliptic Product ID"/>
                                <div class="md:mt-0.5 sm:mt-0 sm:col-span-4">
                                    <div class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                        {{$ellipticProduct->id}}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Model -->
                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Model"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="ellipticProduct.elliptic_model_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="0">-- Select Elliptic Product Model</option>
                                    @foreach($ellipticModels as $ellipticModel)
                                        <option value="{{$ellipticModel->id}}">{{ $ellipticModel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Bumblebee -->
                        @if($ellipticProduct->ellipticModel && $ellipticProduct->ellipticModel->is_bumblebee)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="Bumblebee"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <select wire:model.lazy="ellipticProduct.bumblebee_id"
                                            wire:change="changed"
                                            {{ $allow_edit ?  '' : 'disabled'}}
                                            class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                        <option disabled selected value="0">-- Select Bumblebee</option>
                                        @foreach($ellipticBumblebees as $ellipticBumblebee)
                                            <option value="{{$ellipticBumblebee->id}}">{{ $ellipticBumblebee->serial_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($ellipticProduct->bumblebee)
                                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                                             value="Bumblebee Serial Number"/>
                                    <div class="md:mt-0.5 sm:mt-0 sm:col-span-4">
                                        <div class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                            {{$ellipticProduct->bumblebee->serial_number}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @else
                            @php($ellipticProduct->bumblebee_id = 0)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="Serial Number"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <input type="text"
                                           wire:model.lazy="ellipticProduct.serial_number"
                                           wire:change="changed"
                                           placeholder="identifying serial number"
                                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </div>
                            </div>
                        @endif

                        @if($ellipticProduct->bumblebee)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="Bumblebee Manufacture Date"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <div class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                        {{ $ellipticProduct->bumblebee->manufactured_date }}
                                    </div>
                                </div>
                            </div>

                        @else
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="Manufacture Date"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <input type="date"
                                           wire:model.lazy="ellipticProduct.manufactured_on"
                                           wire:change="changed"
                                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </div>
                            </div>
                        @endif

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Manufacturer"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="ellipticProduct.elliptic_manufacturer_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="0">-- Select Manufacturer</option>
                                    @foreach($ellipticManufacturers as $ellipticManufacturer)
                                        <option value="{{$ellipticManufacturer->id}}">{{ $ellipticManufacturer->name }} ({{$ellipticManufacturer->contact}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Manufacturer Construction Version"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="text"
                                       wire:model.lazy="ellipticProduct.manufacture_construction_version"
                                       wire:change="changed"
                                       placeholder="as built version of the hardware"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Manufacturer Software Version"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="text"
                                       wire:model.lazy="ellipticProduct.manufacture_software_version"
                                       wire:change="changed"
                                       placeholder="as built version of the software"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Warranty Start Date"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="date"
                                       wire:model.lazy="ellipticProduct.warranty_started_on"
                                       wire:change="changed"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Warranty End Date"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="date"
                                       wire:model.lazy="ellipticProduct.warranty_ends_on"
                                       wire:change="changed"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Current Construction Version"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="text"
                                       wire:model.lazy="ellipticProduct.current_construction_version"
                                       wire:change="changed"
                                       placeholder="present version of the hardware"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Current Software Version"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="text"
                                       wire:model.lazy="ellipticProduct.current_software_version"
                                       wire:change="changed"
                                       placeholder="present version of the software"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
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
                        @if(!$changed && $showBack)
                            <a href="javascript:window.history.back()">
                                <x-buttons.back>Back</x-buttons.back>
                            </a>
                        @endif
                    </div>
                    <div class="basis-1/3">
                        @if($changed)
                            <a wire:click.debounce.500ms="discard">
                                <x-buttons.close>Discard Changes</x-buttons.close>
                            </a>
                        @endif
                    </div>
                    <div class="basis-1/3">
                        @if($allow_edit && $changed && $readyToSave)
                            <a wire:click.debounce.500ms="save">
                                <x-buttons.save>Save</x-buttons.save>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
