<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">User {{$allow_edit ? 'Edit' : 'Information'}}</h3>
{{--                    <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>--}}
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">

                <form wire:submit.prevent="save" onkeydown="return event.key !== 'Enter';">

                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6 sm:col-span-3 mt-2">
                                    <label for="name" class="text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" id="name"
                                           wire:model.lazy="user.name"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           autocomplete="full name"
                                           autofocus
                                           class="mt-1 px-3 text-black {{ $allow_edit ? 'bg-indigo-50' : 'bg-gray-50'  }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>


                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                    <input type="email" name="email" id="email"
                                           {{ $allow_edit ?  '' : 'disabled'}}
                                           wire:model.lazy="user.email"
                                           autocomplete="email"
                                           class="mt-1 px-3 text-black {{ $allow_edit ?  'bg-indigo-50' : 'bg-gray-50' }} focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="selected_id" class="block text-sm font-medium text-gray-700">User ID</label>
                                    <input type="number" name="selected_id" id="selected_id"
                                           value="{{ $user->id}}"
                                           disabled
                                           autocomplete="email"
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="roles" class="block text-sm font-medium text-gray-700">Roles</label>
                                    <input type="text" name="roles" id="roles"
                                           value="{{ $user->getUserRoleNamesWithCommas()}}"
                                           disabled
                                           autocomplete="User Roles"
                                           class="mt-1 px-3 text-black focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="created_at" class="block text-sm font-medium text-gray-700">Created at</label>
                                    <input type="text" name="created_at" id="created_at"
                                           value="{{ $user->created_at }}"
                                           autocomplete=""
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-4 mt-2">
                                    <label for="updated_at" class="block text-sm font-medium text-gray-700">Created at</label>
                                    <input type="text" name="updated_at" id="updated_at"
                                           value="{{ $user->updated_at }}"
                                           autocomplete=""
                                           class="mt-1 px-3 text-black bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                            </div>
                        </div>
                        <div class="flow-root mt-6 ">

                            @if($allow_edit)
                                <div class="float-right">
                                    <x-buttons.save></x-buttons.save>
                                </div>
                            @endif
                            <div class="float-left">
                                <a href="javascript:history.back()"><x-buttons.back></x-buttons.back></a>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
