<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Rules\CartValidationRules;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\ColorProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\AddressService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

/**
 * [Description Cart]
 */
class Cart extends Component
{
    public $cartItems; //все эл корзины пользоватлетя
    public $cartItem; //один элемент корзины

    public $showCheckoutModal = false;
    public $showSuggestions  = false;  //при тру показываются варианты введенного адреса 
    public $showAddressesAddons = false;  //при тру показываются доп поля для адреса

    public bool $selectAll = false; // свойство для чекбокса "выбрать все"
    public $suggestions = []; // массив предложений вариантов адреса

    // переменные для заказа
    public float $totalPrice = 0; // Общая сумма корзины
    public array $selectedCartItems = []; //массив выбранных элементов 
    public array  $addressData = [
        'address_text'     => '',
        'apartment_number' => '',
        'doorphone'        => '',
        'entrance'         => '',
        'floor'            => '',
        'phone'            => '',
    ];

    public $quantity; // колво товара в коризщне пользолвателя (одного товара) 

 
    protected CartService $cartService;
    protected AddressService $addressService;
    protected OrderService $orderService;

    public function boot(
        CartService $cartService,
        AddressService $addressService,
        OrderService $orderService

    ) {
        $this->cartService = $cartService;
        $this->addressService = $addressService;
        $this->orderService = $orderService;
    }

    public function mount()
    {
        $this->loadCartItems();
    }

    /**
     * Загружает все товары, находящиес в корзине данного пользователя
     * 
     * @return void
     */
    public function loadCartItems():void
    {
        //все товары пользователя с данным id
        $this->cartItems = $this->cartService->getUserCartItems(auth()->user()->id);
    }

    // метод при фокусе на  инпут ввода адреса доставки
    public function AddressinputFocused()
    {
        $this->showSuggestions  = true;
    }
    // метод при снятии фокуса с  инпута ввода адреса доставки
    public function AddressinputBlur()
    {
        $this->showSuggestions  = false;
    }

    // метод при выборе одного из вариантов адреса


    public function selectSuggestion($suggestion)
    {
        $this->addressData['address_text'] = $suggestion;
        $this->showSuggestions = false; // закрываем строки с вариантами адресов
        $this->showAddressesAddons = true; // открываем доп поля для адреса и телефон
    }

    //вызывается при вводе в поле адреса, если введено больше 3 символов то вызывается функция для вывода предложений адресов

    public function updatedAddressDataAddressText(string $value) // при обновлении в массиве AddressData по ключу AddressText
    {
        //если запрос меньще 4 символов то выводим пустой массив
        if (mb_strlen($value) < 4) {
            return $this->suggestions = [];
        }

        $this->suggestions = $this->addressService->getSuggestions($value)->toArray();
    }

    public function deleteSelected()
    {
        if ($this->selectedCartItems) {
            $this->cartService->deleteCartItems(auth()->user()->id, $this->selectedCartItems);
            $this->selectAll = false;
            $this->loadCartItems();
            $this->updatedSelectedCartItems();
        }
    }

    //метод вызывается автоматически при изменении чекбокса (при вкл/выкл чекбокса "выбрать все")
    public function updatedSelectAll($value)
    {
        if ($value) {
            // выбираем только те товары, у которых stock > 0
            $this->selectedCartItems = $this->cartItems
                ->filter(function ($item) {
                    return $item->colorProduct->stock > 0;
                })
                ->pluck('id')
                ->toArray();
        } else {
            // снять выделение
            $this->selectedCartItems = [];
        }
        $this->updatedSelectedCartItems();
    }

    //вызывается при изменнении свойства SelectedCartItems - при изменении выбранных товаров чекбоксом
    public function updatedSelectedCartItems()
    {
        $this->totalPrice = 0; // Сброс суммы
        foreach ($this->selectedCartItems as $itemId) { //цикл по айдишнику выбранных элементов корзины
            $item = $this->cartItems->find($itemId); // $item - один из выбранных элементов корзины
            if ($item) { //если элемент найден то колво умножается на прайс элемента
                $this->totalPrice += $item->quantity * $item->product->price;
            }
        }
    }

    public function changeQuantity(int $id, int $action)
    {
        $this->cartItem = $this->cartItems->find($id); // выбираем из списка товаров корзины один
        $this->cartService->changeCartItemQuantity(
            $this->cartItem->product_id,
            $this->cartItem->color_product_id,
            $action,
        );
        $this->loadCartItems();
        $this->updatedSelectedCartItems(); // при изменении количества товара вызывается функция общей стоимости корзины    
    }

    //подтверждение заказа
    function OrderConfirm()
    {
        $this->validate(array_merge(
            CartValidationRules::address(),
            CartValidationRules::cart()
        ));

        $order = $this->orderService->placeOrder(
            auth()->user()->id,
            $this->addressData,
            $this->selectedCartItems,
            $this->totalPrice,
            $this->addressService,
            $this->cartService
        );

        //  Очищаем форму, закрываем модалку и показываем сообщение
        $this->reset([
            'addressData',
            'selectedCartItems',
            'totalPrice',
        ]);
        //если заказ успешно создан закрываем модалку 
        if ($order) {
            $this->showCheckoutModal = false;
            $this->dispatchBrowserEvent('order-success');
            $this->loadCartItems();
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
