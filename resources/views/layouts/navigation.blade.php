<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-white border-b border-gray-100">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Top Horizontal Menu Items -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden z-50 space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')"  :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- Elliptic Products -->
                <div class="hidden z-50 space-x-8 sm:flex sm:items-center sm:ml-10 sm:flex">
                    <x-dropdown width="48">
                        <x-slot name="trigger">
                            <x-nav-link  :active="request()->routeIs('bumblebees_table')
                            |request()->routeIs('elliptic_product_list')
                            |request()->routeIs('elliptic_product_new')">
                                {{ __('Elliptic Products') }}
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-nav-link>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('elliptic_product_list')" :active="request()->routeIs('elliptic_product_list')">
                                {{ __('All Elliptic Products') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('elliptic_product_new')" :active="request()->routeIs('elliptic_product_new')">
                                {{ __('New Elliptic Product') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('bumblebees_table')" :active="request()->routeIs('bumblebees_table')">
                                {{ __('All Bumblebees') }}
                            </x-dropdown-link>

                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- People, Places -->
                <div class="hidden z-50 space-x-8 sm:flex sm:items-center sm:ml-10 sm:flex">
                    <x-dropdown width="48">
                        <x-slot name="trigger">
                            <x-nav-link
                                :active="request()->routeIs('users_table')
                                    |request()->routeIs('users_table')
                                    |request()->routeIs('body_of_water_edit')
                                    |request()->routeIs('body_of_water_new')
                                    |request()->routeIs('bodies_of_water')
                                    |request()->routeIs('bow_components_all')
                                    |request()->routeIs('user_form_edit')
                                    |request()->routeIs('user_form_new')
                                    |request()->routeIs('user_form_show')">
                                {{ __('People & Places') }}
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-nav-link>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('users_table')" :active="request()->routeIs('users_table')">
                                {{ __('All Users') }}
                            </x-dropdown-link><br>
                            <x-dropdown-link :href="route('user_form_new')" :active="request()->routeIs('user_form_new')">
                                {{ __('New User') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('bodies_of_water')" :active="request()->routeIs('bodies_of_water')">
                                {{ __('All Bodies of Water') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('body_of_water_new')" :active="request()->routeIs('body_of_water_new')">
                                {{ __('New Body of Water') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('bow_components_all')" :active="request()->routeIs('bow_components_all')">
                                {{ __('All BoW Components') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Measurements -->
                <div class="hidden z-50 space-x-8 sm:flex sm:items-center sm:ml-10 sm:flex">
                    <x-dropdown width="48">
                        <x-slot name="trigger">
                            <x-nav-link
                                :active="request()->routeIs('measurementFormNew')
                                    |request()->routeIs('measurementBow')
                                    |request()->routeIs('calibrationTable')
                                    |request()->routeIs('measurements_table')
                                    |request()->routeIs('measurements_table_actual')">
                                {{ __('Measurements') }}
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </x-nav-link>
                        </x-slot>

                        <x-slot name="content">

                            <x-dropdown-link :href="route('measurementBow')" :active="request()->routeIs('measurementBow')">
                                {{ __('Measurements for a BoW') }}
                            </x-dropdown-link><br>
                            <x-dropdown-link :href="route('measurements_table')" :active="request()->routeIs('measurements_table')">
                                {{ __('All Measurements') }}
                            </x-dropdown-link><br>
                            <x-dropdown-link :href="route('measurements_table_actual')" :active="request()->routeIs('measurements_table_actual')">
                                {{ __('Actual/Calibrated Measurements') }}
                            </x-dropdown-link><br/>
                            <x-dropdown-link :href="route('measurementFormNew')" :active="request()->routeIs('measurementFormNew')">
                                {{ __('New Measurement') }}
                            </x-dropdown-link><br>
                            <x-dropdown-link :href="route('calibrationTable')" :active="request()->routeIs('calibrationTable')">
                                {{ __('Bumblebee Calibrations') }}
                            </x-dropdown-link><br/>
                        </x-slot>
                    </x-dropdown>
                </div>

            </div>

            <!-- Right Side Top Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        @permission('laratrust_panel-read')
                        <x-dropdown-link href="/laratrust" >
                                Laratrust
                        </x-dropdown-link><br>
                        @endpermission
                        @permission('profile-read')
                        <x-dropdown-link
                            :href="route('profile')"
                            :active="request()->routeIs('profile')">
                            {{ __('Profile') }}
                        </x-dropdown-link><br>
                        @endpermission
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>
