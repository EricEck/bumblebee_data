@props('errors')
{{-- Must check if $errors->any() prior to loading this --}}

<div class="bg-red-700 m-4 py-4 px-4 border border-1 border-red-900 shadow-md shadow-gray-500">
    <h1 class="text-xl text-white">Entry Errors(s)</h1>
    <ul>
        @foreach ($errors->all() as $error)
            <li class="px-10 text-white">==> {{ $error }}</li>
        @endforeach
    </ul>
</div>

