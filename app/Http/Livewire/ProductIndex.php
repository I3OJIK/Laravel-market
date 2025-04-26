<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductIndex extends Component
{
    public $selectedProduct;
    public $selectedStock;
    public function mount($id)
    {
        $this->selectedProduct = Product::find($id);

    }

    // при выборе отпределенного цвета вызывается метод, присваивающий переменной selectedStock остаток товара 
    public function selectColor($stock)
    {
       $this->selectedStock = $stock;
    }

    public function render()
    {
        return view('livewire.product-index');
    }
}
