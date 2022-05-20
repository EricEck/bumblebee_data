<x-forms.form>

    <x-slot name="form_title">
        {{ $create_new ? 'New Elliptic Product' : 'Edit Elliptic Product'}}
    </x-slot>

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
                             value="Unassigned Bumblebees"/>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                        <select wire:model.lazy="ellipticProduct.bumblebee_id"
                                wire:change="changed"
                                {{ $allow_edit ?  '' : 'disabled'}}
                                class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            <option disabled selected value="0">-- Select Bumblebee</option>
                            @foreach($ellipticBumblebees as $ellipticBumblebee)
                                @if(!$ellipticBumblebee->isEllipticProduct() || ($ellipticProduct->bumblebee_id == $ellipticBumblebee->id))
                                    <option value="{{$ellipticBumblebee->id}}">{{ $ellipticBumblebee->serial_number }}</option>
                                @endif
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

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <div class="col-span-5">
                    Assign Elliptic Product to Pool Owner and Body of Water
                </div>
            </div>

            <x-forms.field-input-select
                :allow-edit="$allow_edit"
                first-option-value="-1"
                change-method="changed('pool_owner_id')"
                model-method="pool_owner_id"
                label="Pool Owner">
                <x-slot name="first_option">
                    -- Select Pool Owner (optional)
                </x-slot>
                <x-slot name="select_options">
                    @foreach($poolOwners as $poolOwner)
                        <option value="{{$poolOwner->id}}">{{ $poolOwner->name }}</option>
                    @endforeach
                </x-slot>
            </x-forms.field-input-select>

            @if($pool_owner_id > 0)
                <x-forms.field-input-select
                    :allow-edit="$allow_edit"
                    change-method="changed('bow_id')"
                    model-method="bow_id"
                    label="Body Of Water">
                    <x-slot name="first_option">
                        -- Select Body of Water (optional)
                    </x-slot>
                    <x-slot name="select_options">
                        @foreach($bodiesOfWater as $bow)
                            <option value="{{$bow->id}}">{{ $bow->name }} [id: {{$bow->id}}]</option>
                        @endforeach
                    </x-slot>
                </x-forms.field-input-select>
            @endif

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



</x-forms.form>
