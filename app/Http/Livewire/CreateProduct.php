<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class CreateProduct extends Component
{
    public $name;
    public $price;
    public $description;
    public $stock_quantity;

    public function save()
    {
         // Простая валидация
         $this->validate([
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|min:0',
            'stock_quantity' => 'required|numeric|min:0',
        ]);

        // Сохраняем продукт
        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'stock_quantity' => $this->stock_quantity,
        ]);

        // Сброс полей формы
        $this->reset(['name', 'price','stock_quantity']);

        // Сообщение об успехе
        session()->flash('success', 'Товар добавлен!');
    }
    public function render()
    {
        return view('livewire.create-product');
    }
}
