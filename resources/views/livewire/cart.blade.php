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
                            class="px-4 py-1 text-sm bg-white hover:bg-gray-100  rounded-lg"
                        >
                            Удалить выбранные
                        </button>
                    </div>
                    <table class="w-full">
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
                                    <tr wire:key="item-{{ $cartItem->id }}">
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <!-- обёртка для картинки + чекбокса -->
                                                <div class="relative inline-block mr-4">
                                                        <img
                                                        class="size-20 block"
                                                        src="https://cdn.pixabay.com/photo/2020/05/22/17/53/mockup-5206355_960_720.jpg"
                                                        alt="Product image"
                                                        >
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
                                                <button  wire:click="decrementQuantity({{$cartItem->id}})" class="border rounded-md py-2 px-4 mr-2">-</button>
                                                <span class="text-center w-8">{{$cartItem->quantity}}</span>
                                                <button wire:click="incrementQuantity({{$cartItem->id}})" class="border rounded-md py-2 px-4 ml-2">+</button>
                                            </div>
                                        </td>
                                        <td class="py-4">₽{{($cartItem->Product->price) * ($cartItem->quantity)}}</td>
                                    </tr>
                            @endforeach
                            <!-- More product rows -->
                        </tbody>
                    </table>
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
    @if($showCheckoutModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative">
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
            </ul>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Адрес доставки:</label>
            <input
                type="text"
                wire:model="deliveryAddress"
                class="w-full border border-gray-300 rounded px-3 py-2"
                placeholder="Введите адрес..."
            >
        </div>

        <button
            wire:click="submitOrder"
            class="bg-green-500 text-white px-4 py-2 rounded w-full hover:bg-green-600"
        >
            Подтвердить заказ
        </button>
    </div>
</div>
@endif
</div>
