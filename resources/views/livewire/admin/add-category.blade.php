<div>
    <form wire:submit.prevent="create" class="flex flex-wrap gap-x-8 max-w-full mt-4 items-end">
        {{-- Выбор что добавлять --}}
        <div class="flex flex-col">
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Добавить</label>
            <select id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-2.5 dark:bg-indigo-700 dark:border-indigo-600 
                    dark:placeholder-indigo-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    wire:model.click = "optionAdd">
              <option value="cat">Категория</option>
              <option value="sub">Подкатегория</option>
            </select>
        </div>

        {{-- Категория, если выбрана подкатегория --}}
        @if ($optionAdd == "sub")
            <div class="flex flex-col">
                <label for="parentCategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Принадлежит к категории</label>
                <select id="parentCategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                        focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-2.5 dark:bg-indigo-700 dark:border-indigo-600 
                        dark:placeholder-indigo-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        required
                        wire:model.defer = "selectedCategoryId">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

                </select>
            </div>
        @endif
        {{-- Ввод названия --}}
        <div class="flex flex-col">
            <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Новая {{$optionAdd == 'sub' ? 'подкатегория' : 'категория'}} </label>
            <input required type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-2.5  dark:border-indigo-600 
                        dark:placeholder-indigo-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        wire:model.defer="name" >
        </div>
        {{-- Ввод описание для подкатегории --}}
        @if ($optionAdd == "sub")
        <div class="flex justify-end w-full space-x-2 pt-4 border-t flex-col">
            <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
            <input
              wire:model.defer="subcategoryDescription"
              required
              class="w-full border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 p-2.5  dark:border-indigo-600 
                        dark:placeholder-indigo-400"
            ></input>
          </div>
        @endif
        <div class="flex justify-end w-full space-x-2 pt-4 border-t">
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >Сохранить</button>
          </div>
    </form>
</div>
