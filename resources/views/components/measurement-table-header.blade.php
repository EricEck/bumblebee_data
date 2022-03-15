@props(['showActions' => 0, 'method' => 'all', 'types' => 0])

<thead>
    <tr>
        <th colspan="7"></th>

        @if(($method == "all" | $method == "auto" | $method == "colorimetric") && $types < 3 )
            <th colspan="10" class="border bg-indigo-50">COLORIMETRIC DATA</th>
        @endif
        @if(($method == "all" | $method == "auto" | $method == "probe" | $method == "") && $types < 3)
            <th colspan="2" class="border bg-blue-100">Probe</th>
        @endif
        <th colspan="3" class="border bg-blue-200 text-xs">ACTUAL</th>

        @if($showActions)
            <th></th>
        @endif
    </tr>
    <tr>
        <th class="">ID</th>
        <th class="">Time<br>Stamp</th>
        <th class="">BB<br>Unit</th>
        <th class="">Cal?</th>
        <th class="">Method</th>
        <th class="">Seq</th>
        <th class="">Metric</th>
        @if(($method == "all" | $method == "auto" | $method == "colorimetric") && $types < 3 )
            <th class=" bg-indigo-50">VIO</th>
            <th class=" bg-indigo-50">IND</th>
            <th class=" bg-indigo-50">BLU</th>
            <th class=" bg-indigo-50">CYN</th>
            <th class=" bg-indigo-50">GRN</th>
            <th class=" bg-indigo-50">YLW</th>
            <th class=" bg-indigo-50">ORG</th>
            <th class=" bg-indigo-50">RED</th>
            <th class=" bg-indigo-50">IRD</th>
            <th class=" bg-indigo-50">CLEAR</th>
        @endif
        @if(($method == "all" | $method == "auto" | $method == "probe" | $method == "") && $types < 3)
            <th class=" bg-blue-100">VOLT</th>
            <th class=" bg-blue-100">Unit</th>
        @endif
        <!-- Calibrated or Manual Methods -->

        <th class=" bg-gray-100 text-xs">Cal#</th>
        <th class=" bg-gray-100 text-xs">Value</th>
        <th class=" bg-gray-100 text-xs">Unit</th>


        @if($showActions)
            <th class="">Actions</th>
        @endif
    </tr>
</thead>
