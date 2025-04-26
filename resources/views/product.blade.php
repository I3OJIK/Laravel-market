@extends('layouts.app')

@section('content')
    
    <div class="text-center p-10">
        <h1 class="font-bold text-4xl mb-4">Responsive Product card grid</h1>
        <h1 class="text-3xl">Tailwind CSS</h1>
    </div>
    @livewire('product-index',['id'=>$id]) {{-- это наш компонент --}}

@endsection
