<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <!-- Returned Table Data -->
    @if(count($components) == 0)

        <table class="table-auto w-full mb-6 border border-indigo-200">

            <x-bow-component-table-header :show-actions="1" />
            <tbody class="border-blue-500">
            @foreach($components as $component)
                <x-bow-component-table-row :bow="$bow" :show-actions="1" :show-bow="false" />
            @endforeach
            </tbody>
        </table>

{{--        {!! $components->links() !!}--}}
    @else
        <p class="text-center py-2 text-xl">Sorry!  No pieces parts!!!  (No Components found...)   😿</p>
    @endif
</div>
