<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/svg" href="{{ asset('images/EW-LOGO_ns.svg') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @livewireStyles
{{--        @powerGridStyles--}}

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>  <!--Alpine JS v3 from official CDN-->

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-indigo-50">
            <!-- Navigation is sticky -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow ">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>

{{--            @if(isset($secondary))--}}
{{--                <sub>--}}
{{--                    <div class="py-6">--}}
{{--                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                                <div class="p-6 bg-white border-b border-gray-200">--}}
{{--                                    {{ $secondary ?? ''}}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </sub>--}}
{{--            @endif--}}


        </div>

        @livewireScripts

{{--        <livewire:contact-modal />--}}
{{--        <livewire:some-other-modal />--}}
    </body>
</html>
