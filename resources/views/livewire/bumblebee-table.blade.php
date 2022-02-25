<div>
    {{-- The whole world belongs to you. --}}

    <div class="w-full flex pb-10">
        <div class="w-3/6 mx-1">
            <input wire:model.debounce.700ms="searchString" type="text"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   placeholder="Search bumblebees...">
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="name">Serial Number</option>
                <option value="id">ID</option>
                <option value="email">Current Version</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderAscending" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="1">Ascending</option>
                <option value="0">Descending</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="usersPerPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option selected>10</option>
                <option>15</option>
                <option>25</option>
                <option>50</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </div>

    @if(count($bumblebees) )
        <table class="table-auto w-full mb-6">
            <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Serial Number</th>
                <th class="px-4 py-2">Mfg on</th>
                <th class="px-4 py-2">Version</th>
                <th class="px-4 py-2">Owner</th>
                <th class="px-4 py-2">Last Measurement</th>
                <th class="px-4 py-2">Updated At</th>
                <th class="px-4 py-2">Created At</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bumblebees as  $bumblebee)
                @php($owner = $bumblebee->owner)
                @php($lastMeasurement = $bumblebee->measurements->last())
                <tr>
                    <td class="border px-4 py-2">{{ $bumblebee->id }}</td>
                    <td class="border px-4 py-2">{{ $bumblebee->serial_number }}</td>
                    <td class="border px-4 py-2">{{ $bumblebee->manufactured_date }}</td>
                    <td class="border px-4 py-2">{{ $bumblebee->current_version }}</td>
                    <td class="border px-4 py-2">{{ $owner->name }}</td>
                    <td class="border px-4 py-2">{{ $lastMeasurement->created_at->diffForHumans() }}</td>
                    <td class="border px-4 py-2">{{ $bumblebee->updated_at->diffForHumans() }}</td>
                    <td class="border px-4 py-2">{{ $bumblebee->created_at->diffForHumans() }}</td>
                    <td class="border px-4 py-2 flex-auto">
                        <a wire:click="" ><x-buttons.measurement></x-buttons.measurement></a>
                        <a wire:click="bumblebeeFormShow({{ $bumblebee->id }})"  ><x-buttons.view ></x-buttons.view></a>
                        <a wire:click="bumblebeeFormEdit({{ $bumblebee->id }})"  ><x-buttons.edit></x-buttons.edit></a>
{{--                        <a wire:click="userFormEdit({{$bumblebee->id}})"  ><x-buttons.edit></x-buttons.edit></a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Sorry!   No buzzing... No Bumblebees found...   😿</p>
    @endif


</div>
