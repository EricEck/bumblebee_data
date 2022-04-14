<div>
    {{-- Be like water. --}}

    <!-- Returned Table Data -->
        @if(count($bows))

            <table class="table-auto w-full mb-6 border border-indigo-200">

                <x-tables.bow-table-header :show-actions="1" />
                <tbody class="border-blue-500">
                @foreach($bows as $bow)
                    <x-tables.bow-table-row :bow="$bow" :show-actions="1" />
                @endforeach
                </tbody>
            </table>

{{--            {!! $bows->links() !!}--}}
        @else
            <p class="text-center">Sorry!   We need a recount... No Bodies of Water found...   😿</p>
        @endif
</div>
