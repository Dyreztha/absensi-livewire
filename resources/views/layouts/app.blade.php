<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Attendify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .attendify-gradient {
            background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
        }
        .attendify-gradient-hover:hover {
            background: linear-gradient(135deg, #1D4ED8 0%, #6D28D9 100%);
        }
        .attendify-text-gradient {
            background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #2563EB, #7C3AED);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b-2 border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo & Brand -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Attendify Logo" class="h-12 w-12 object-contain transform group-hover:scale-110 transition-transform duration-300">
                        <div>
                            <h1 class="text-2xl font-extrabold attendify-text-gradient">Attendify</h1>
                            <p class="text-xs text-gray-500 -mt-1">Smart Attendance System</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('dashboard') ? 'active text-blue-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('attendance.clock') }}" class="nav-link flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('attendance.clock') ? 'active text-blue-600' : '' }}">
                        <img src="{{ asset('images/icon-clock.png') }}" alt="Clock" class="w-5 h-5 object-contain">
                        Clock In/Out
                    </a>

                    <a href="{{ route('attendance.history') }}" class="nav-link flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('attendance.history') ? 'active text-blue-600' : '' }}">
                        <img src="{{ asset('images/icon-history.png') }}" alt="History" class="w-5 h-5 object-contain">
                        History
                    </a>
                </div>

                <!-- Mobile Menu Toggle Button -->
                <button id="mobileMenuToggle" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <img src="{{ asset('images/icon-menu.png') }}" alt="Menu" class="w-6 h-6 object-contain">
                </button>

                <!-- User Dropdown -->
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-3 px-4 py-2 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-100">
                        <div class="w-10 h-10 attendify-gradient rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-medium transition-colors border border-red-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="md:hidden hidden pb-4 space-y-2 animate-slideDown">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('attendance.clock') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('attendance.clock') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <img src="{{ asset('images/icon-clock.png') }}" alt="Clock" class="w-5 h-5">
                    Clock In/Out
                </a>
                <a href="{{ route('attendance.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('attendance.history') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <img src="{{ asset('images/icon-history.png') }}" alt="History" class="w-5 h-5">
                    History
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Attendify" class="h-10 w-10">
                    <div>
                        <p class="font-bold text-gray-900">Attendify</p>
                        <p class="text-xs text-gray-500">Smart Attendance System</p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-sm text-gray-600">© {{ date('Y') }} Attendify. All rights reserved.</p>
                    <p class="text-xs text-gray-500 mt-1">Built with ❤️ using Laravel & Livewire</p>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });

                // Close menu when a link is clicked
                const menuLinks = mobileMenu.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                    });
                });
            }
        });
    </script>
</body>
</html>
