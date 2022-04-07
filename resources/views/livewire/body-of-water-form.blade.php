<div>
    {{-- The whole world belongs to you. --}}
    <!-- Content Markup Container -->
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">

        <!-- Sub Container -->
        <div class="mx-auto sm:px-6 lg:px-8">

            <!--  Form Title -->
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $create_new ? 'New Body of Water Data' : 'Edit Body of Water Data' }}</h3>
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

                        @if($bodyOfWater->id)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="BoW ID"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                                    <input type="number"
                                           value="{{$bodyOfWater->id}}"
                                           :disabled="true"
                                           class="bg-indigo-50 mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </div>
                            </div>

                        @endif

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Owner"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="bodyOfWater.pool_owner_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="0">-- Name of the Owner (required)</option>

                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if($bodyOfWater->pool_owner_id)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                         value="BoW Address"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <select wire:model.lazy="bodyOfWater.address_id"
                                            wire:change="changed"
                                            {{ $allow_edit ?  '' : 'disabled'}}
                                            class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                        <option disabled selected value="0">-- Address of BoW (required)</option>
                                        <option value="-1" class="text-xs">Create a new Address</option>

                                        @foreach($addresses as $address)
                                            <option value="{{$address->id}}" class="text-xs">{{$address->street_1.','}} {{strlen($address->street_2) ? $address->street_2.',' : ''}} {{strlen($address->street3) ? $address->street_3.',' : ''}} {{$address->city_name}}, {{$address->state->short_name}} {{$address->postal_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="BoW Name"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <input type="text"
                                       wire:model.lazy="bodyOfWater.name"
                                       wire:change="changed"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Description"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <textarea wire:model.lazy="bodyOfWater.description_pool"
                                          wire:change="changed"
                                          placeholder="important details about this body of water..."
                                          {{ $allow_edit ?  '' : 'disabled'}}
                                          class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </textarea>
                            </div>
                        </div>

                        @if($bodyOfWater->address_id == -1)
                        <!-- Address Child "Form" -->
                            @livewire('address-form', [
                               'allow_edit' => $allow_edit,
                               'addressName' => "Add the BoW Address (required)",
                               'childForm' => true,
                               'address' => $this->address,
                               ])
                        @endif

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Access details"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <textarea wire:model.lazy="bodyOfWater.description_access"
                                        wire:change="changed"
                                          placeholder="details of BoW area entry process..."
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </textarea>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Location Type"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="bodyOfWater.location_type_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="0">-- BoW Location Type (required)</option>

                                    @foreach($locationTypes as $locationType)
                                        <option value="{{$locationType->id}}">{{$locationType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Construction Type"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="bodyOfWater.construction_type_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="0">-- BoW Construction Type (required)</option>

                                    @foreach($constructionTypes as $constructionType)
                                        <option value="{{$constructionType->id}}">{{$constructionType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Construction Date"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                <input type="date"
                                       wire:model.lazy="bodyOfWater.construction_date"
                                       wire:change="changed"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                <p class="text-xs italic"> (estimate if not known)</p>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Construction Notes"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <textarea wire:model.lazy="bodyOfWater.description_construction"
                                          wire:change="changed"
                                          placeholder="key details about construction..."
                                          {{ $allow_edit ?  '' : 'disabled'}}
                                          class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                </textarea>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Commercial Pool"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="bodyOfWater.commercial"
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
                                     value="Indoor Location"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="bodyOfWater.indoor"
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
                                     value="BoW Volume"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                <input type="number"
                                       wire:model.lazy="bodyOfWater.gallons"
                                       wire:change="changed"
                                       {{ $allow_edit ?? '' ?  '' : 'disabled'}}
                                       class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                            </div>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                <p class="text-xs italic"> Gallons (critical for proper prescriptions)</p>
                            </div>
                        </div>


                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="mt-0.5 sm:mt-0 sm:col-span-1"
                                     value="Filtration Type"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="bodyOfWater.filtration_type_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option disabled selected value="0">-- BoW Filtration Type (required)</option>

                                    @foreach($filtrationTypes as $filtrationType)
                                        <option value="{{$filtrationType->id}}">{{$filtrationType->name}}</option>
                                    @endforeach
                                </select>
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
