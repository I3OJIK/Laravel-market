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
    public array $selectedCartItems = []; //массив выбранных элементов корзины
    public bool $selectAll = false; // свойство для чекбокса "выбрать все"

    public function mount()
    {
       $this->cartItems = CartItem::where('user_id', Auth::id())->get(); //все товары пользователся с данным id

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
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
