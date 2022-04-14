<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <!-- Returned Table Data -->
    @php($bowComponents = $bow->bowComponents)
    @if(count($bowComponents) > 0)

        <table class="table-auto w-full mb-6 border border-indigo-200">

            <x-tables.bow-component-table-header
                :show-actions=true
                :show_bow="true"/>
            <tbody class="border-blue-500">
            @foreach($bowComponents as $bowComponent)
                <x-tables.bow-component-table-row
                    :show-actions="true"
                    :show-bow="true"
                    :bow-component="$bowComponent"/>
            @endforeach
            </tbody>
        </table>

{{--        {!! $components->links() !!}--}}
    @else
        <p class="text-center py-2 text-xl">Sorry!  No pieces parts!!!  (No Components found...)   😿</p>
    @endif
</div>
