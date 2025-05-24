<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\ColorProduct;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems; //все эл корзины пользоватлетя
    public $cartItem; //один элемент корзины
    
    public $showCheckoutModal = false;
    public $showAddressesExample = false;  //при тру показываются варианты введенного адреса 
    public $showAddressesAddons = false;  //при тру показываются доп поля для адреса
    
    public bool $selectAll = false; // свойство для чекбокса "выбрать все"
    public $suggestions = []; // массив предложений вариантов адреса

    // переменные для заказа
    public float $totalPrice = 0; // Общая сумма корзины
    public $addressString = ''; //гл адресная строка
    public array $selectedCartItems = []; //массив выбранных элементов корзины
    public $apartment_number = '';
    public $doorphone = '';
    public $entrance = '';
    public $floor = '';
    public $phone = '';
    public $quantity; // колво товара в коризщне пользолвателя (одного товара) 


    public function mount()
    {
        $this->cartItems = auth()->user()->cartItems; //все товары пользователя с данным id
    }

    // метод при фокусе на  инпут ввода адреса доставки
    public function AddressinputFocused()
    {
        $this->showAddressesExample = true;
    }
    // метод при снятии фокуса с  инпута ввода адреса доставки
    public function AddressinputBlur()
    {
        $this->showAddressesExample = false;
    }

    // метод при выборе одного из вариантов адреса
    public function selectExampleAddress($addressText)
    {
        $this->addressString = $addressText;
        $this->showAddressesExample = false; // закрываем строки с вариантами адресов
        $this->showAddressesAddons = true; // открываем доп поля для адреса и телефон
    }


    public function updatedAddressString()
    {
        // Проводим запрос к Yandex API, если текст больше 2 символов
        if (strlen($this->addressString) > 3) {
            $this->getSuggestions($this->addressString);
        } else {
            $this->suggestions = [];
        }
    }

    public function getSuggestions($text)
    {
        $apikey = '40e203c6-408e-4bb6-9cbc-275d9d67a54e';
        $url = 'https://suggest-maps.yandex.ru/v1/suggest';

        $response = Http::get($url, [
            'apikey' => $apikey,
            'text' => $text
        ]);

        if ($response->successful()) {
            $results = $response->json()['results'] ?? [];
    
            // Очищаем и форматируем
            $this->suggestions = collect($results)->map(function ($item) {
                return [
                    'title' => $item['title']['text'] ?? '',
                    'subtitle' => $item['subtitle']['text'] ?? '',
                ];
            })->toArray();


        } else {
            $this->suggestions = [];
        }
    }
    //удаление выбранных элементов
    public function deleteSelected() 
    {
        if($this->selectedCartItems){
            // Удаляем модели из базы
            $this->cartItems->whereIn('id', $this->selectedCartItems)->each->delete(); //whereNotIn - удаляет из коллекции строки с айди находящимеся в массиве selectedCartItems
            //values - пересобирает ключи массива
             // Удаляем их из коллекции
            $this->cartItems = $this->cartItems
            ->whereNotIn('id', $this->selectedCartItems)
            ->values();
            $this->selectAll = false;
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
        foreach ($this->selectedCartItems as $itemId){ //цикл по айдишнику выбранных элементов корзины
            $item = $this->cartItems->find($itemId); // $item - один из выбранных элементов корзины
            if ($item){ //если элемент найден то колво умножается на прайс элемента
                $this->totalPrice += $item->quantity * $item->product->price; 
            }

        }
    }

    public function incrementQuantity($id)
    {  
        $this->cartItem = $this->cartItems->find($id); // выбираем из списка товаров корзины один
        $this->quantity = $this->cartItem->quantity;        
        if ($this->quantity < $this->cartItem->colorProduct->stock) { // проверка, что количество эл корзины данного цвета не превышает остатки товара на складе
            $this->quantity++;
            $this->cartItem->quantity = $this->quantity; // присвоение элементу корзины измененного значения количества
            $this->cartItem->save(); //сохранение изменений элемента корзины
        }
        $this->updatedSelectedCartItems(); // при изменении количества товара вызывается функция общей стоимости корзины    
    }
    

    public function decrementQuantity($id)
    {
            $this->cartItem = $this->cartItems->find($id); // выбираем из списка товаров корзины один
            $this->quantity = $this->cartItem->quantity;
            if ($this->quantity > 1){ 
                $this->quantity--;
                $this->cartItem->quantity = $this->quantity; // присвоение элементу корзины измененного значения количества
                $this->cartItem->save(); //сохранение изменений элемента корзины
            }   
            $this->updatedSelectedCartItems(); // при изменении количества товара вызывается функция общей стоимости корзины    
    }
    
    

    //подтверждение заказа
    function OrderConfirm() {
        $this->validate([
            'apartment_number' => 'required|string|min:3',
            'doorphone' => 'required|min:1',
            'entrance' => 'required|min:1',
            'floor' => 'required|min:1',
            'phone' => 'required|min:5',
            'addressString' => 'required|string|min:5',
            'totalPrice' => 'required|min:1',
        ]);

        //созхранение адреса
        $address = Address::create([
            'user_id' =>auth()->user()->id,
            'phone' => $this->phone,
            'address_text' => $this->addressString,
            'apartment_number' => $this->apartment_number,
            'doorphone' => $this->doorphone,
            'entrance' => $this->entrance,
            'floor' => $this->floor,
        ]);

        // сохранение заказа
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'address_id' => $address->id,
            'total_price' => $this->totalPrice,

        ]);

        // сохранение элементов заказа
        $selectedItems = CartItem::whereIn('id', $this->selectedCartItems)->get();
        foreach ($selectedItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'color_id' => $item->colorProduct->color_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

           // Обновление остатка в таблице колос продукт
            $colorProduct = $item->colorProduct;
            $colorProduct->stock -= $item->quantity;
            $colorProduct->save();
         }
        //  удаляем из корзины выбранные элементы
         CartItem::whereIn('id', $this->selectedCartItems)->delete();
         // обновляем массив элементов корзины
         $this->cartItems = $this->cartItems->whereNotIn('id', $this->selectedCartItems)->values();
          //  Очищаем форму, закрываем модалку и показываем сообщение
        $this->reset([
            'apartment_number',
            'doorphone',
            'entrance',
            'floor',
            'phone',
            'addressString',
            'selectedCartItems',
            'totalPrice',
        ]);
        // Удаляем только те ColorProduct, где stock <= 0
        // ColorProduct::where('stock', '<=', 0)->delete();
        $this->showCheckoutModal = false;

        $this->dispatchBrowserEvent('order-success');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
