<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    public function orderItems()
    {
         // Определение связи с моделью OrderItem (Один Order может иметь несколько OrderItems)
        return $this->hasMany(OrderItem::class);// В заказе могут быть несколько товаров
    }
}
