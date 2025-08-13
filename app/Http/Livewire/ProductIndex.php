<?php

namespace App\Http\Livewire;

use App\Models\cartItem;
use App\Models\ColorProduct;
use App\Services\CartService;
use App\Models\Product;
use App\Services\ColorProductService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Компонент Livewire оботражающий страницу продукта.
 *
 * Функии:
 * - Загрузка выбранного продукта
 * - Выбор цвета и количества
 * - Добавление/обновление товара в корзине
 *
 * @property CartService $cartService Сервис работы с корзиной
 * @property ColorProductService $colorService Сервис работы с pivot-записью color_product (остатки по цвету)
 * @property Product|null $selectedProduct Выбранный продукт (модель Product)
 * @property ColorProduct|null $selectedColorProduct selectedColorProduct
 * @property int|null $selectedColorid ID выбранного цвета
 * @property int|null $quantity Количество товара в корзине
 */
class ProductIndex extends Component
{
    protected CartService $cartService;             // инициализация сервиса корзины
    protected ColorProductService $colorService;    // инициализация сервиса цветов
    public $selectedProduct;                        // выбранный продукт
    public $selectedColorId;                        // айди выбранного цвета
    public $quantity;                               // количество товара в корзине   


    /**
     * Инициализация сервисов через контейнер зависимостей
     *
     * @param CartService $cartService
     * @param ColorProductService $colorService
     */
    public function boot(CartService $cartService, ColorProductService $colorService): void
    {
        $this->cartService = $cartService;
        $this->colorService = $colorService;
    }

    /**
     * Инициализация компонента при монтировании
     *
     * @param int $id ID продукта
     */
    public function mount(int $id): void
    {
        $this->selectedProduct = Product::with('colors')->find($id);

        if($item = $this->cartItem){
            $this->selectedColorId = $item->colorProduct->color_id;
            $this->quantity        = $item->quantity;
        }
      
    }

    /**
     * Получить текущий товар в корзине пользователя.
     *
     * @return CartItem|null
     */
    public function getCartItemProperty(): ?CartItem
    {
        if (! $this->selectedProduct) {
            return null;
        }

        return $this->cartService->getExistingCartItem(
            $this->selectedProduct->id,
            $this->colorProduct ? $this->colorProduct->id : null
        );
    }

    /**
     * Получить Pivot-модель связи продукта и цвета.
     *
     * @return ColorProduct|null
     */
    public function getColorProductProperty(): ?ColorProduct
    {
        if (! $this->selectedColorId) {
            return null;
        }

        return $this->colorService->getColorProduct(
            $this->selectedProduct->id,
            $this->selectedColorId
        );
    }

    /**
     * Выбранный цвет товара
     *
     * @param int $colorId ID цвета
     * 
     * @return void
     */
    public function selectColor(int $colorId): void
    {
        $this->selectedColorId = $colorId;
        $this->quantity = $this->cartItem ? $this->cartItem->quantity : 1;

    }

     /**
     * Изменить количество товара
     *
     * @param int $action Действие (1 - увеличение, -1 - уменьшение)
     * 
     * @return void
     */
    public function changeQuantity(int $action): void
    {
        $this->quantity = $this->cartService->changeCartItemQuantity(
            Auth::id(),
            $this->selectedProduct->id,
            $action,
        );
    }

    /**
     * Добавить или обновить товар в корзине.
     * 
     * @return void
     */
    public function addCartItem(): void
    {
        if (!Auth::check()) {
            redirect()->route('login');
            return;
        }

        if (!$this->colorProduct) {
            session()->flash('message', 'Выберите цвет');
            return;
        } 

        $this->cartService->addOrUpdateCartItem(
            $this->selectedProduct->id,
            $this->colorProduct->id,
            $this->quantity
        );
        // обновление элемента корзины
    }

    public function render()
    {
        return view('livewire.product-index',[
            'cartItem'=>$this->cartItem,
            'colorProduct'=>$this->colorProduct,
        ]);
    }
}
