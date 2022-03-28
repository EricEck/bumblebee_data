<div>
    {{-- Be like water. --}}
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">

                <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">

                    <!--Message Event Handler -->
                    <div class="font-extrabold text-xl text-green-700"
                         x-data="{show: false}"
                         x-show="show"
                         x-transition.opacity.out.duration.1500ms
                         x-init="@this.on('message',() => { show = true; setTimeout(() => { show = false; },2000);  })"
                         style="display: none">
                        {{$message}}
                    </div>

                    <!-- Fields Markup -->
                    <div>
                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Country"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="address.country_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option value="0" disabled>Select Country (required)</option>

                                    @foreach($countries as $cntry)
                                        <option value="{{ $cntry->id }}">{{ $cntry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="State"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <select wire:model.lazy="address.state_id"
                                        wire:change="changed"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                        class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                    <option value="0" disabled>Select State (required)</option>
                                    @php($country = \App\Models\Country::find($address->country_id))
                                    @foreach($country->states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="City"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="address.city_name"
                                         wire:change="changed"
                                         placeholder="name of city (required)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Street Address 1"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="address.street_1"
                                         wire:change="changed"
                                         placeholder="first street line (required)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Street Address 2"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:change="changed"
                                         wire:model.lazy="address.street_2"
                                         placeholder="second street line (optional)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Street Address 3"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="address.street_3"
                                         wire:change="changed"
                                         placeholder="third street line (optional)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Postal Code"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="address.postal_code"
                                         wire:change="changed"
                                         placeholder="postal code/ZIP (required)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Latitude"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text" pattern="-[0-9]*\.[0-9]+"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="address.latitude"
                                         wire:change="changed"
                                         placeholder="latitude (optional)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Longitude"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" pattern="-[0-9]*\.[0-9]+"
                                     :disabled="!$allow_edit"
                                     wire:model.lazy="address.longitude"
                                     wire:change="changed"
                                     placeholder="longitude (optional)"/>
                        </div>
                    </div>
                    </div>

                    <!-- Errors Display Markup -->
                    @if ($errors->any())
                        <div class="col-span-3 bg-gray-400 mt-4 py-8 px-8 border border-4 border-r border-black py-4 px-4 shadow-lg shadow-black">
                            <h1 class="text-xl text-white">Entry Errors(s)</h1>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="px-10 text-white">==> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($allow_edit && $changed ?? '')
                    <!-- Process Buttons -->
                        <div class="flex flex-row items-end mt-4 mb-1">
                            <div class="basis-1/6">
{{--                                <p wire:click.prevent="discard">Discard</p>--}}
                                <a wire:click.prevent="discard"><x-buttons.close>Discard</x-buttons.close></a>
                            </div>
                            <div class="basis-2/3">
                            </div>
                            <div class="basis-1/6">
                                <x-buttons.save ></x-buttons.save>
                            </div>
                        </div>
                    @endif


                </form>

            </div>
        </div>
    </div>

</div>
