@extends('layouts.app')

@section('content')
<main class="container mx-auto p-4 mt-12 bg-white flex flex-col items-center justify-center text-gray-700">
  {{-- Заголовок --}}
  <div class="w-10/12 sm:w-8/12 md:w-6/12 lg:w-5/12 xl:w-4/12 mb-4">
    <h1 class="text-4xl font-semibold text-center">
      {{ __('Login') }}
    </h1>
  </div>

  {{-- Форма --}}
  <form method="POST"
        action="{{ route('login') }}"
        class="w-10/12 sm:w-8/12 md:w-6/12 lg:w-5/12 xl:w-4/12 mb-6 space-y-4">
    @csrf

    {{-- Email --}}
    <div >
      <input id="email"
             name="email"
             type="email"
             value="{{ old('email') }}"
             required
             autofocus
             placeholder="{{ __('E-Mail Address') }}"
             class="mb-4 p-2 appearance-none block w-full bg-gray-200 placeholder-gray-900 rounded border focus:border-teal-500" />
      @error('email')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
      @enderror
    </div>

    {{-- Password --}}
    <div>
      <input id="password"
             name="password"
             type="password"
             required
             placeholder="{{ __('Password') }}"
             class="mb-4 p-2 appearance-none block w-full bg-gray-200 placeholder-gray-900 rounded border focus:border-teal-500" />
      @error('password')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
      @enderror
    </div>

    {{-- Remember + Submit --}}
    <div class="flex items-center">
      <div class="flex items-center w-1/2">
        <input id="remember"
               name="remember"
               type="checkbox"
               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
               {{ old('remember') ? 'checked' : '' }} />
        <label for="remember" class="ml-2 block text-sm text-gray-700">
          {{ __('Remember Me') }}
        </label>
      </div>
      <button type="submit"
              class="ml-auto w-1/2 bg-gray-800 text-white p-2 rounded font-semibold 
                     hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
        {{ __('Login') }}
      </button>
    </div>

    {{-- Forgot Password --}}
    @if (Route::has('password.request'))
      <div class="text-right">
        <a href="{{ route('password.request') }}"
           class="text-sm font-bold text-teal-500 hover:underline">
          {{ __('Forgot Your Password?') }}
        </a>
      </div>
    @endif

  </form>
</main>
@endsection
