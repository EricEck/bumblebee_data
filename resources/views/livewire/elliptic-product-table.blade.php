<div>
    {{-- Do your work, then step back. --}}

    @if(count($ellipticProducts) )
        <table class="table-auto w-full mb-6 border border-indigo-200">
            <x-tables.elliptic-product-table-header :show-actions="true"/>
            <tbody>
            @foreach($ellipticProducts as $ellipticProduct)
                <x-tables.elliptic-product-table-row
                    :show-actions="true"
                    :elliptic-product="$ellipticProduct"/>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Sorry!   No stuff... No Elliptic Products found...   😿</p>
    @endif

</div>
