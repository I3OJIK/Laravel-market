<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление товара</title>
    @livewireStyles
</head>
<body>

    <h1>Добавить товар</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @livewire('create-product') {{-- это наш компонент --}}

    @livewireScripts
</body>
</html>
