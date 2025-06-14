<?php

namespace App\Http\Livewire;

use App\Models\CartItem;
use App\Models\ColorProduct;
use App\Services\CartService;
use App\Models\Product;
use App\Services\ColorProductService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductIndex extends Component
{
    protected CartService $cartService;             // инициализация сервиса корзины
    protected ColorProductService $colorService;    // инициализация сервиса цветов

    public $selectedProduct;                        // выбранный продукт
    public $cartItem;                               // элемент находящийся в корзине
    public $colorProductStock;                      // остаток товара данного цвета
    public $selectedColorProduct;                   // пивот таблицы выбранного цвета
    public $selectedColorid;                        // айди выбранного цвета
    public $quantity;                               // количество товара в корзине   


    public function boot(CartService $cartService, ColorProductService $colorService)
    {
        $this->cartService = $cartService;
        $this->colorService = $colorService;
    }

    public function mount($id)
    {
        $this->selectedProduct = Product::with('colors')->find($id);

        // Предустановка, если товар уже в корзине
        $this->cartItem = $this->cartService->getExistingCartItem($this->selectedProduct->id);
        //проверка есть ли товар в корзине 
        if ($this->cartItem) {
            $this->quantity = $this->cartItem->quantity;
            $this->selectedColorProduct = $this->cartItem->colorProduct;
            $this->colorProductStock = $this->cartItem->colorProduct->stock;
            $this->selectedColorid = $this->cartItem->colorProduct->color_id;
        }
    }
    public function loadCartItem()
    {
        $this->cartItem = $this->cartService->getExistingCartItem(
            $this->selectedProduct->id,
            $this->selectedColorProduct->id
        );
        $this->quantity = $this->cartItem->quantity ?? 1;
    }

    // при выборе отпределенного цвета вызывается метод, присваивающий переменной остаток товара 
    public function selectColor($colorId)
    {
        // получение пивот записи с выбранным цветом
        $this->selectedColorProduct = $this->colorService->getColorProduct($this->selectedProduct->id, $colorId);
        $this->colorProductStock = $this->selectedColorProduct->stock;

        // Проверяем, есть ли в корзине этот товар именно с этим pivot-id
        // Устанавливаем quantity: либо из корзины, либо дефолт (1)
        $this->loadCartItem();
    }

    // изменение количества товара в коризне
    public function changeQuantity(int $action)
    {
        $this->quantity = $this->cartService->changeCartItemQuantity(
            $this->selectedProduct->id,
            $this->selectedColorProduct->id,
            $action,
        );
    }

    // добавление товара в корзину
    public function addCartItem()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->selectedColorProduct) {
            session()->flash('message', 'Выберите цвет');
            return;
        }
        $this->cartService->addOrUpdateCartItem(
            $this->selectedProduct->id,
            $this->selectedColorProduct->id,
            $this->quantity
        );
        // обновление элемента корзины
        $this->loadCartItem();
    }

    public function render()
    {
        return view('livewire.product-index');
    }
}
