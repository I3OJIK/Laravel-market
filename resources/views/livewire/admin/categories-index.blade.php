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
                    Category
                  </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                  <p class="block text-sm font-normal leading-none text-slate-500">
                    Subcategories
                  </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                  <p class="block text-sm font-normal leading-none text-slate-500">
                    Description
                  </p>
                </th>
                <th class="p-4 border-b border-slate-300 bg-slate-50">
                    <p class="block text-sm font-normal leading-none text-slate-500">
                      
                    </p>
                  </th>
            </thead>
            <tbody>
              @foreach ($categories as $category)
                    <tr class="border-indigo-400">
                        <td rowspan="{{count($category->subcategories) + 1}}" class="p-4 border border-indigo-200">
                            <p class="block text-sm text-slate-800">
                            {{$category->id}}
                            </p>
                        </td>
                        
                        <td rowspan="{{count($category->subcategories) + 1}}" class="p-4 border-b border-r border-indigo-200">
                            <p class="block text-sm text-slate-800">
                            {{$category->name}}
                            </p>
                        </td>
                        @foreach ($category->subcategories as $subcategory)
                        <tr class="transition-all duration-900 hover:bg-indigo-200">
                            <td class="p-4 border-b border-r border-indigo-200">
                                @if ($editingSubcategoryId === $subcategory->id)
                                <input type="text" wire:model.defer="editedSubcategoryName"
                                    class="border rounded px-2 py-1 w-full text-sm text-slate-800" />
                                @else
                                    <p class="block text-sm text-slate-800">
                                        {{ $subcategory->name }}
                                    </p>
                                @endif
                            </td>

                            <td class="p-4 border border-indigo-200">
                                @if ($editingSubcategoryId === $subcategory->id)
                                <input type="text" wire:model.defer="editedSubcategoryDescription"
                                    class="border rounded px-2 py-1 w-full text-sm text-slate-800" />
                                @else
                                    <p class="block text-sm text-slate-800">
                                        {{ $subcategory->description }}
                                    </p>
                                @endif
                            </td>
                            <td class="p-4 border-b border-r border-indigo-200">
                                @if ($editingSubcategoryId === $subcategory->id)
                                    <button wire:click="saveSubcategory"
                                        class="text-sm text-green-600 font-semibold mr-2">Save</button>
                                    <button wire:click="$set('editingSubcategoryId', null)"
                                        class="text-sm text-gray-600">Cancel</button>
                                @else
                                    <a href="#" wire:click="editSubcategory({{ $subcategory->id }})"
                                        class="text-sm text-blue-500 font-semibold mr-2">Edit</a>
                                    <a href="#" wire:click="deleteSubcategory({{ $subcategory->id }})"
                                        class="text-sm text-red-500 font-semibold">Delete</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
    
</div>