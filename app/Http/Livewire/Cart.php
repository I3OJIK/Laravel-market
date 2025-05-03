<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems;
    public $cartItem;
    public $quantity;
    public $showCheckoutModal = false;
    public array $selectedCartItems = []; //массив выбранных элементов корзины
    public bool $selectAll = false; // свойство для чекбокса "выбрать все"
    public float $totalPrice = 0; // Общая сумма корзины
    public $deliveryAddress = '';



    public function mount()
    {
        $this->cartItems = auth()->user()->cartItems; //все товары пользователся с данным id
    
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

        }
    }

    //метод вызывается автоматически при изменении чекбокса (при вкл/выкл чекбокса "выбрать все")
    public function updatedSelectAll($value) 
    {
        if ($value) {
            // выбрать все id из списка
            $this->selectedCartItems = $this->cartItems->pluck('id')->toArray();
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

    public function render()
    {
        return view('livewire.cart');
    }
}
