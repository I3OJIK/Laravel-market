<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\ColorProduct;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{

    
    public function placeOrder(
        int $userId,
        array $addressData,
        array $selectedItemsIds,
        int $totalPrice,
        AddressService $addressService,
        CartService $cartService
    ): Order {
        return DB::transaction(function () use (
            $userId,
            $addressData,
            $selectedItemsIds,
            $totalPrice,
            $cartService,
            $addressService
        ) {
            //созхранение адреса
            $address = $addressService->save(
                $userId,
                $addressData
            );

            // сохранение заказа
            $order = Order::create([
                'user_id' => $userId,
                'address_id' => $address->id,
                'total_price' => $totalPrice,
            ]);
            //товары входящие в заказ
            $items = CartItem::whereIn('id', $selectedItemsIds)->get();
            // добавление товаров заказа в таблицу и обновление остатокв товара
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'color_id' => $item->colorProduct->color_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
    
                // Обновление остатка в таблице колор продукт
                $item->colorProduct->decrement('stock', $item->quantity);
            }

            //удаление из корзины оформленных товаров
            $cartService->deleteCartItems($userId, $selectedItemsIds);

            return $order;
        });
    }
}
