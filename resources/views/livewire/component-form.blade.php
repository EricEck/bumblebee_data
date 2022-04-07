<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <!-- Content Markup Container -->
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">

        <!-- Sub Container -->
        <div class="mx-auto sm:px-6 lg:px-8">

            <!--  Form Title -->
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $create_new ? 'New Body of Water Component' : 'Edit Body of Water Component' }}</h3>
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
                <form>

                    <!-- Fields Markup -->
                    <div class="shadow overflow-hidden sm:rounded-md">

                        @if($bowComponent->bodies_of_water_id)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="md:mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="Body of Water"/>
                                <div class="md:mt-0.5 sm:mt-0 sm:col-span-4">
                                    <input type="text"
                                           value="{{$bowComponent->bodyOfWater->name}} (owner:{{$bowComponent->bodyOfWater->owner->name}})"
                                           :disabled="true"
                                           class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </div>
                            </div>
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

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Installation Location"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-3">
                                <select wire:model.lazy="bowComponent.installation_location_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="-1">-- Select Installation Location</option>
                                    {{--                                    @foreach($ellipticProducts as $ellipticProduct)--}}
                                    {{--                                        <option value="{{$ellipticProduct->id}}">{{$ellipticProduct->name}} SN: {{$ellipticProduct->serial_number}}</option>--}}
                                    {{--                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                                <x-buttons.new>Add Location</x-buttons.new>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Product Manufacturer"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-3">
                                <select wire:model.lazy="bowComponent.manufacturer_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="-1">-- Select Product Manufacturer (required)</option>
                                    <option value="1">Elliptic Works, LLC</option>
                                    {{--                                    @foreach($ellipticProducts as $ellipticProduct)--}}
                                    {{--                                        <option value="{{$ellipticProduct->id}}">{{$ellipticProduct->name}} SN: {{$ellipticProduct->serial_number}}</option>--}}
                                    {{--                                    @endforeach--}}
          `                      </select>
                            </div>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                                <x-buttons.new>Add Manufacturer</x-buttons.new>
                            </div>
                        </div>

                        @if($bowComponent->manufacturer_id == 1)
                           <!-- Elliptic Works -->

                           <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                               <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                        value="Elliptic Product"/>
                               <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                   <select wire:model.lazy="bowComponent.elliptic_product_id"
                                           wire:change="changed"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                       <option disabled selected value="-1">-- Select Specific Elliptic Product (optional)</option>
                                       <option value="0">Not an Elliptic Product</option>
                                       {{--                                    @foreach($ellipticProducts as $ellipticProduct)--}}
                                       {{--                                        <option value="{{$ellipticProduct->id}}">{{$ellipticProduct->name}} SN: {{$ellipticProduct->serial_number}}</option>--}}
                                       {{--                                    @endforeach--}}
                                   </select>
                               </div>
                           </div>
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
                        @endif

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
