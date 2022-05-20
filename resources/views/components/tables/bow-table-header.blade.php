@props(['showActions' => 0])

<thead>
    <tr class="bg-blue-100">
        <th class="border-2 border-white">ID</th>
        <th class="border-2 border-white">Primary<br>Owner</th>
        <th class="border-2 border-white">Name</th>
        <th class="border-2 border-white">Address</th>
        <th class="border-2 border-white">Bow<br/>Components</th>
        <th class="border-2 border-white">BB<br>Unit</th>
        <th class="border-2 border-white">Type</th>
{{--        <th class="border-2 border-white">Indoor</th>--}}
{{--        <th class="border-2 border-white">Commercial</th>--}}
        @if($showActions)
            <th class="border-2 border-white">Actions</th>
        @endif
    </tr>
</thead>
