<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Voorraadbeheer' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">

    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                            Voorraadbeheer
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5
                                  {{ request()->routeIs('home')
                                      ? 'border-indigo-400 text-gray-900'
                                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Home
                        </a>
                        <a href="{{ route('inventory.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5
                                  {{ request()->routeIs('inventory.*')
                                      ? 'border-indigo-400 text-gray-900'
                                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Voorraad
                        </a>
                        <a href="{{ route('klant.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5
                                  {{ request()->routeIs('klant.*')
                                      ? 'border-indigo-400 text-gray-900'
                                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Klant
                        </a>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <span class="text-sm text-gray-500">Magazijnmedewerker</span>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                                   hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100
                                   focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }"
                                  class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M4 6h16M4 12h16M4 20h16"/>
                            <path :class="{'hidden': ! open, 'inline-flex': open }"
                                  class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}"
                   class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition
                          {{ request()->routeIs('home')
                              ? 'border-indigo-400 text-indigo-700 bg-indigo-50'
                              : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    Home
                </a>
                <a href="{{ route('inventory.index') }}"
                   class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition
                          {{ request()->routeIs('inventory.*')
                              ? 'border-indigo-400 text-indigo-700 bg-indigo-50'
                              : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    Voorraad
                </a>
                <a href="{{ route('klant.index') }}"
                   class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition
                          {{ request()->routeIs('klant.*')
                              ? 'border-indigo-400 text-indigo-700 bg-indigo-50'
                              : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                    Klant
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
</body>
</html>
