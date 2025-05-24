<div>
  <!-- Поиск -->
  <div class="flex-1 mx-4 max-w-lg items-center justify-center m-4">
    <div class="relative ">
      <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 top-2.5 left-2.5 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
      </svg>
      <input wire:model="searchInput" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md pl-10 pr-3 py-2 shadow-sm transition-all duration-900  hover:border-indigo-600 focus:outline-none focus:border-indigo-600  focus:shadow" placeholder="Input name product...(min 3 symbol)" />
    </div>
  </div>
<div class="relative flex flex-col w-full max-w-full max-h-[600px] overflow-auto text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
    <div class="w-full ">       
      
         <table class="w-full text-left table-auto">
          <thead class=" sticky top-0 z-10">
            <tr >
              <th class="p-4 border-b border-slate-300 bg-slate-50 ">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Id
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Name
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Description
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Price
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Colors
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Category
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500">
                  Subcategory/ies
                </p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500"></p>
              </th>
              <th class="p-4 border-b border-slate-300 bg-slate-50">
                <p class="block text-sm font-normal leading-none text-slate-500"></p>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
                <tr class="hover:bg-slate-50">
                <td class="p-4 border-b border-r border-indigo-200">
                    <p class="block text-sm text-slate-800">
                    {{$product->id}}
                    </p>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <p class="block text-sm text-slate-800">
                        {{$product->name}}
                    </p>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <p class="block text-sm text-slate-800">
                        {{$product->description}}
                    </p>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <p class="block text-sm text-slate-800">
                        {{$product->price}}
                    </p>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <p class="block text-sm text-slate-800">
                        @foreach ($product->colors as $color)
                          @if($color->pivot->stock > 0)
                            {{$color->name}},   
                          @endif
                        @endforeach
                    </p>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <p class="block text-sm text-slate-800">
                        {{$product->subcategories->first()->category->name}}
                    </p>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                  <p class="block text-sm text-slate-800">
                      @foreach ($product->subcategories as $subcategory)
                      {{$subcategory->name}},   
                      @endforeach
                      
                  </p>
              </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <a href="#" wire:click = "editingProduct({{$product->id}})" class="block text-sm font-semibold text-slate-800">
                    Edit
                    </a>
                </td>
                <td class="p-4 border-b border-r border-indigo-200">
                    <a href="#" wire:click = "deleteProduct({{$product->id}})" class="block text-sm font-semibold text-slate-800">
                    Delete
                    </a>
                </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    
    
</div>

<div>
  {{-- Модалка внутри @if --}}
  @if($showModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center">
      {{-- Фон --}}
      <div
         wire:click="$set('showModal', false)"
        class="absolute inset-0 bg-black bg-opacity-50"
      ></div>

      {{-- Окно --}}
      <div class="bg-white rounded-lg shadow-lg w-full max-w-lg mx-4 p-6 relative z-50       max-h-[80vh] overflow-y-auto">
        {{-- Заголовок и крестик --}}
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold">Редактировать товар</h2>
          <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
            &times;
          </button>
        </div>

        {{-- Форма --}}
        <form wire:submit.prevent="update" class="space-y-4">
          {{-- Название --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Название</label>
            <input
              type="text"
              wire:model.defer="name"
              class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
            @error('product.name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>

          {{-- Описание --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
            <textarea
              wire:model.defer="description"
              rows="3"
              class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
          </div>

          {{-- Цена --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Цена</label>
            <input
              type="number"
              step="1"
              min="1"
              wire:model.defer="price"
              class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
            @error('product.price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>

          {{-- Категория --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Категория</label>
            <select
              wire:model="categoryId"
              class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"
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
            <div class="space-y-2">
              @foreach($allColors as $color)
                <div class="flex items-center space-x-4">
                  <span class="w-32">{{ $color->name }}</span>
                  <input
                    type="number"
                    min="0"
                    wire:model.defer="colorStocks.{{ $color->id }}"
                    class="w-24 border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              @endforeach
            </div>
          </div>

          {{-- Кнопки --}}
          <div class="flex justify-end space-x-2 pt-4 border-t">
            <button
              type="button"
              wire:click="closeModal"
              class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
            >Отмена</button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >Сохранить</button>
          </div>
        </form>
      </div>
    </div>
  @endif
  
</div>
</div>