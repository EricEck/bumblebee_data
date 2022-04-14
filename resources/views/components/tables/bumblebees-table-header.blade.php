@props(['showActions' => 0])

<thead>
    <tr class="bg-blue-100 font-thin text-sm">
        <th class="border-2 border-white">ID</th>
        <th class="border-2 border-white">Serial Number</th>
        <th class="border-2 border-white">Mfg on</th>
        <th class="border-2 border-white">Version</th>
        <th class="border-2 border-white">Elliptic<br/>Product</th>
        <th class="border-2 border-white">Owner</th>
        <th class="border-2 border-white">In Service</th>
        <th class="border-2 border-white">Body of<br/>Water</th>
        <th class="border-2 border-white">Last Measurement</th>
        <th class="border-2 border-white">Updated At</th>
        <th class="border-2 border-white">Created At</th>
        @if($showActions)
            <th class="border-2 border-white">Actions</th>
        @endif
    </tr>
</thead>

