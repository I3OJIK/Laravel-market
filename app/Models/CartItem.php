<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\belongsTo;


/**
 * Элемент корзины
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $color_product_id
 * @property int $quantity Количество товара в корзине
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\ColorProduct $colorProduct
 */
class CartItem extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    /**
     * User, которому принадлежит выбранный элемент корзины
     * 
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        // однин элемент корзины пренадлежит одному пользваотелю
        return $this->belongsTo(User::class);
    }
    
    /**
     * Product, которому принадлежит выбранный элемент корзины
     * 
     * @return belongsTo
     */
    public function product(): belongsTo
    {
        // один элемент корзины может принадлежать одному проудкту
        return $this->belongsTo(Product::class);
    }
     // связь на pivot-запись, где хранится stock

    /**
     * // связь на pivot-таблицу colorProduct, в которой хранится stock товара
     * 
     * @return belongsTo
     */
    public function colorProduct(): belongsTo
    {
        return $this->belongsTo(ColorProduct::class);
    }
}
