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
                        <a href="{{ route('cart.show') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Cart
                            </a>
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
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Основное содержимое -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
                @livewireScripts   

            </div>
        </main>
    </div>
</body>
</html>
