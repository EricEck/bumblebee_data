@props(['showActions' => 0])

<thead>
    <tr class="bg-blue-100 font-thin text-sm">
        <th class="border-2 border-white">ID</th>
        <th class="border-2 border-white">Name</th>
        <th class="border-2 border-white">Email</th>
        <th class="border-2 border-white">Roles</th>
        <th class="border-2 border-white">Created At</th>

        @if($showActions)
            <th class="border-2 border-white">Actions</th>
        @endif
    </tr>
</thead>

