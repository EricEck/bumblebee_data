<div>
{{-- The best athlete wants his opponent at his best. --}}

    <div wire:loading.delay class="py-3 mx-auto text-lg italic font-bold text-green-500">
        Please Wait, Loading Calibrations....
    </div>

    <div wire:loading wire:target="removeCalibration" class="py-3 mx-auto text-lg italic font-bold text-green-500">
        Please Wait, Removing a Calibration....
    </div>

    <div wire:loading wire:target="runCalibration" class="py-3 mx-auto text-lg italic font-bold text-green-500">
        Please Wait, Running a Calibration....
    </div>
<!-- Returned Table Data -->
    @if(count($calibrations))

        <table class="table-auto w-full mb-6 border border-indigo-200">
            <x-tables.calibration-table-header
                :show-actions="true"/>
            <tbody>
            @foreach($calibrations as $calibration)
                <x-tables.calibration-table-row
                    :calibration="$calibration"
                    :show-actions="true"/>
            @endforeach

            </tbody>
        </table>
    @else
        <p class="text-center">Sorry!   We are without calibrations... No Calibraitons found...   😿</p>
    @endif

</div>
