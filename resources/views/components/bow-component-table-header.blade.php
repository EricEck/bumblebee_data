@props(['showActions' => 0, 'showBoW' => false])

<thead>
    <tr class="bg-blue-100">
        @if($showBoW)
        <th class="border-2 border-white">BoW<br>ID</th>
        <th class="border-2 border-white">BoW<br>Name</th>
        @endif
        <th class="border-2 border-white">Component<br>ID</th>
        <th class="border-2 border-white">Name</th>
        <th class="border-2 border-white">Installed</th>
        <th class="border-2 border-white">Location</th>
        <th class="border-2 border-white">Manufacturer</th>
        <th class="border-2 border-white">Model</th>
        <th class="border-2 border-white">Serial Number</th>
        @if($showActions)
            <th class="border-2 border-white">Actions</th>
        @endif
    </tr>
</thead>
