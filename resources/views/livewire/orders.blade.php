<div>
    <section class="py-24 relative">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-8">
            <h2 class="font-manrope font-extrabold text-3xl lead-10 text-black mb-9">Order History</h2>

            <div class="flex sm:flex-col lg:flex-row sm:items-center justify-between">
                <ul class="flex max-sm:flex-col sm:items-center gap-x-14 gap-y-3">
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-indigo-600 transition-all duration-500 hover:text-indigo-600">
                        All Order</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Summary</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Completed</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Cancelled</li>
                </ul>
                <div class="flex max-sm:flex-col items-center justify-end gap-2 max-lg:mt-5">
                    <div class="flex rounded-full py-3 px-4 border border-gray-300 relative">
                        <svg class="relative " width="18" height="20" viewBox="0 0 18 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.5 7.75H16.5M11.9213 11.875H11.928M11.9212 14.125H11.9279M9.14676 11.875H9.1535M9.14676 14.125H9.1535M6.37088 11.875H6.37762M6.37088 14.125H6.37762M5.25 4.75V1.75M12.75 4.75V1.75M7.5 18.25H10.5C13.3284 18.25 14.7426 18.25 15.6213 17.3713C16.5 16.4926 16.5 15.0784 16.5 12.25V9.25C16.5 6.42157 16.5 5.00736 15.6213 4.12868C14.7426 3.25 13.3284 3.25 10.5 3.25H7.5C4.67157 3.25 3.25736 3.25 2.37868 4.12868C1.5 5.00736 1.5 6.42157 1.5 9.25V12.25C1.5 15.0784 1.5 16.4926 2.37868 17.3713C3.25736 18.25 4.67157 18.25 7.5 18.25Z"
                                stroke="#111827" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input type="text" name="from-dt" id="from-dt"
                            class="font-semibold px-2 text-sm text-gray-900 outline-0 appearance-none flex flex-row-reverse cursor-pointer w-28 placeholder-gray-900" placeholder="11-01-2023">
                    </div>
                    <p class="font-medium text-lg leading-8 text-black">To</p>
                    <div class="flex rounded-full py-3 px-4 border border-gray-300 relative">
                        <svg class="relative " width="18" height="20" viewBox="0 0 18 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.5 7.75H16.5M11.9213 11.875H11.928M11.9212 14.125H11.9279M9.14676 11.875H9.1535M9.14676 14.125H9.1535M6.37088 11.875H6.37762M6.37088 14.125H6.37762M5.25 4.75V1.75M12.75 4.75V1.75M7.5 18.25H10.5C13.3284 18.25 14.7426 18.25 15.6213 17.3713C16.5 16.4926 16.5 15.0784 16.5 12.25V9.25C16.5 6.42157 16.5 5.00736 15.6213 4.12868C14.7426 3.25 13.3284 3.25 10.5 3.25H7.5C4.67157 3.25 3.25736 3.25 2.37868 4.12868C1.5 5.00736 1.5 6.42157 1.5 9.25V12.25C1.5 15.0784 1.5 16.4926 2.37868 17.3713C3.25736 18.25 4.67157 18.25 7.5 18.25Z"
                                stroke="#111827" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input type="text" name="to-dt" id="to-dt"
                            class="font-semibold px-2 text-sm text-gray-900 outline-0 appearance-none flex flex-row-reverse cursor-pointer w-28 placeholder-gray-900" placeholder="11-01-2023">
                    </div>
                </div>
            </div>
            {{-- заказ --}}
            @foreach ($orders as $order)
                <div class="mt-7 border border-gray-300 pt-9">
                    <div class="flex max-md:flex-col items-center justify-between px-3 md:px-11">
                        <div class="data">
                            <p class="font-medium text-lg leading-8 text-black whitespace-nowrap">Order : #{{$order->id}}</p>
                            <p class="font-medium text-lg leading-8 text-black mt-3 whitespace-nowrap">Order create : {{$order->created_at->format('jS F Y')}}</p>
                        </div>

                    </div>
                    @foreach ($order->orderItems as $item)
                    {{-- элемент заказа --}}
                        <svg class="my-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2" viewBox="0 0 1216 2"
                            fill="none">
                            <path d="M0 1H1216" stroke="#D1D5DB" />
                        </svg>
                        <div class="flex max-lg:flex-col items-center gap-8 lg:gap-24 px-3 md:px-11">
                            <div class="grid grid-cols-4 w-full">
                                <div class="col-span-4 sm:col-span-1">
                                    <img src="https://pagedone.io/asset/uploads/1705474774.png" alt="" class="max-sm:mx-auto object-cover">
                                </div>
                                <div
                                    class="col-span-4 sm:col-span-3 max-sm:mt-4 sm:pl-8 flex flex-col justify-center max-sm:items-center">
                                    <h6 class="font-manrope font-semibold text-2xl leading-9 text-black mb-3 whitespace-nowrap">
                                        {{$item->product->name}}</h6>
                                    <p class="font-normal text-lg leading-8 text-gray-500 mb-8 whitespace-nowrap">Color: {{$item->color->name}}</p>
                                    <div class="flex items-center max-sm:flex-col gap-x-10 gap-y-3">
                                        {{-- <span class="font-normal text-lg leading-8 text-gray-500 whitespace-nowrap">Color:
                                            {{$item->color->name}}</span> --}}
                                        <span class="font-normal text-lg leading-8 text-gray-500 whitespace-nowrap">Qty:
                                            {{$item->quantity}}</span>
                                        <p class="font-semibold text-xl leading-8 text-black whitespace-nowrap">Price ₽{{$item->price}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-around w-full  sm:pl-28 lg:pl-0">
                                <div class="flex flex-col justify-center items-start max-sm:items-center">
                                    <p class="font-normal text-lg text-gray-500 leading-8 mb-2 text-left whitespace-nowrap">
                                        Status</p>
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
                                </div>
                                {{-- <div class="flex flex-col justify-center items-start max-sm:items-center">
                                    <p class="font-normal text-lg text-gray-500 leading-8 mb-2 text-left whitespace-nowrap">
                                        Delivery Expected by</p>
                                    <p class="font-semibold text-lg leading-8 text-black text-left whitespace-nowrap">23rd March
                                        2021</p>
                                </div> --}}
                            </div>
                        </div>
                    @endforeach


                     {{-- 
                    <svg class="mt-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2" viewBox="0 0 1216 2"
                        fill="none">
                        <path d="M0 1H1216" stroke="#D1D5DB" />
                    </svg> --}}

                    <div class="px-3 md:px-11 flex items-center justify-between max-sm:flex-col-reverse">
                        <div class="flex max-sm:flex-col-reverse items-center">
                            <button
                                class="flex items-center gap-3 py-10 pr-8 sm:border-r border-gray-300 font-normal text-xl leading-8 text-gray-500 group transition-all duration-500 hover:text-indigo-600"
                                wire:click="preventDelete({{$order->id}})">
                            

                                <svg width="40" height="41" viewBox="0 0 40 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path class="stroke-gray-600 transition-all duration-500 group-hover:stroke-indigo-600"
                                        d="M14.0261 14.7259L25.5755 26.2753M14.0261 26.2753L25.5755 14.7259" stroke=""
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                cancel order
                            </button>
                            <p class="font-normal text-xl leading-8 text-gray-500 sm:pl-8">Payment upon Receipt</p>
                        </div>
                        <p class="font-medium text-xl leading-8 text-black max-sm:py-4"> <span class="text-gray-500">Total
                                Price: </span> &nbsp;₽{{$order->total_price}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- окно удаления заказа --}}
            <div>
                <!-- Модальное окно -->
                <div class="{{ $showModal ? 'flex' : 'hidden' }} fixed inset-0 z-50 justify-center w-full h-full bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                            <button wire:click="$set('showModal', false)" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                            <div class="flex justify-center items-center space-x-4">
                                <button wire:click="$set('showModal', false)" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    No, cancel
                                </button>
                                <button wire:click="deleteOrder" type="button" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Yes, I'm sure
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Затемнение фона -->
                @if($showModal)
                    <div wire:ignore.self class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                @endif
            </div>
    </section>
</div>
