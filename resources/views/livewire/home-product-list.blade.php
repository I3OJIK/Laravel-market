{{-- мега меню категорий --}}
<div class="relative group inline-block ml-8">
    <!-- Главное меню -->
    <a class="px-4 py-2  rounded-lg text-xl font-medium text-gray-900 hover:bg-gray-100">
      Категории
    </a>
  
    <!-- Выпадающее мега-меню -->
    <div class="absolute left-0 top-full mt-1 hidden group-hover:flex bg-white shadow-lg p-6 z-50 w-[600px] justify-between rounded-lg">
      <!-- Колонка 1 -->
      @foreach ($categories as $category)
        <div>
            <h3 class="font-bold mb-2">{{ $category->name }}</h3>
            <ul class="space-y-1 text-sm text-gray-700">
                @foreach ($category->subcategories as $subcategory)
                    <li><a href="#" class="hover:text-blue-500">{{ $subcategory->name }}</a></li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
  </div>
<div>
<div>
    <section id="Projects"
        class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-16 mt-10 mb-5">

        @foreach ($products as $product)
            <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                <a href="product/{{$product->id}}" wire:click.prevent="loadProduct({{ $product->id }})">
                    <img src="https://images.unsplash.com/photo-1646753522408-077ef9839300?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8NjZ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                        alt="Product" class="h-80 w-72 object-cover rounded-t-xl" />
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