<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use App\Models\ColorProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductIndex extends Component
{
    public $selectedProduct;
    public $existingItem;
    public $colorProductStock;
    public $selectedColorPivot;
    public $selectedColorid;

    public $quantity;

    public function checkExitingProductInCart()
    {
        $this->existingItem = CartItem::where('user_id', Auth::id())
        ->where('product_id',  $this->selectedProduct->id)
        ->first(); //возвращает первую найденную запись
        
        if ( $this->existingItem){
            $this->quantity = $this->existingItem->quantity;
            $this->selectedColorPivot = ColorProduct::where('product_id', $this->selectedProduct->id)
                ->where('id', $this->existingItem->color_product_id )
                ->first();
            $this->colorProductStock = $this->selectedColorPivot->stock;
            $this->selectedColorid = $this->selectedColorPivot->color_id;
        }
    }
    public function mount($id)
    {
        $this->selectedProduct = Product::find($id);
        //проверка есть ли товар в корзине 
        $this->checkExitingProductInCart();
        

        
    }
    // при выборе отпределенного цвета вызывается метод, присваивающий переменной остаток товара 
    public function selectColor($colorId)
    {
        
        $this->selectedColorPivot = ColorProduct::where('product_id', $this->selectedProduct->id)
                        ->where('color_id', $colorId)
                        ->first();
        $this->selectedColorid = $this->selectedColorPivot->color_id;
        $this->colorProductStock = $this->selectedColorPivot->stock;

        // Проверяем, есть ли в корзине этот товар именно с этим pivot-id
        $this->existingItem = CartItem::where([
            'user_id'           => Auth::id(),
            'product_id'        => $this->selectedProduct->id,
            'color_product_id'  => $this->selectedColorPivot->id,
        ])->first();

        // Устанавливаем quantity: либо из корзины, либо дефолт (1)
        $this->quantity = $this->existingItem
            ? $this->existingItem->quantity
            : 1;
    }

        public function incrementQuantity()
    {
        if ($this->selectedColorPivot){
            if ($this->quantity < $this->selectedColorPivot->stock) {
                $this->quantity++;
                $this->existingItem->quantity =  $this->quantity; // добавление в бд
                $this->existingItem->save();
            }
        }
    }

    public function decrementQuantity()
    {
        if ($this->selectedColorPivot){
            if ($this->quantity > 1){
                $this->quantity--;
                $this->existingItem->quantity =  $this->quantity;
                $this->existingItem->save();
            }
        }   
    }
   
    // добавление товара в корзину
    public function addCartItem()
    {
        
        if (!Auth::check()){
            return redirect()->route('login');
        }
        if ($this->selectedColorPivot){
            $this->existingItem = CartItem::updateOrCreate(
                [
                    'user_id'          => Auth::id(),
                    'product_id'       => $this->selectedProduct->id,
                    'color_product_id' => $this->selectedColorPivot->id,
                ],
                ['quantity' => $this->quantity]
            );
        }
    }

    public function render()
    {
        return view('livewire.product-index');
    }
}
