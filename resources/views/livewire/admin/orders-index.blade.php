<div>
    <div>
        <section class="relative">
            <div class="w-full max-w-7xl mx-auto px-4 md:px-8">
                <div class="flex sm:flex-col lg:flex-row sm:items-center justify-between">
                    <ul class="flex max-sm:flex-col sm:items-center gap-x-14 gap-y-3">
                            <li wire:click="$set('activeFilter', 'all')"
                                class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600
                                {{ $activeFilter === 'all' ? 'text-indigo-600' : 'text-black' }}">
                                All Order</li>
                            <li wire:click="$set('activeFilter', 'Pending')"
                                class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600
                                {{ $activeFilter === 'Pending' ? 'text-indigo-600' : 'text-black' }}">
                                Pending</li>
                            <li wire:click="$set('activeFilter', 'Processing')"
                                class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600
                                {{ $activeFilter === 'Processing' ? 'text-indigo-600' : 'text-black' }}">
                                Processing</li>
                            <li wire:click="$set('activeFilter', 'Shipped')"
                                class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600
                                {{ $activeFilter === 'Shipped' ? 'text-indigo-600' : 'text-black' }}">
                                Shipped</li>
                            <li wire:click="$set('activeFilter', 'Completed')"
                                class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600
                                {{ $activeFilter === 'Completed' ? 'text-indigo-600' : 'text-black' }}">
                                Completed</li>
                            <li wire:click="$set('activeFilter', 'Cancelled')"
                                class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600
                                {{ $activeFilter === 'Cancelled' ? 'text-indigo-600' : 'text-black' }}">
                                Cancelled</li>

                                 <!-- Поиск -->
                            <div class="flex-1 mx-4 max-w-lg items-center justify-center m-4">
                                <div class="relative ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-5 h-5 top-2.5 left-2.5 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                                <input wire:model="searchInput" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 
                                    text-sm border border-slate-200 rounded-md pl-10 pr-3 py-2 shadow-sm transition-all
                                    duration-900  hover:border-indigo-600 focus:outline-none focus:border-indigo-600  focus:shadow"
                                    placeholder="Input id order..." />
                                </div>
                            </div>
                    </ul>

                   
    
                </div>
    
                {{-- заказ --}}
                @foreach ($orders as $order)
                <div class="mt-7 border border-gray-300 pt-9">
                    <div class="flex flex-col lg:flex-row px-3 lg:px-11 gap-4">
                        
                        <!-- Столбец 1 -->
                        <div class="flex flex-col w-full lg:w-1/3">
                            <p class="font-medium text-lg leading-8 text-black whitespace-nowrap">Order: #{{ $order->id }}</p>
                            <p class="font-medium text-lg leading-8 text-black mt-3 whitespace-nowrap">Created: {{ $order->created_at->format('jS F Y') }}</p>
                        </div>
                
                        <!-- адрес 2 -->
                        <div class="flex flex-col w-full lg:w-1/2">
                            
                            <p class="font-medium text-lg leading-8 text-black whitespace-nowrap">Address:</p>
                            <p class="font-normal text-sm text-black">
                                {{ $order->address->address_text . 
                                    ', подъезд ' . $order->address->entrance . 
                                    ', кв. ' . $order->address->apartment_number . 
                                    ', домофон ' . $order->address->doorphone . 
                                    ', этаж ' . $order->address->floor }}
                            </p>
                            <div class="flex items-baseline gap-1">
                                <p class="font-medium text-lg  text-black">Тел:</p>
                                <p class="font-medium text-sm text-black">{{$order->address->phone }}</p>
                            </div>
                        </div>

                        <!-- Столбец 4 -->
                        <div class="flex flex-col w-full lg:w-1/3">
                            <p class="font-medium text-lg leading-8 text-black whitespace-nowrap">Status:</p>
                            <div class="flex items-baseline gap-1">
                                @if ($editingOrderId == $order->id)
                                <select
                                    class="font-semibold text-lg leading-8 text-left whitespace-nowrap"
                                    wire:model = "newStatus">
                                    <option class="text-yellow-500" value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option class="text-blue-500" value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option class="text-indigo-500" value="Shipped" {{ $order->status === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option class="text-green-500" value="Completed" {{ $order->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option class="text-red-500" value="Cancelled" {{ $order->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @else
                                    <p class="font-semibold text-lg leading-8 text-left whitespace-nowrap
                                        @switch(strtolower($order->status))
                                            @case('pending') text-yellow-500 @break
                                            @case('processing') text-blue-500  @break
                                            @case('shipped') text-indigo-500 @break
                                            @case('completed') text-green-500 @break
                                            @case('cancelled') text-red-500 @break
                                            @default text-gray-500
                                        @endswitch">
                                    {{$order->status}}</p>
                                    <a href="#" wire:click="editOrderStatus({{ $order->id }})"
                                    class="text-sm text-gray-800 font-semibold ml-6">Edit</a>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                
                    <div class="hidden md:grid grid-cols-4 gap-4 px-3 md:px-11 pt-6 font-semibold text-gray-500 border-b border-gray-300">
                        <div>Product</div>
                        <div>Quantity</div>
                        <div>Color</div>
                        <div>Price</div>
                    </div>
                    @foreach ($order->orderItems as $item)
                        <!-- Десктоп: одна строка с 4 колонками -->
                        <div class="hidden md:grid grid-cols-4 gap-4 px-3 md:px-11 py-4 border-b border-gray-100">
                            <div class="text-black text-base font-medium whitespace-nowrap">{{ $item->product->name }}</div>
                            <div class="text-gray-700 text-base whitespace-nowrap">{{ $item->quantity }}</div>
                            <div class="text-gray-700 text-base whitespace-nowrap">{{ $item->color->name }}</div>
                            <div class="text-black text-base font-semibold whitespace-nowrap">₽{{ $item->price }}</div>
                        </div>

                        <!-- Мобилка: вертикальный список -->
                        <div class="md:hidden px-4 py-4 border-b border-gray-100 flex flex-col gap-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Product:</span>
                                <span class="text-black font-medium">{{ $item->product->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Quantity:</span>
                                <span class="text-gray-800">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Color:</span>
                                <span class="text-gray-800">{{ $item->color->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Price:</span>
                                <span class="text-black font-semibold">₽{{ $item->price }}</span>
                            </div>
                        </div>
                    @endforeach
                    
                        <div class="px-3 md:px-11 flex items-center justify-between max-sm:flex-col-reverse">
                            <div class="flex max-sm:flex-col-reverse items-center">
                                <p class="flex items-center gap-3 py-10 pr-8 sm:border-r border-gray-300 font-normal text-xl leading-8 text-gray-500 group transition-all duration-500 hover:text-indigo-600">Payment upon Receipt</p>
                            </div>
                            <p class="font-medium text-xl leading-8 text-black max-sm:py-4"> <span class="text-gray-500">Total
                                    Price: </span> &nbsp;₽{{$order->total_price}}</p>
                        </div>
                    </div>
                
                 @endforeach
                </div>
            </div>
        </section>
        <!-- Добавьте в ваш layout или в конец шаблона -->

    </div>
        
</div>
