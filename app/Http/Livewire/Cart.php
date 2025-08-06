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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

/**
 * Компонент корзины пользователя.
 *
 * Поддерживает:
 * - Загрузку и отображение элементов корзины
 * - Выбор/снятие чекбокса «Выбрать все»
 * - Фильтрацию выбранных элементов
 * - Изменение количества товара
 * - Подсказку адреса и ввод данных доставки
 * - Подтверждение заказа
 * 
 * 
 * @property Collection $cartItems Список товаров в корзине (вычисляемое свойство)
 * @property float $totalPrice Общая сумма выбранных товаров (вычисляемое свойство)
 * @property CartItem|null $cartItem Конкретный товар в корзине
 * @property bool $showCheckoutModal Флаг отображения модального окна оформления заказа
 * @property bool $showSuggestions Флаг отображения подсказок адреса
 * @property bool $showAddressesAddons Флаг отображения дополнительных полей адреса
 * @property bool $selectAll Флаг "Выбрать все" товары
 * @property array $suggestions Список подсказок адреса
 * @property array $selectedCartItemIds Массив ID выбранных товаров
 * @property array $addressData Данные адреса доставки:
 *   - string $address_text Основной текст адреса
 *   - string $apartment_number Номер квартиры
 *   - string $doorphone Код домофона
 *   - string $entrance Подъезд
 *   - string $floor Этаж
 *   - string $phone Телефон для связи
 */
class Cart extends Component
{
    public $cartItem; //один элемент корзины
    public bool $showCheckoutModal = false;
    public bool $showSuggestions  = false;  //при тру показываются варианты введенного адреса 
    public bool $showAddressesAddons = false;  //при тру показываются доп поля для адреса
    public bool $selectAll = false; // свойство для чекбокса "выбрать все"
    public array $suggestions = []; // массив предложений вариантов адреса

    // переменные для заказа
    public array $selectedCartItemIds = []; //массив выбранных элементов 
    public array  $addressData = [
        'address_text'     => '',
        'apartment_number' => '',
        'doorphone'        => '',
        'entrance'         => '',
        'floor'            => '',
        'phone'            => '',
    ];


 
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




    /**
     * Получить все товары в корзине даннного пользователя
     * 
     * @return Collection
     */
    public function getCartItemsProperty(): Collection
    {
        return $this->cartService->getUserCartItems(Auth::id());
    }

    /**
     * Общая сумма выбранных товаров.
     *
     * @return float
     */
    public function getTotalPriceProperty(): float
    {
        return $this->cartService->calculateSelectedItemsTotal(Auth::id(),$this->selectedCartItemIds);
    }

     /** Событие focus на поле адреса */
     public function AddressinputFocused(): void
     {
         $this->showSuggestions = true;
     }
 
     /** Событие blur на поле адреса */
     public function AddressinputBlur(): void
     {
         $this->showSuggestions = false;
     }
 
     /**
      * Выбор подсказки адреса.
      *
      * @param string $suggestion
      */
     public function selectSuggestion(string $suggestion): void
     {
         $this->addressData['address_text'] = $suggestion;
         $this->showSuggestions  = false;
         $this->showAddressesAddons = true;
     }
 
     /**
      * Обновление поля address_text — получение подсказок.
      *
      * @param string $value
      */
     public function updatedAddressDataAddressText(string $value): void
     {
         if (mb_strlen($value) < 4) {
             $this->suggestions = [];
             return;
         }
         $this->suggestions = $this->addressService
             ->getSuggestions($value)
             ->toArray();
     }
 
     /**
      * Включить/выключить «Выбрать все».
      *
      * @param bool $value
      */
     public function updatedSelectAll(bool $value): void
     {
         $this->selectedCartItemIds = $value
             ? $this->cartItems
                 ->filter(fn(CartItem $item) => $item->colorProduct->stock > 0)
                 ->pluck('id')
                 ->toArray()
             : [];
     }
 
     /**
      * Удаляет отмеченные элементы из корзины.
      */
     public function deleteSelected(): void
     {
         if (empty($this->selectedCartItemIds)) {
             return;
         }
         $this->cartService->deleteCartItems(Auth::id(), $this->selectedCartItemIds);
         $this->selectAll          = false;
         $this->selectedCartItemIds  = [];
     }
 
     /**
      * Изменение количества одного товара.
      *
      * @param int $productId
      * @param int $colorProductId
      * @param int $delta         +1 или -1
      */
     public function changeQuantity(int $productId, int $colorProductId, int $delta): void
     {
         $this->cartService->changeCartItemQuantity(Auth::id(), $productId, $colorProductId, $delta);
     }
 
     /**
      * Подтверждение заказа: валидация и создание.
      */
     public function OrderConfirm(): void
     {
         $this->validate(array_merge(
             CartValidationRules::address(),
             CartValidationRules::cart()
         ));
 
         $order = $this->orderService->placeOrder(
             Auth::id(),
             $this->addressData,
             $this->selectedCartItemIds,
             $this->totalPrice,
             $this->addressService,
             $this->cartService
         );
        //  сброс computed свойств
         $this->forgetComputed();
         if ($order) {
             $this->reset(['addressData', 'selectedCartItemIds',]);
             $this->showCheckoutModal = false;
             $this->dispatchBrowserEvent('order-success');
         }
     }

    public function render()
    {
        return view('livewire.cart',[
            'cartItems'=>$this->cartItems,
            'totalPrice' => $this->totalPrice,
        ]);
    }
}
