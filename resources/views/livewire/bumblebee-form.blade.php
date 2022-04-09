<div>
{{-- Success is as dangerous as failure. --}}
<!-- Content Markup Container -->
    <div class="w-3/4 mx-auto my-2 py-4 bg-yellow-50 rounded-lg border-gray-100 border shadow-lg">

        <!-- Sub Container -->
        <div class="mx-auto sm:px-6 lg:px-8">

            <!--  Form Title -->
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-500 border border-b-2  border-gray-50">{{ $create_new ? 'New' : ($allow_edit ? 'Edit' : 'Information about ') }} Bumblebee</h3>
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
                <form onkeydown="return event.key !== 'Enter';">


                    <!-- Fields Markup -->
                    <div class="shadow overflow-hidden sm:rounded-md">

                        @if($bumblebee->id > 0)
                        <x-forms.field-display-only
                            label="Bumblebee ID"
                            value="{{ $bumblebee->id }}"/>
                        @endif

                        <x-forms.field-input-text
                            label="Serial Number"
                            model-method="bumblebee.serial_number"
                            change-method="changed"
                            autofocus
                            placeholder="enter unique serial number"
                            explanation="Will be used as reference, must be unique"
                            allow-edit={{$allow_edit}} />

                        <x-forms.field-input-text
                            label="Current Version"
                            model-method="bumblebee.current_version"
                            change-method="changed"
                            placeholder="enter current unit version"
                            explanation="Not the built version"
                            allow-edit={{$allow_edit}} />

                        <x-forms.field-input-date
                            label="Manufacture Date"
                            model-method="bumblebee.manufactured_date"
                            change-method="changed"
                            explanation="enter the date built"
                            allow-edit={{$allow_edit}} />


                        <x-forms.field-input-select-start
                            label="Current Owner"
                            model-method="bumblebee.owner_id"
                            change-method="changed"
                            explanation="Must be a pool owner"
                            select-heading="-- Select Owner by Name"
                            allow-edit={{$allow_edit}} />

                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach

                        <x-forms.field-input-select-end
                            explanation="Must be a pool owner"/>


                        <x-forms.field-input-date
                            label="Assigned to Owner Date"
                            model-method="bumblebee.assigned_to_owner_on"
                            change-method="changed"
                            explanation="date the unit was assigned to this owner"
                            allow-edit={{$allow_edit}} />

                        <x-forms.field-input-select-start
                            label="Service Status"
                            model-method="bumblebee.removed_from_service"
                            change-method="changed"
                            explanation="is the unit still be used in field"
                            select-heading=""
                            allow-edit={{$allow_edit}} />

                        <option value="0">In Service</option>
                        <option value="1">Out of Service</option>

                        <x-forms.field-input-select-end
                            explanation="is the unit still be used in field"/>


                        <x-forms.field-input-password
                            label="API Password"
                            model-method="new_password"
                            change-method="changed"
                            placeholder=""
                            explanation="leave blank to NOT change, at least 6 characters"
                            allow-edit={{$allow_edit}} />


                        <x-forms.field-display-only
                            label="API Remember Token"
                            value="{{ $bumblebee->remember_token }}" />

                        <x-forms.field-display-only
                            label="Created at"
                            value="{{ $bumblebee->created_at }}" />

                        <x-forms.field-display-only
                            label="Updated at"
                            value="{{ $bumblebee->updated_at }}" />

                    </div>

                </form>

                <!-- Errors Display Markup -->
                @if ($errors->any())
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

            </div>


        </div>

    </div>

</div>
