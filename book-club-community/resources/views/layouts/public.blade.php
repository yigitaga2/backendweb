<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Public Navigation -->
            <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('welcome') }}" class="flex items-center">
                                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                                    <span class="ml-2 text-xl font-bold text-gray-800">Book Club Community</span>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <x-nav-link href="#" :active="request()->routeIs('books.*')">
                                    {{ __('Books') }}
                                </x-nav-link>
                                <x-nav-link href="#" :active="request()->routeIs('news.*')">
                                    {{ __('News') }}
                                </x-nav-link>
                                <x-nav-link href="#" :active="request()->routeIs('faq.*')">
                                    {{ __('FAQ') }}
                                </x-nav-link>
                                <x-nav-link href="#" :active="request()->routeIs('contact.*')">
                                    {{ __('Contact') }}
                                </x-nav-link>
                            </div>
                        </div>

                        <!-- Auth Links -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline mr-4">Log in</a>
                                <a href="{{ route('register') }}" class="text-sm text-gray-700 underline">Register</a>
                            @endauth
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
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
                        <x-responsive-nav-link href="#" :active="request()->routeIs('books.*')">
                            {{ __('Books') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="#" :active="request()->routeIs('news.*')">
                            {{ __('News') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="#" :active="request()->routeIs('faq.*')">
                            {{ __('FAQ') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="#" :active="request()->routeIs('contact.*')">
                            {{ __('Contact') }}
                        </x-responsive-nav-link>
                    </div>

                    <!-- Responsive Auth Links -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        @auth
                            <x-responsive-nav-link :href="route('dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                        @else
                            <x-responsive-nav-link :href="route('login')">
                                {{ __('Log in') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('register')">
                                {{ __('Register') }}
                            </x-responsive-nav-link>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-gray-500 text-sm">
                        © {{ date('Y') }} Book Club Community. Made with ❤️ for book lovers.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
