@extends('layouts.app')

@section('content')
    
    <div class="text-center p-10">
        <h1 class="font-bold text-4xl mb-4">Responsive Product card grid</h1>
    </div>
    @livewire('home-product-list') {{-- это наш компонент --}}

@endsection
