<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;

class HomeProductList extends Component
{

    protected $products;
    public $categories;

    // protected $listeners = ['resetSelection'];

    public function mount()
    {
       
        // $this->products = Product::inRandomOrder()->take(8)->get();
        $this->products = Product::paginate(16);
        $this->categories = Category::all();

        
    }

    public function loadProduct($id)
    {

        return redirect()->route('product.show', ['id' => $id]);
    }
    public function render()
    {
        return view('livewire.home-product-list', [
            'products' => $this->products
        ]);
    }
}
