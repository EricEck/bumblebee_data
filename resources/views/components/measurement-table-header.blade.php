@props(['showActions' => 0, 'method' => 'all'])

<thead>
    <tr>
        <th colspan="7"></th>

        @if($method == "all" | $method == "auto" | $method == "colorimetric" )
            <th colspan="10" class="border bg-indigo-50">COLORIMETRIC DATA</th>
        @endif
        @if($method == "all" | $method == "auto" | $method == "probe" | $method == "")
            <th colspan="2" class="border bg-blue-100">Probe</th>
        @endif
        <th colspan="2" class="border bg-gray-200 text-xs">MEASUREMENT</th>

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
        @if($method == "all" | $method == "auto" | $method == "colorimetric" )
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
        @if($method == "all" | $method == "auto" | $method == "probe" | $method == "")
            <th class=" bg-blue-100">VOLT</th>
            <th class=" bg-blue-100">Unit</th>
        @endif
        <th class=" bg-gray-200">Actual</th>
        <th class=" bg-gray-200">Unit</th>


        @if($showActions)
            <th class="">Actions</th>
        @endif
    </tr>
</thead>
