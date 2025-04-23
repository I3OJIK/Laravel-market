<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class HomeProductList extends Component
{

    public $products;
    public $product;
    public $selectedProduct;
    public $initialId; 

    protected $listeners = ['resetSelection'];

    public function mount($initialId = null)
    {
        $this->products = Product::inRandomOrder()->take(8)->get();
        
        if ($initialId){
            $this->loadProduct($initialId);
        }
    }

    public function resetSelection()
    {
        $this->selectedProduct = null;
    }

    public function loadProduct($id)
    {
        $this->selectedProduct = Product::find($id);
        // шлём браузеру событие, чтобы изменить URL без перезагрузки
        $this->dispatchBrowserEvent('pushState', [
            'url' => route('product.show', ['id' => $id])
        ]);
    }
    public function render()
    {
        return view('livewire.home-product-list');
    }
}
