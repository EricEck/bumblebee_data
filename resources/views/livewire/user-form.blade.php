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
                            <x-label value="User's Roles"/>
                            <div class="mt-0.5 sm:mt-0 sm:col-span-4">
                                <x-input type="text"
                                         value="{{ $user->getUserRoleNamesWithCommas()}}"
                                         disabled/>
                            </div>
                        </div>

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

                <!-- Address Child "Form" -->
                @livewire('address-form', [
                   'allow_edit' => $allow_edit,
                   'addressName' => "Home Address (optional)",
                   'childForm' => true,
                   'address' => $addressHome,
                   ])

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
