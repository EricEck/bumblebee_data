@props(['showActions' => 0])

<thead>
    <tr class="bg-blue-100 text-xs font-thin">
        <th class="border-2 border-white ">ID</th>
        <th class="border-2 border-white">In Effect</th>
        <th class="border-2 border-white">Effective<br/>Start</th>
        <th class="border-2 border-white ">Bumblebee<br/>ID</th>
        <th class="border-2 border-white lg:table-cell hidden">Current<br/>BoW ID</th>
        <th class="border-2 border-white md:table-cell hidden">Measurements<br/>Calibrated</th>
        <th class="border-2 border-white md:table-cell hidden">Measurements<br/>Potential</th>
        <th class="border-2 border-white">Metric</th>
        <th class="border-2 border-white">Method</th>
        <th class="border-2 border-white lg:table-cell hidden">Output Units</th>
        <th class="border-2 border-white lg:table-cell hidden">Slope<br/>Coef</th>
        <th class="border-2 border-white lg:table-cell hidden">Offset<br/>Coef</th>
        @if($showActions)
            <th class="border-2 border-white">Actions</th>
        @endif
    </tr>
</thead>
