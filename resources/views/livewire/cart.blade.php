<div class="bg-gray-100 h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
        
        <div class="flex flex-col md:flex-row gap-4">   
            <div class="md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                    <div class="flex items-center justify-between mb-6">
                        <!-- Левая часть: Выбрать всё -->
                        <label class="flex items-center space-x-2 ml-[5px]">
                            <input
                                type="checkbox"
                                wire:model="selectAll"
                                class="w-4 h-4"
                            >
                            <span>Выбрать всё</span>
                        </label>
                
                        <!-- Правая часть: Удалить выбранные -->
                        <button
                            wire:click="deleteSelected"
                            class="px-4 py-1 text-sm bg-white hover:bg-gray-100  rounded-lg {{$selectedCartItems ? '' : 'pointer-events-none'}}"
                        >
                            Удалить выбранные
                        </button>
                    </div>
                    {{-- //вариант дял десктопов --}}
                    <table class="hidden md:table w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Product</th>
                                <th class="text-left font-semibold">Color</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $cartItem)
                                    <tr wire:key="item-{{ $cartItem->id }}" 
                                        {{-- если товар данного цвета закончился заблокировать его и затемнить --}}
                                        class="{{$cartItem->colorProduct->stock <= 0 ? 'pointer-events-none opacity-50' : ''}}">
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <!-- обёртка для картинки + чекбокса -->
                                                <div class="relative inline-block mr-4">
                                                        <img 
                                                            @if (Storage::disk('public')->exists($cartItem->product->image_url))
                                                            src="{{ asset('storage/' . $cartItem->product->image_url) }}"
                                                            alt="Product" class="w-24 h-24 object-cover mb-2 rounded-xl" 
                                                            @else
                                                            src="https://images.unsplash.com/photo-1646753522408-077ef9839300?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8NjZ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                                                            alt="Product" class="w-24 h-24 object-cover mb-2 rounded-xl" 
                                                            @endif 
                                                        />
                                                        <!-- чекбокс внутри этого же блока -->
                                                        <input
                                                        id="default-checkbox"
                                                        type="checkbox"
                                                        wire:model="selectedCartItems"
                                                        value = "{{$cartItem->id}}"
                                                        class="absolute top-0 left-0 w-4 h-4 m-1 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                                        >
                                                </div>
                                                <span class="font-semibold">{{$cartItem->Product->name}}</span>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <div class="
                                                        w-8 h-8 rounded-full
                                                        {{ $cartItem->colorProduct->color->color_class }}
                                                        border-2
                                                        peer-checked:border-gray-900 dark:peer-checked:border-gray-300
                                                        border-transparent
                                                        transition-all">
                                                 </div>
                                            </div>
                                        </td>
                                        <td class="py-4">₽{{$cartItem->Product->price}}</td>
                                        <td class="py-4">
                                            <div class="flex items-center">

                                                @if ($cartItem->colorProduct->stock > 0)
                                                    <button  wire:click="changeQuantity({{$cartItem->product_id}},{{$cartItem->color_product_id}}, -1)" class="border rounded-md py-2 px-4 mr-2">-</button>
                                                    <span class="text-center w-8">{{$cartItem->quantity}}</span>
                                                    <button wire:click="changeQuantity({{$cartItem->product_id}},{{$cartItem->color_product_id}}, 1)" class="border rounded-md py-2 px-4 ml-2">+</button>
                                                        
                                                @else
                                                   <p>Товар закончился🥺</p> 
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <td class="py-4">₽{{($cartItem->Product->price) * ($cartItem->quantity)}}</td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- MOBILE VIEW -->
                    <div class="md:hidden px-4 py-4 border-b border-gray-100 flex flex-col gap-1 text-sm">
                        @foreach ($cartItems as $cartItem)
                            <div class="border border-gray-300 rounded-lg p-4
                                    {{ $cartItem->colorProduct->stock <= 0 ? 'pointer-events-none opacity-50' : '' }}" 
                                    wire:key="mobile-{{ $cartItem->id }}">
                                
                                <!-- Product name and checkbox -->
                                <div class="flex items-center mb-2">
                                    <input type="checkbox"
                                        wire:model="selectedCartItems"
                                        value="{{ $cartItem->id }}"
                                        class="mr-2 w-4 h-4">
                                    <span class="font-semibold text-gray-900">{{ $cartItem->Product->name }}</span>
                                </div>

                                <!-- Product image -->
                                <img 
                                    @if (Storage::disk('public')->exists($cartItem->product->image_url))
                                    src="{{ asset('storage/' . $cartItem->product->image_url) }}"
                                    alt="Product" class="w-24 h-24 object-cover mb-2 rounded-xl" 
                                    @else
                                    src="https://images.unsplash.com/photo-1646753522408-077ef9839300?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8NjZ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                                    alt="Product" class="w-24 h-24 object-cover mb-2 rounded-xl" 
                                    @endif 
                                />

                                <!-- Color -->
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium w-24">Color:</span>
                                    <div class="w-5 h-5 rounded-full ml-2 {{ $cartItem->colorProduct->color->color_class }}"></div>
                                </div>

                                <!-- Price -->
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium w-24">Price:</span> 
                                   <p> ₽{{ $cartItem->Product->price }}</p>
                                </div>

                                <!-- Quantity -->
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium w-24">Quantity:</span>
                                    <div class="ml-4">
                                        @if ($cartItem->colorProduct->stock > 0)
                                            <button wire:click="decrementQuantity({{ $cartItem->id }})" class="border px-2 mr-2">-</button>
                                            <span>{{ $cartItem->quantity }}</span>
                                            <button wire:click="incrementQuantity({{ $cartItem->id }})" class="border px-2 ml-2">+</button>
                                        @else
                                            <span>Товар закончился🥺</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="flex justify-between mb-2">
                                    <span class="font-medium w-24">Total:</span>
                                    <p class="font-medium"> ₽{{ $cartItem->Product->price * $cartItem->quantity }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>$19.99</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>$1.99</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>$0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Total</span>
                        <span class="font-semibold">₽{{$totalPrice}}</span>
                    </div>
                    <button 
                        wire:click="$set('showCheckoutModal', true)"
                        @if(! count($selectedCartItems)) disabled @endif
                        class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full"
                        >Checkout</button>
                </div>
            </div>
        </div>
    </div>

    {{-- модальное окно --}}
     {{-- меню оформления заказа --}}
    @if($showCheckoutModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex  items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <button wire:click="$set('showCheckoutModal', false)" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl">&times;</button>
        
        <h2 class="text-xl font-semibold mb-4">Подтверждение заказа</h2>

        <div class="mb-4 max-h-64 overflow-y-auto">
            <ul>
                {{-- выбирает только те элементы которые имеют айди как в selectedCartItems --}}
                @foreach($cartItems->whereIn('id', $selectedCartItems) as $item)
                    <li class="mb-2">
                        <span class="font-semibold">{{ $item->product->name }}</span> —  
                        {{$item->colorProduct->color->name}}
                        {{ $item->quantity }} шт. (₽{{ $item->product->price * $item->quantity }})
                       
                    </li>
                @endforeach
                <li class="mt-4">
                    <span class="font-semibold">Итого:</span>
                    ₽{{$totalPrice}}
                </li>
            </ul>
        </div>
       
        <div class="mb-4">
            <label class="block font-semibold mb-1">Адрес доставки:</label>
            <input
                type="text"
                wire:model="addressData.address_text"
                wire:focus="AddressinputFocused"
                wire:blur="AddressinputBlur"
                class=" peer  w-full items-center border border-gray-300 hover:placeholder-gray-800  rounded px-3 py-2 mb-4 "
                placeholder="Введите адрес..."
            >
                    @if(!empty($suggestions))
                 <ul class="mt-2 border bg-white shadow-lg {{ $showSuggestions? '' : 'hidden' }}"> {{--показывать примеры адресов если инпут выбран --}}
                    @foreach($suggestions as $suggestion)
                        <li  wire:click="selectSuggestion('{{ $suggestion['subtitle'] ? $suggestion['subtitle'] . ', ' : '' }}{{ $suggestion['title'] }}')"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100">{{ $suggestion['subtitle'] ? $suggestion['subtitle'] . ', ' : '' }}{{ $suggestion['title'] }}</li>
                    @endforeach
                </ul>
                    @elseif(strlen($addressData['address_text']) > 2)
                        <div class="mt-2 p-4 text-gray-500">Нет предложений</div>
                    @endif

                {{-- открывает доп поля для адреса, срабатывает когда выбрали адрес (нажали на один из вариантов) --}}
                @if ($showAddressesAddons && isset($addressData['address_text'])) 
                <div class="mb-4 flex inline-block justify-between">
                    <input wire:model="addressData.apartment_number" type="text" class="w-1/5 mr-7 border border-gray-300 hover:placeholder-gray-800 rounded px-3 py-2 " placeholder="Кв./офис">
                    <input wire:model="addressData.doorphone" type="text" class="w-1/5 mr-7 border border-gray-300 hover:placeholder-gray-800 rounded px-3 py-2 " placeholder="Домофон">
                    <input wire:model="addressData.entrance" type="text" class="w-1/5 mr-7 border border-gray-300 hover:placeholder-gray-800 rounded px-3 py-2 " placeholder="Подъезд">
                    <input wire:model="addressData.floor" type="text" class="w-1/5 border border-gray-300 hover:placeholder-gray-800 rounded px-3 py-2 " placeholder="Этаж"> 
                </div>
                <input wire:model="addressData.phone"   type="text" class="w-1/3 border border-gray-300 hover:placeholder-gray-800 rounded px-3 py-2 required"
                    placeholder="Номер телефона"
                    id="phone-mask"> 
                    @endif
        </div>

        <button
            wire:click="OrderConfirm"
            class="bg-green-500 text-white px-4 py-2 rounded w-full hover:bg-green-600"
        >
            Подтвердить заказ
        </button>
        
    </div>
</div>

@endif
</div>
    {{-- маска для  номера телефона --}}
    @push('scripts')
    <script src="https://unpkg.com/imask"></script>

    <script>
             Livewire.hook('message.processed', () => {
            const phoneInput = document.getElementById('phone-mask');
            if (phoneInput && !phoneInput.dataset.masked) {
                const mask = IMask(phoneInput, { mask: '+{7} (000) 000-00-00' });
                
            }
        });

        // уведомление при создании заказа
        window.addEventListener('order-success', () => {
            alert('Заказ успешно оформлен!');
            // Или кастомный toast
        });

    </script>
@endpush
