<?php
namespace App\Services;

use App\Models\CartItem;
use App\Models\ColorProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    //если данный товар или товар с данным цветом есть в корзине выведет его, иначе null
    /**
     * Выводит модель CartItem с определенным productId и colorProductId (если указан)
     * 
     * @param int $productId
     * @param int|null|null $colorProductId
     * 
     * @return null|CartItem
     */
    public function getExistingCartItem(int $productId, $colorProductId = null): ?CartItem
    {
        return CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->when($colorProductId, fn($q) => $q->where('color_product_id', $colorProductId))
            ->with('colorProduct')
            ->first();
    }
    
    // обновление количества товара в корзине
    public function changeCartItemQuantity(int $productId, int $colorProductId, int $delta) // : void - функция нчиего не возвращает
    {
        // элемент у кторого изменяется Quantity
        $item = $this->getExistingCartItem($productId, $colorProductId);
        
        // если элемент не найден закончить 
        if (!$item) {
            return;
        }

        // проверка для избежания превышения количетсва товра в корзине от количетсва товара на складе
        if ($delta === 1 && $item->colorProduct->stock > $item->quantity) {
            $item->increment('quantity');
        } elseif ($delta === -1 && $item->quantity > 1) {
            $item->decrement('quantity');
        }
        return $item->quantity;
    }

    // создание или обновление элемента корзины
    public function addOrUpdateCartItem($productId, $colorProductId, $quantity)
    {
        return CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'color_product_id' => $colorProductId,
            ],
            ['quantity' => $quantity]
        );
    }

    public function getUserCartItems(int $userId)
    {
        return CartItem::with(['product', 'colorProduct'])
            ->where('user_id', $userId)
            ->get();
            
    }

    public function deleteCartItems(int $userId, array $CartItems): void
    {
        $items = $this->getUserCartItems($userId);
        // Удаляем модели из базы
        $items->whereIn('id', $CartItems)->each->delete(); //whereNotIn - удаляет из коллекции строки с айди находящимеся в массиве selectedCartItems

    }

}
