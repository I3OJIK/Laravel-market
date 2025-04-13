<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    public function order()
    {
         // Определение связи с моделью Order (Один OrderItem принадлежит одному Order)
        return $this->belongsTo(Order::class); // foreign_id в таблице order_items будет ссылаться на id в таблице orders
    }

    public function product()
    {
         // Определение связи с моделью Order (Один OrderItem принадлежит одному Product)
        return $this->belongsTo(Product::class); // foreign_id в таблице order_items будет ссылаться на id в таблице products
    }
}
