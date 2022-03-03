<div>
    {{-- Success is as dangerous as failure. --}}

    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Bumblebee {{$create_new ? 'New' : ($allow_edit ? 'Edit' : 'Information')}}</h3>
                    {{--                    <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>--}}
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">

                <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">

                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="id" class="text-sm font-medium text-gray-700">Bumblebee ID</label>
                                    <input type="number" name="id" id="id"
                                           value="{{ $bumblebee->id }}"
                                           placeholder="{{ $create_new ? 'Will be assigned after save' : '' }}"
                                           disabled
                                           autocomplete=""
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="serial_number" class="text-sm font-medium text-gray-700">Serial Number</label>
                                    <input type="text" name="serial_number" id="serial_number"
                                           wire:model.lazy="bumblebee.serial_number"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           autocomplete="serial number"
                                           autofocus
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="current_version" class="text-sm font-medium text-gray-700">Current Version</label>
                                    <input type="text" name="current_version" id="current_version"
                                           wire:model.lazy="bumblebee.current_version"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           autocomplete="serial number"
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="manufactured_date" class="block text-sm font-medium text-gray-700">Manufactured on</label>
                                    <input type="date" name="manufactured_date" id="manufactured_date"
                                           wire:model.lazy="bumblebee.manufactured_date"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="owner_id" class="text-sm font-medium text-gray-700">Owner</label>
                                    @php($users = \App\Models\User::query()->where('id','>','0')->orderBy('name', 'asc')->get())
                                    <select name="owner_id" id="owner_id"
                                        wire:model.lazy="bumblebee.owner_id"
                                        {{ $allow_edit ?  '' : 'disabled'}}
                                            class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value='' disabled>Select Owner---</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="assigned_to_owner_on" class="block text-sm font-medium text-gray-700">Assigned to Owner on</label>
                                    <input type="date" name="assigned_to_owner_on" id="assigned_to_owner_on"
                                           wire:model.lazy="bumblebee.assigned_to_owner_on"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="removed_from_service" class="block text-sm font-medium text-gray-700">Service status</label>
                                    <select  name="removed_from_service" id="removed_from_service"
                                           wire:model.lazy="bumblebee.removed_from_service"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="0">In Service</option>
                                        <option value="1">Out of Service</option>
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="new_password" class="block text-sm font-medium text-gray-700">API Password (leave blank to not change)</label>
                                    <input type="password"  name="new_password" id="new_password"
                                           wire:model.lazy="new_password"
                                           placeholder="{{ $create_new ? 'Must be at least 6 characters, record in secure place' : '' }}"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="remember_token" class="block text-sm font-medium text-gray-700">Remember Token</label>
                                    <input type="text" name="remember_token" id="remember_token"
                                           value="{{ $bumblebee->remember_token }}"
                                           placeholder="{{ $create_new ? 'Will be assigned after save' : '' }}"
                                           disabled
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="created_at" class="block text-sm font-medium text-gray-700">Created at</label>
                                    <input type="text" name="created_at" id="created_at"
                                           value="{{ $bumblebee->created_at }}"
                                           placeholder="{{ $create_new ? 'Will be assigned after save' : '' }}"
                                           disabled
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="updated_at" class="block text-sm font-medium text-gray-700">Updated at</label>
                                    <input type="text" name="updated_at" id="updated_at"
                                           value="{{ $bumblebee->updated_at }}"
                                           placeholder="{{ $create_new ? 'Will be assigned after save' : '' }}"
                                           disabled
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                            </div>
                        </div>
                        <div class="flow-root mt-6 items-center">

                            @if($allow_edit)
                                <div class="float-right">
                                    <x-buttons.save></x-buttons.save>
                                </div>
                                <div class="float-right">
                                    <x-buttons.reset>Reset</x-buttons.reset>
                                </div>
                            @endif
                            <div class="float-left">
                                <a href="javascript:history.back()"><x-buttons.back></x-buttons.back></a>
                            </div>
                        </div>

                    </div>


                </form>

                @if ($errors->any())
                    <div class="bg-gray-100 py-8 px-8">
                        <h1 class="text-7xl py-4">ERROR(s)</h1>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="px-10">==> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>
