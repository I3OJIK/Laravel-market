{{-- мега меню категорий --}}
<div>
    <div class="w-full centr">
        @if ($selectedSubcategory)
            <div class="text-center">
                <h1 class="font-bold text-2xl mb-2">{{$subcategories->name}}</h1>
            </div>
        @endif
    </div>
    
    <div class="flex items-center justify-between w-full px-2 py-2 relative">

      <!-- Категории -->
      <div class="relative group">
        <!-- Кнопка -->
        <a class="rounded-lg text-base font-medium text-gray-900 hover:bg-gray-100 cursor-pointer">
          Категории
        </a>
      
        <!-- Выпадающее меню -->
        <div class="absolute left-0 top-full mt-1 hidden group-hover:block z-50 ">
          <div class="
            flex flex-col gap-4 bg-white shadow-lg rounded-lg p-4
            md:flex-row md:justify-between
          ">
            @foreach ($categories as $category)
              <div class="min-w-[150px]">
                <h3 class="font-bold mb-2 text-sm md:text-base">{{ $category->name }}</h3>
                <ul class="space-y-1 text-sm text-gray-700">
                  @foreach ($category->subcategories as $subcategory)
                    <li>
                      <a href="#"
                         wire:click.prevent="selectSubcategory({{ $subcategory->id }})"
                         class="transition-all duration-300 hover:text-indigo-600 block">
                        {{ $subcategory->name }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      
      
    
      <!-- Поиск -->
      <div class="flex-1 mx-3 max-w-lg ">
        <div class="relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 top-2.5 left-2.5 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
          </svg>
          <input wire:model="searchInput" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md pl-10 pr-3 py-2 shadow-sm transition-all duration-900  hover:border-indigo-600 focus:outline-none focus:border-indigo-600  focus:shadow" placeholder="Input name product...(min 3 symbol)" />
        </div>
      </div>
    
      <!-- Сортировка -->
      <div class="relative group">
        <a type="button" class="group inline-flex items-center  text-sm font-medium text-gray-700  hover:text-gray-900 cursor-pointer" id="menu-button">
            Sort
            <svg class="mr-1 ml-1 h-5 w-5 text-gray-400 transition-all duration-500 group-hover:text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
          </a>
    
        <!-- Меню открывается при наведении на родительский элемент или сам список -->
        <div class="absolute right-0 mt-0 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black/5 z-50 opacity-0 group-hover:opacity-100 group-hover:block hidden transition-opacity">
            <div class="py-1 mt-2">
                <a href="#" wire:click.prevent="sortBy('price', 'asc')" class="block px-4 py-2 text-sm text-gray-700 transition-all duration-900  hover:text-indigo-500">Price: Low to High</a>
                <a href="#" wire:click.prevent="sortBy('price', 'desc')" class="block px-4 py-2 text-sm text-gray-700 transition-all duration-900  hover:text-indigo-500">Price: High to Low</a>
                <a href="#" wire:click.prevent="sortBy('name', 'asc')" class="block px-4 py-2 text-sm text-gray-700 transition-all duration-900  hover:text-indigo-500">Name: A to Z</a>
                <a href="#" wire:click.prevent="sortBy('name', 'desc')" class="block px-4 py-2 text-sm text-gray-700 transition-all duration-900  hover:text-indigo-500">Name: Z to A</a>
            </div>
        </div>
    </div>
    </div>
    
    
    
    <div>
        <section id="Projects"
            class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-16 mt-10 mb-5">
            
            @foreach ($products as $product)
                <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                    <a href="product/{{$product->id}}" wire:click.prevent="loadProduct({{ $product->id }})">
                      
                        <img 
                            @if (Storage::disk('public')->exists($product->image_url))
                              src="{{ asset('storage/' . $product->image_url) }}"
                              alt="Product" class="h-80 w-72 object-cover rounded-t-xl" 
                            @else
                              src="https://images.unsplash.com/photo-1646753522408-077ef9839300?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8NjZ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                              alt="Product" class="h-80 w-72 object-cover rounded-t-xl" 
                            @endif />

                        <div class="px-4 py-3 w-72">
                            <span class="text-gray-400 mr-3 uppercase text-xs">Brand</span>
                            <p class="text-lg font-bold text-black truncate block capitalize">{{$product->name}}</p>
                            <div class="flex items-center">
                                <p class="text-lg font-semibold text-black cursor-auto my-3">₽{{$product->price}}</p>
                                <del>
                                    <p class="text-sm text-gray-600 cursor-auto ml-2">₽{{$product->price * (mt_rand(110, 180) / 100)}} </p>
                                </del>
                                <div class="ml-auto"><a href="РОУТ НА ДОБАВЛЕНИЕ В КОРЗИНУ"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                        
                                        <path fill-rule="evenodd"
                                            d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                    </svg> </a></div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            
        </section>  
        <div class="w-full">
            {{ $products->links() }}
        </div>
    </div>
</div>