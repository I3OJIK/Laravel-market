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
     * Получить содержимое корзины
     * 
     * @response {
     *   "data": [{
     *     "id": 1,
     *     "quantity": 2
     *     "product": {"id": 5, "name": "Футболка","description":dsfs "price": 1500, "image_url": null},
     *     "color": {id: 1,"name": "Красный"}},
     *   }]
     * }
     */
     public function index()
    {
        $cartItems = $this->cartService->getUserCartItems(2);
        
        return CartItemResource::collection($cartItems);

        return response()->json([
            'data' => $formattedItems
        ]);
    }

    /**
    *
    * Добавляет товар с указанным цветом в корзину пользователя. Если товар уже есть — обновляет его количество.
    *
    * @group Корзина
    *
    * @bodyParam product_id int required ID товара. Пример: 5
    * @bodyParam color_product_id int required ID pivot таблицы цвета товара. Пример: 3
    *
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
    *
    * 
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
}
