<div>
    
    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form wire:submit.prevent="save">
    <input type="text" wire:model="name" placeholder="Название товара">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="number" wire:model="price" placeholder="Цена">
    @error('price') <span class="error">{{ $message }}</span> @enderror
    
    <input type="text" wire:model="description" placeholder="ОПИСАНИЕ">
    @error('price') <span class="error">{{ $message }}</span> @enderror

    <input type="number" wire:model="stock_quantity" placeholder="КОЛВО">
    @error('price') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Сохранить</button>
</form>
</div>

