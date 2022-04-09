@props(['showActions' => 0])

<thead>
    <tr class="bg-blue-100 font-thin text-sm">
        <th class="border-2 border-white">ID</th>
        <th class="border-2 border-white">Model</th>
        <th class="border-2 border-white">Bumblebee</th>
        <th class="border-2 border-white">Serial<br>Number</th>
        <th class="border-2 border-white">Manufacture<br>Date</th>
        <th class="border-2 border-white">Manufacturer</th>
        <th class="border-2 border-white">Owner</th>
        <th class="border-2 border-white">Body of<br>Water</th>
        <th class="border-2 border-white">Current<br>Construction Version</th>
        <th class="border-2 border-white">Current<br>Software Version</th>

        @if($showActions)
            <th class="border-2 border-white">Actions</th>
        @endif
    </tr>
</thead>
