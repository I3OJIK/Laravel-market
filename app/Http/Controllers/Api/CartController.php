<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

     /**
     * Получить содержимое корзины.
     *
     * Получает список товаров, добавленных пользователем в корзину.
     *
     * @group Корзина
     * @authenticated
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "quantity": 2,
     *       "product": {
     *         "id": 5,
     *         "name": "Футболка",
     *         "description": "Описание товара",
     *         "price": 1500,
     *         "image_url": null
     *       },
     *       "color": {
     *         "id": 1,
     *         "name": "Красный"
     *       }
     *     }
     *   ]
     * }
     */
     public function index()
    {
        $cartItems = $this->cartService->getUserCartItems(Auth::id());
        
        return CartItemResource::collection($cartItems);

        return response()->json([
            'data' => $formattedItems
        ]);
    }

    /**
     * Добавить товар в корзину.
     *
     * Добавляет товар с указанным цветом в корзину пользователя.  
     * Если товар уже есть в корзине, его количество будет обновлено.
     *
     * @group Корзина
     * @authenticated
     * @bodyParam product_id int required ID товара. Пример: 5
     * @bodyParam color_product_id int required ID цвета товара. Пример: 3
     * @response 201 {
     *   "message": "Товар добавлен в корзину",
     *   "item": {
     *     "id": 63,
     *     "user_id": 2,
     *     "product_id": 1,
     *     "color_product_id": 3,
     *     "quantity": 1,
     *     "created_at": "2025-08-06T14:13:23.000000Z",
     *     "updated_at": "2025-08-06T14:13:23.000000Z",
     *     "deleted_at": null
     *   }
     * }
     */
    public function store(StoreCartItemRequest $request)
    {
        $data = $request->validated();

        $cartItem = $this->cartService->addOrUpdateCartItem(
            $data['product_id'],
            $data['color_product_id'],
            1
        );
        
        if ( $cartItem) {
            return response()->json([
                'message' => 'Товар добавлен в корзину',
                'item' => $cartItem
            ], 201);
        }
        

    }

    /**
     * Изменить количество товара в корзине.
     *
     * Увеличивает или уменьшает количество выбранного товара в корзине.
     *
     * @group Корзина
     * @authenticated
     * @urlParam id int required ID элемента корзины. Пример: 12
     * @bodyParam delta int required Изменение количества: `1` — увеличить, `-1` — уменьшить. Пример: 1
     * @response 200 {
     *   "quantity": 3
     * }
     * @response 404 {
     *   "message": "Элемент не найден"
     * }
     */
    public function update(Request $request,int $id)
    {
        $validated = $request->validate([
            'delta' => 'required|integer|in:1,-1',
        ]);

        $item = $this->cartService->changeCartItemQuantity(
            Auth::id(),
            $id,
            $validated['delta'],
        );

        if ($item === null) {
            return response()->json(['message' => 'Элемент не найден'], 404);
        }

        return response()->json(['quantity' => $item]);
    }
    
    /**
     * Удалить товар из корзины.
     *
     * Удаляет конкретный элемент корзины по его ID.
     *
     * @group Корзина
     * @authenticated
     * @urlParam id int required ID элемента корзины. Пример: 12
     * @response 200 {
     *   "message": "Товар удалён"
     * }
     */
    public function destroy(int $id)
    {
        $this->cartService->deleteCartItems(Auth::id(), [$id]);
        return response()->json(['message' => 'Товар удалён']);

    }

     /**
     * Очистить корзину.
     *
     * Удаляет все товары из корзины текущего пользователя.
     *
     * @group Корзина
     * @authenticated
     * @response 200 {
     *   "message": "Корзина очищена"
     * }
     */
    public function clear()
    {
        $items = $this->cartService->getUserCartItems(Auth::id());
        $ids = $items->pluck('id')->toArray();

        if (!empty($ids)) {
            $this->cartService->deleteCartItems(Auth::id(), $ids);
        }
    
        return response()->json(['message' => 'Корзина очищена']);

    }

}
