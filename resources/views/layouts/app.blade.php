<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Shop') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
  

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles
    
</head>
<body class="bg-gray-50">
    <div id="app">
        <!-- Навигация -->
        <nav class="fixed top-0 left-0 w-full bg-white shadow relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Логотип -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800 hover:text-gray-600">
                            {{ config('app.name', 'Shop') }}
                        </a>
                    </div>
                    <!-- Ссылки -->
                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                                {{ __('Login') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            {{-- <span class="text-gray-700">{{ Auth::user()->name }}</span> --}}
                            <div class="relative group">
                                <a type="button" class="group inline-flex items-center  text-sm font-medium text-gray-700  hover:text-gray-900 cursor-pointer" id="menu-button">
                                    {{ Auth::user()->name }}
                                    <svg class="-mr-1 ml-1 h-5 w-5 text-gray-400 transition-all duration-500 group-hover:text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                  </a>
                                <!-- Меню открывается при наведении на родительский элемент или сам список -->
                                <div class="absolute right-0 mt-0 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black/5 z-50 opacity-0 group-hover:opacity-100 group-hover:block hidden transition-opacity">
                                    <div class="py-1 mt-2">
                                        @if ((Auth::user())&&(Auth::user()->role =='admin'))
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 font-medium transition-all duration-900  hover:text-indigo-500">
                                                Admin
                                                </a>
                                         @endif
                                        <a href="{{ route('cart.show') }}" class="block px-4 py-2 text-sm text-gray-700  font-medium transition-all duration-900  hover:text-indigo-500">
                                            Cart
                                        </a>
                                        <a href="{{ route('orders.show') }}" class="block px-4 py-2 text-sm text-gray-700 font-medium transition-all duration-900  hover:text-indigo-500">
                                            Orders
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 transition-all duration-900 font-medium hover:text-indigo-500">
                                                {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                            
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <div class="">
            @yield('adminSideBar')
        </div>
        <!-- Основное содержимое -->
        <main class="py-6">
            
            <div class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
        
    </div>

    
    @livewireScripts
    @stack('scripts')
    
</body>
</html>
