@props(['measurement', 'showActions' => 0, 'method' => 'all', 'scaledColorimetric' => 0])

<table class="table-auto mb-6 bg-gray-50 w-full">

    @php($measurement->colorimetricMethod() ? $method = 'colorimetric' : $method = 'probe')
    <x-measurement-table-header :method="$method"></x-measurement-table-header>

    <tbody>
        <x-measurement-table-row :measurement="$measurement" :method="$method" :show-actions="$showActions" :scaled-colorimetric="$scaledColorimetric"></x-measurement-table-row>
    </tbody>

</table>

