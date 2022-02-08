<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full px-6" style="width: 100%">
                        <tbody class="px-10">
                        <tr class="bg-gray-100">
                            <td class="p-2">Name:  </td>
                            <td>{{__(Auth::user()->name)}}</td>
                        </tr>
                        <tr>
                            <td class="p-2">Email:  </td>
                            <td>{{__(Auth::user()->email)}}</td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2">Organization:  </td>
                            <td>{{__(Auth::user()->getUserTeam()->display_name)}}</td>
                        </tr>
                        <tr>
                            <td class="p-2">Roles:  </td>
                            <td>{{__(Auth::user()->getUserRoleNamesWithCommas())}}</td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2">Created:  </td>
                            <td>{{__(Auth::user()->created_at->toDayDateTimeString())}}</td>
                        </tr>
                        <tr>
                            <td class="p-2">Updated:  </td>
                            <td>{{__(Auth::user()->updated_at->toDayDateTimeString())}}</td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
