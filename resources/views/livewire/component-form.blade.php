<x-forms.form>

    <x-slot name="form_title">
        {{ $create_new ? 'New Body of Water Component' : 'Edit Body of Water Component' }}
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
    <form>

        <!-- Fields Markup -->
        <div class="shadow overflow-hidden sm:rounded-md">

            @if($bowComponent->id)
                <x-forms.field-display-only
                    label="BoW Component ID"
                    value="{{$bowComponent->id}}"/>
            @endif

            <x-forms.field-input-select
                allow-edit={{$allow_edit}}
                change-method="changed"
                model-method="pool_owner_id"
                label="Pool Owner">
                <x-slot name="first_option">
                    -- Select Pool Owner (required)
                </x-slot>
                <x-slot name="select_options">
                    @foreach($poolOwners as $user)
                        <option value="{{$user->id}}">{{ $user->name }}</option>
                    @endforeach
                </x-slot>
            </x-forms.field-input-select>

            @if($pool_owner_id > 0)
                @php($bodiesOfWater = \App\Models\BodiesOfWater::where('pool_owner_id', $pool_owner_id)->get())
                <x-forms.field-input-select
                    allow-edit={{$allow_edit}}
                    change-method="changed"
                    model-method="bowComponent.bodies_of_water_id"
                    label="Body Of Water">
                    <x-slot name="first_option">
                        -- Select Body of Water (required)
                    </x-slot>
                    <x-slot name="select_options">
                        @foreach($bodiesOfWater as $bow)
                            <option value="{{$bow->id}}">{{ $bow->name }} [id: {{$bow->id}}]</option>
                        @endforeach
                    </x-slot>
                </x-forms.field-input-select>
            @endif

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Name"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                    <input type="text"
                           wire:model.lazy="bowComponent.name"
                           wire:change="changed"
                           placeholder="identifying name or labeled part"
                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Description"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                    <textarea wire:model.lazy="bowComponent.description"
                              wire:change="changed"
                              placeholder="important details about this component..."
                              {{ $allow_edit ?  '' : 'disabled'}}
                              class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                    </textarea>
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Installed now?"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                    <select wire:model.lazy="bowComponent.installed_now"
                            wire:change="changed"
                            {{ $allow_edit ?  '' : 'disabled'}}
                            class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                         value="Installation Date"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                    <input type="date"
                           wire:model.lazy="bowComponent.installation_date"
                           wire:change="changed"
                           placeholder="identifying name or labeled part"
                           {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                </div>
                <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                    <p class="text-sm text-indigo-400 italic">(estimate if not known)</p>
                </div>
            </div>

            <!-- Component Locations -->
            <x-forms.field-input-select
                allow-edit="allow_edit"
                change-method="changed"
                model-method="bowComponent.installation_location_id"
                label="Installation Location">

                <x-slot name="first_option">
                    -- Select Installation Location (required)
                </x-slot>

                <x-slot name="select_options">
                    @foreach($componentLocations as $componentLocation)
                        <option value="{{$componentLocation->id}}">{{ $componentLocation->name }}</option>
                    @endforeach
                </x-slot>

                <x-slot name="explanation">
                    @if(!$showAddComponentLocation)
                        <a href="" wire:click.prevent="addComponentLocation">
                            <x-buttons.new >Add Location</x-buttons.new>
                        </a>
                    @else
                        <a href="" wire:click.prevent="closeAddComponentLocation">
                            <x-buttons.close>Close</x-buttons.close>
                        </a>
                    @endif
                </x-slot>
            </x-forms.field-input-select>
            <!-- New Component Location -->
            @if($showAddComponentLocation)
                <div class="md:w-3/4 sm:w-full mx-auto md:my-5 sm:my-2 md:p-5 sm:p-2  bg-gray-50 shadow sm:shadow-sm md:shadow-md border border-gray-200 border-2">
                    @livewire('component-location-form', [
                         'create_new' => true,
                         'allow_edit' => true,
                         'closeAfterSaved' => true,
                         'showBack' => false,
                         'showClose' => true,
                         'bow_id' => $bowComponent->bodies_of_water_id,
                         'componentLocation' => $newComponentLocation])
                </div>
            @endif

            <!--Component Manufacturer -->
            <x-forms.field-input-select
                allow-edit="allow_edit"
                change-method="changed"
                model-method="bowComponent.manufacturer_id"
                label="Product Manufacturer">

                <x-slot name="first_option">
                    -- Select Product Manufacturer (required)
                </x-slot>

                <x-slot name="select_options">
                    @foreach($componentManufacturers as $componentManufacturer)
                        <option value="{{$componentManufacturer->id}}">{{ $componentManufacturer->name }}</option>
                    @endforeach
                </x-slot>

                <x-slot name="explanation">
                    @if(!$showAddComponentManufacturer)
                        <a href="" wire:click.prevent="addComponentManufacturer">
                            <x-buttons.new >Add Manufacturer</x-buttons.new>
                        </a>
                    @else
                        <a href="" wire:click.prevent="closeAddComponentManufacturer">
                            <x-buttons.close>Close</x-buttons.close>
                        </a>
                    @endif
                </x-slot>
            </x-forms.field-input-select>
            <!-- New Component Manufacturer -->
            @if($showAddComponentManufacturer)
                <div class="md:w-3/4 sm:w-full mx-auto md:my-5 sm:my-2 md:p-5 sm:p-2  bg-gray-50 shadow sm:shadow-sm md:shadow-md border border-gray-200 border-2">
                    @livewire('component-manufacturer-form', [
                         'create_new' => true,
                         'allow_edit' => true,
                         'closeAfterSaved' => true,
                         'showBack' => false,
                         'showClose' => true,
                         'componentManufacturer' => $newComponentManufacturer])
                </div>
            @endif


            @if($bowComponent->manufacturer_id == \App\Models\ComponentManufacturer::ellipticWorks()->id)
{{-- Elliptic Works Available Products --}}
                <x-forms.field-input-select
                    allow-edit="allow_edit"
                    change-method="changed"
                    model-method="productModelId"
                    label="Elliptic Product Model">

                    <x-slot name="first_option">
                        -- Select Elliptic Product Model (required)
                    </x-slot>

                    <x-slot name="select_options">
                        @foreach($ellipticProductModels as $ellipticProductModel)
                            <option value="{{$ellipticProductModel->id}}">{{ $ellipticProductModel->name }}</option>
                        @endforeach
                    </x-slot>

                    <x-slot name="explanation">
                        Active Models Shown
                    </x-slot>
                </x-forms.field-input-select>

                @if($productModelId > 0)
                    <x-forms.field-input-select
                        allow-edit="allow_edit"
                        first-option-value="0"
                        change-method="changed"
                        model-method="bowComponent.elliptic_product_id"
                        label="Elliptic Product">

                        <x-slot name="first_option">
                            -- Select Specific Elliptic Product (required)
                        </x-slot>

                        <x-slot name="select_options">
                            @foreach($ellipticProductsAvailable as $ellipticProduct)
                                <option value="{{$ellipticProduct->id}}">sn: {{$ellipticProduct->serialNumber()}}</option>
                            @endforeach
                        </x-slot>

                        <x-slot name="explanation">
                            Product Model: {{$ellipticProductModel->name}}
                        </x-slot>
                    </x-forms.field-input-select>
                @endif


            @elseif($bowComponent->manufacturer_id > 1)
            <!-- Other -->

                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                             value="Product Model"/>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                        <input type="text"
                               wire:model.lazy="bowComponent.model_number"
                               wire:change="changed"
                               placeholder="identifying name or labeled part"
                               {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                               class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                    </div>
                </div>


                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                             value="Serial Number"/>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                        <input type="text"
                               wire:model.lazy="bowComponent.serial_number"
                               wire:change="changed"
                               placeholder="identifying serial number (if known)"
                               {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                               class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                    </div>
                </div>
            @endif

            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                         value="In Warranty?"/>
                <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                    <select wire:model.lazy="bowComponent.warranty"
                            wire:change="changed"
                            {{ $allow_edit ?  '' : 'disabled'}}
                            class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>

            @if($bowComponent->warranty)
                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                             value="Warranty End Date"/>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                        <input type="date"
                               wire:model.lazy="bowComponent.warranty_end_date"
                               wire:change="changed"
                               placeholder="identifying name or labeled part"
                               {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                               class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                    </div>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                        <p class="text-sm text-indigo-400 italic">(leave empty if not known)</p>
                    </div>
                </div>
            @endif

            @if(!$create_new)
{{--                Only display if not creating new--}}

                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                             value="Remove From Service Date"/>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                        <input type="date"
                               wire:model.lazy="bowComponent.removed_from_service_date"
                               wire:change="changed"
                               disabled
                               class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                             value="Remove From Service Ticket"/>
                    <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                        <input type="text"
                               wire:model.lazy="bowComponent.removed_from_service_ticket_id"
                               wire:change="changed"
                               disabled
                               class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                    </div>
                </div>
            @endif

        </div>

    </form>

    <!-- Errors Display Markup -->
    @if($errors->any())
        <x-form-error-block :errors="$errors"/>
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
