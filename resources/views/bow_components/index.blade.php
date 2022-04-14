<x-app-layout>
    <x-slot name="header">
        <div class="flow-root">
            <div class="float-left">
                {{ request()->get('niblet') ?? 'Body of Water Components'}}
            </div>
            @if(isset($showBack))
                <div class="float-right">
                    <a href="javascript:history.back()"><x-buttons.back/></a>
                </div>
            @endif
        </div>
    </x-slot>

    @php($bowComponents = \App\Models\BowComponent::all())
    @if(count($bowComponents))

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

    @else

        <p class="text-center py-2 text-xl">Sorry!  No pieces parts!!!  (No Components found...)   😿</p>
    @endif
</x-app-layout>
