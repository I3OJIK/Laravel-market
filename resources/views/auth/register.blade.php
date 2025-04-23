@extends('layouts.app')

@section('content')
<main class="container mx-auto p-4 mt-12 bg-white flex flex-col items-center justify-center text-gray-700">
  {{-- Заголовок --}}
  <div class="w-10/12 sm:w-8/12 md:w-6/12 lg:w-5/12 xl:w-4/12 mb-6">
    <h1 class="text-4xl font-semibold text-center">
      {{ __('Register') }}
    </h1>
  </div>

  {{-- Форма --}}
  <form method="POST"
        action="{{ route('register') }}"
        class="w-10/12 sm:w-8/12 md:w-6/12 lg:w-5/12 xl:w-4/12 space-y-4">
    @csrf

    {{-- Name --}}
    <div>
      <input id="name"
             name="name"
             type="text"
             value="{{ old('name') }}"
             required
             autofocus
             placeholder="{{ __('Name') }}"
             class="block w-full p-2 bg-gray-200 placeholder-gray-900 rounded border 
                    focus:outline-none focus:ring-2 focus:ring-teal-500
                    @error('name') border-red-500 @else border-gray-300 @enderror" />
      @error('name')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
      @enderror
    </div>

    {{-- E-Mail Address --}}
    <div>
      <input id="email"
             name="email"
             type="email"
             value="{{ old('email') }}"
             required
             placeholder="{{ __('E-Mail Address') }}"
             class="block w-full p-2 bg-gray-200 placeholder-gray-900 rounded border 
                    focus:outline-none focus:ring-2 focus:ring-teal-500
                    @error('email') border-red-500 @else border-gray-300 @enderror" />
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
             class="block w-full p-2 bg-gray-200 placeholder-gray-900 rounded border 
                    focus:outline-none focus:ring-2 focus:ring-teal-500
                    @error('password') border-red-500 @else border-gray-300 @enderror" />
      @error('password')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
      @enderror
    </div>

    {{-- Confirm Password --}}
    <div>
      <input id="password-confirm"
             name="password_confirmation"
             type="password"
             required
             placeholder="{{ __('Confirm Password') }}"
             class="block w-full p-2 bg-gray-200 placeholder-gray-900 rounded border 
                    focus:outline-none focus:ring-2 focus:ring-teal-500 border-gray-300" />
    </div>

    {{-- Submit --}}
    <div class="flex justify-center">
      <button type="submit"
              class="w-full bg-teal-600 text-white py-2 px-4 rounded font-semibold 
                     hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
        {{ __('Register') }}
      </button>
    </div>
  </form>
</main>
@endsection
