<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <!-- Content Markup Container -->
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">

        <!-- Sub Container -->
        <div class="mx-auto sm:px-6 lg:px-8">

            <!--  Form Title -->
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $create_new ? 'New User Data' : 'Edit User Data' }}</h3>
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

                <!--  Form Markup -->
                <form>

                    <!-- Fields Markup -->
                    <div class="shadow overflow-hidden sm:rounded-md">

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="User's ID"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="true"
                                         value="{{ $user->id}}"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Full Name"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         autofocus
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="user.name"
                                         wire:change="changed"
                                         placeholder="full name (required)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Email Address"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="user.email"
                                         wire:change="changed"
                                         placeholder="email address (required)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Mobile Phone"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="user.phone_mobile"
                                         wire:change="changed"
                                         placeholder="mobile phone number (optional)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Home Phone"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="user.phone_home"
                                         wire:change="changed"
                                         placeholder="home phone number (optional)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label value="Office Phone"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         :disabled="!$allow_edit"
                                         wire:model.lazy="user.phone_office"
                                         wire:change="changed"
                                         placeholder="office phone number (optional)"/>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <x-label class="font-bold text-blue-600 sm:col-span-1" value="User's Roles"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         value="{{ $user->getUserRoleNamesWithCommas()}}"
                                         disabled/>
                            </div>
                        </div>

                        @role('elliptic_admin')
                            @if($allow_edit)
                                <!-- Only Allow Changing Roles for elliptic_admin -->
                                @for($i = 0; $i < count($roles); $i++)

                                    <div class="sm:grid sm:grid-cols-12 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                        <div class="mt-0.5 sm:mt-0 sm:col-span-1"></div>
                                        <x-label class="italic text-blue-600 mt-0.5 sm:mt-0 sm:col-span-3"
                                                 value="{{$roles[$i]->display_name}}"/>
                                        <div class="mt-0.5 sm:mt-0 sm:col-span-2">
                                            <select wire:model.lazy="roles.{{$i}}.is"
                                                    wire:change="changed"
                                                    {{ $allow_edit ?  '' : 'disabled'}}
                                                    class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                                <option value="0" >No</option>
                                                <option value="1" >Yes</option>
                                            </select>
                                        </div>
                                        <div class="mt-0.5 sm:mt-0 sm:col-span-6">
                                            <p class="flex-wrap text-xs text-blue-400 italic">"{{$roles[$i]->description}}"</p>
                                        </div>
                                    </div>

                                @endfor
                            @endif
                        @endrole


                        @if($user->hasRole('pool-owner'))

                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Primary Pool Owner?"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                                    <select wire:model.lazy="poolOwner.is_primary_owner"
                                            wire:change="changed"
                                            {{ $allow_edit ?  '' : 'disabled'}}
                                            class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                        <option value="0" >No</option>
                                        <option value="1" >Yes</option>
                                    </select>
                                </div>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-3">
                                    <p class="flex-wrap text-xs text-blue-400 italic">"Primary contact and lead contracting person"</p>
                                </div>
                            </div>

                            @if($poolOwner->is_primary_owner)
                                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label value="Billing Address Same?"/>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-1">
                                        <select wire:model.lazy="poolOwner.billing_same_as_address"
                                                wire:change="changed"
                                                {{ $allow_edit ?  '' : 'disabled'}}
                                                class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                            <option value="0" >No</option>
                                            <option value="1" >Yes</option>
                                        </select>
                                    </div>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-3">
                                        <p class="flex-wrap text-xs text-blue-400 italic">"Use the Home address as the billing address?"</p>
                                    </div>
                                </div>
                            @else
                                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <x-label value="Who is Primary Owner?"/>
                                    <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                        <select wire:model.lazy="poolOwner.primary_owner_id"
                                                wire:change="changed"
                                                {{ $allow_edit ?  '' : 'disabled'}}
                                                class="{{ $allow_edit ?  'bg-white' : 'bg-indigo-50'   }} mt-1 px-3 py-3 text-black block w-full py-2 px-3 text-sm font-medium leading-5 text-gray-700 rounded-lg border border-gray-200 sm:mt-px sm:pt-2 shadow-sm border-gray-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 ">
                                            <option default selected disabled value="0">-- Select Primary Owner</option>
                                            @foreach($ownersList as $owner)
                                                <option value="0" >{{$owner->user->name.' {id: '.$owner->user->id.'}'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                        @endif

                        @if(!$allow_edit)
                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Created at"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <x-input type="text"
                                             value="{{ $user->created_at }}"
                                             disabled/>
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <x-label value="Updated at"/>
                                <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                    <x-input type="text"
                                             value="{{ $user->updated_at }}"
                                             disabled/>
                                </div>
                            </div>
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

                <!-- Home Address Child "Form" -->
                @livewire('address-form', [
                   'allow_edit' => $allow_edit,
                   'addressName' => "Home Address (required)",
                   'childForm' => true,
                   'address' => $addressHome,
                   ])

                @if($poolOwner->is_primary_owner && !$poolOwner->billing_same_as_address)
                    <!-- Billing Address Child "Form" -->
                    @livewire('address-form', [
                       'allow_edit' => $allow_edit,
                       'addressName' => "Billing Address (required)",
                       'childForm' => true,
                       'address' => $addressBilling,
                       ])
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
