<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Элемент заказа 
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $color_id
 * @property int $quantity Количество товара
 * @property int $price цена
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Color $color
 */
class OrderItem extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    /**
     * Каждый OrderItem принадлежит одному заказу
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class); 
    }

     /**
     * Каждый OrderItem принадлежит одному продукту
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Каждый OrderItem принадлежит одному цвету
     *
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class); 
    }
}
