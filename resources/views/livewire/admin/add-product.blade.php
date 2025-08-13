<div class="  mt-2">
    <h2 class="text-2xl font-semibold mb-6">Добавить товар</h2>
    {{-- <img src="{{ asset('storage/images/7siLcX6LRAYNPxQ8HpWyyI2yYkIOBIiGdUdiG0p5.jpg') }}" alt="Фото товара"> --}}
    @if (session()->has('success'))
      <div class="bg-green-100 text-green-800 p-2 rounded">
          {{ session('success') }}
      </div>
    @endif
    @if (session()->has('error'))
      <div class="bg-red-100 text-red-800 p-2 rounded">
          {{ session('error') }}
      </div>
    @endif
    <form wire:submit.prevent="create" class="space-y-6" enctype="multipart/form-data">
      {{-- Название --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Название</label>
        <input
          type="text"
          wire:model.defer="name"
          class="w-full border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-1"
        />
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>
  
      {{-- Описание --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
        <textarea
          wire:model.defer="description"
          rows="3"
          class="w-full border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-1"
        ></textarea>
      </div>
  
      {{-- Цена --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Цена</label>
        <input
          type="number"
          min="1"
          wire:model.defer="price"
          class="w-full border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-1"
        />
        @error('price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>
  
      {{-- Фото --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Фото</label>
        <input
          type="file"
          wire:model="image"
          class="w-full"
        />
        @error('image') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
  
        {{-- Предпросмотр --}}
        @if ($image)
          <img src="{{ $image->temporaryUrl() }}" class="w-32 mt-2 rounded shadow">
        @endif
      </div>
  
      {{-- Категория --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Категория</label>
        <select
          wire:model="categoryId"
          class="w-full border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-1"
        >
          <option value="">— выберите —</option>
          @foreach($allCategories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
  
      {{-- Подкатегории --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Подкатегории</label>
        <div class="grid grid-cols-2 gap-2">
          @foreach($subcategories as $subcategory)
            <label class="flex items-center space-x-2">
              <input
                type="checkbox"
                wire:model.defer="subcategoryIds"
                value="{{ $subcategory->id }}"
                class="form-checkbox h-4 w-4 text-blue-600"
              />
              <span>{{ $subcategory->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
  
      {{-- Цвета и остатки --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Остатки по цветам</label>
        <div class="grid grid-cols-2 gap-4">
          @foreach($allColors as $color)
            <div class="flex items-center space-x-4">
              <span class="w-32">{{ $color->name }}</span>
              <input
                type="number"
                min="0"
                wire:model.defer="colorStocks.{{ $color->id }}"
                class="w-24 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 "
              />
            </div>
          @endforeach
        </div>
      </div>
  
      {{-- Кнопка --}}
      <div class="flex justify-end">
        <button
          type="submit"
          class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >Сохранить</button>
      </div>
    </form>
</div>
  