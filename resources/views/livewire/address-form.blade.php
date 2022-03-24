<div>
    {{-- Be like water. --}}
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">
                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Country"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <select wire:model.lazy="address.country_id"
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
                            <x-input type="text" :disabled="!$allow_edit" wire:model.lazy="address.city_name" placeholder="name of city (required)"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Street Address 1"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" :disabled="!$allow_edit" wire:model.lazy="address.street_1" placeholder="first street line (required)"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Street Address 2"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" :disabled="!$allow_edit" wire:model.lazy="address.street_2" placeholder="second street line (optional)"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Street Address 3"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" :disabled="!$allow_edit" wire:model.lazy="address.street_3" placeholder="third street line (optional)"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Postal Code"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" :disabled="!$allow_edit" wire:model.lazy="address.postal_code" placeholder="postal code/ZIP (required)"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Latitude"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" pattern="-[0-9]*\.[0-9]+" :disabled="!$allow_edit" wire:model.lazy="address.latitude" placeholder="latitude (optional)"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <x-label value="Longitude"/>
                        <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                            <x-input type="text" pattern="-[0-9]*\.[0-9]+" :disabled="!$allow_edit" wire:model.lazy="address.longitude" placeholder="longitude (optional)"/>
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


                <!-- Process Buttons -->
{{--                    <div class="flex justify-between mt-8 py-2 px-4 mr-4 border border-4 border-r border-black py-4 px-4 bg-gray-50 shadow-lg shadow-black">--}}
{{--                        <div >--}}
{{--                            <a href="javascript:history.back()">--}}
{{--                                <x-buttons.back></x-buttons.back>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="font-extrabold text-xl text-green-700"--}}
{{--                             x-data="{show: false}"--}}
{{--                             x-show="show"--}}
{{--                             x-transition.opacity.out.duration.1500ms--}}
{{--                             x-init="@this.on('saved',() => { show = true; setTimeout(() => { show = false; },2000);  })"--}}
{{--                             style="display: none">--}}
{{--                            Calibration Data Saved.--}}
{{--                        </div>--}}
                        @if($allow_edit ?? '')
                            <div >
                                <x-buttons.save ></x-buttons.save>
                            </div>
                        @endif
{{--                    </div>--}}
                </form>

            </div>
        </div>
    </div>

</div>
