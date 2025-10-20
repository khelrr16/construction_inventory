<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<header x-data="{ open: false }" class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo / Title -->
            <div class="flex-shrink-0">
                <a href="" class="text-xl font-bold text-gray-800">
                    MyApp
                </a>
            </div>

            <!-- Desktop Links -->
            <nav class="hidden md:flex space-x-6 items-center">
                <a href="" class="text-gray-700 hover:text-blue-500">Dashboard</a>
                <a href="" class="text-gray-700 hover:text-blue-500">Users</a>
                <span class="text-gray-500">|</span>
                <span class="text-sm font-medium text-gray-600">
                    Code: <span class="font-bold text-gray-800">{{ auth()->user()->employeeCode() ?? 'N/A' }}</span>
                </span>
                <form method="POST" action="">
                    @csrf
                    <button type="submit" class="ml-4 text-sm text-red-500 hover:text-red-700">Logout</button>
                </form>
            </nav>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" @click.away="open = false" class="md:hidden bg-white border-t border-gray-200">
        <nav class="px-2 pt-2 pb-4 space-y-1">
            <a href="" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">Dashboard</a>
            <a href="" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">Users</a>
            <div class="px-3 py-2 text-sm text-gray-600">
                Code: <span class="font-bold text-gray-800">{{ auth()->user()->employeeCode() ?? 'N/A' }}</span>
            </div>
            <form method="POST" action="">
                @csrf
                <button type="submit" class="block w-full text-left px-3 py-2 rounded text-sm text-red-500 hover:bg-gray-100">Logout</button>
            </form>
        </nav>
    </div>
</header>

