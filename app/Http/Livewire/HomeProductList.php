<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class HomeProductList extends Component
{

    public $products;


    protected $listeners = ['resetSelection'];

    public function mount()
    {
        $this->products = Product::inRandomOrder()->take(8)->get();
        
    }

    public function loadProduct($id)
    {

        return redirect()->route('product.show', ['id' => $id]);
    }
    public function render()
    {
        return view('livewire.home-product-list');
    }
}
