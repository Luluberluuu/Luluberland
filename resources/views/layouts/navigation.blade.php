<nav x-data="{ open: false }" class="h-screen">
    <!-- Primary Navigation Menu -->
    <div class="flex flex-col items-center h-screen py-6">
        <!-- Logo -->
        {{--<div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}" class="p-8">
                <x-application-logo class="block" />
            </a>
        </div>--}}

        <!-- Navigation Links -->
        <div class="flex flex-col justify-center items-center mb-12">
            <a href="#"><img src="{{ asset('images/l-key.png') }}" width="50"></a>
        </div>
        <div class="flex flex-col space-y-3 justify-center items-center">
            <div class="p-2 bg-noirlight border-2 border-noirlight rounded-2xl transition duration-300 hover:border-global hover:-translate-y-0.5">
                <a href="{{ route('dashboard') }}"><img src="{{ asset('images/grid-icon.png') }}" width="25"></a>
            </div>
            <div class="p-2 bg-noirlight border-2 border-noirlight rounded-2xl transition duration-300 hover:border-global hover:-translate-y-0.5">
                <a href="#"><img src="{{ asset('images/game-controller-2.png') }}" width="25"></a>
            </div>
            <div class="p-2 bg-noirlight border-2 border-noirlight rounded-2xl transition duration-300 hover:border-global hover:-translate-y-0.5">
                <a href="#"><img src="{{ asset('images/play.png') }}" width="25"></a>
            </div>
            <div class="p-2 bg-noirlight border-2 border-noirlight rounded-2xl transition duration-300 hover:border-global hover:-translate-y-0.5">
                <a href="{{ route('search.index') }}"><img src="{{ asset('images/search.png') }}" width="25"></a>
            </div>
            <div class="p-2 bg-noirlight border-2 border-noirlight rounded-2xl transition duration-300 hover:border-global hover:-translate-y-0.5">
                <a href="#"><img src="{{ asset('images/user.png') }}" width="25"></a>
            </div>
        </div>
        <div class="flex flex-col justify-center items-center mt-auto p-2 bg-noirlight border-2 border-noirlight rounded-2xl transition duration-300 hover:border-global hover:-translate-y-0.5">
            <a href="#"><img src="{{ asset('images/log-out.png') }}" width="25"></a>
        </div>
    </div>

    <!-- Settings Dropdown -->
    {{--<div class="hidden sm:flex sm:items-center sm:ms-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

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
    </div>--}}

</nav>
