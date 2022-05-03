<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-xl">Welcome {{ Auth::user()->name }} to Elliptic Works'  Elliptic Einstein Cloud System</h2>
                <div style="color: #6b7280" class="mt-8 ml-12 mb-4">
                    <p>Application Version: {{config('app.name').' v'.config('app.app_version')}}</p>
                    <p>Laravel Framework: v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                    <p>✉ <a href="mailto:eeckstein@ellpticworks.com">click here to email Eric with any questions/issues</a></p>
                    <p>© 2022 Elliptic Works, LLC - All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
