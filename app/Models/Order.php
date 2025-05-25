<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    protected static function boot()
    {
        parent::boot();

        // При мягком удалении
        static::deleting(function($order) {
            if ($order->isForceDeleting()) {
                // Полное удаление
                $order->orderItems()->forceDelete();
            } else {
                // Мягкое удаление
                $order->orderItems()->delete();
            }
        });

        // При восстановлении
        static::restoring(function($order) {
            $order->orderItems()->restore();
        });
    }
    
    public function orderItems()
    {
         // Определение связи с моделью OrderItem (Один Order может иметь несколько OrderItems)
        return $this->hasMany(OrderItem::class);// В заказе могут быть несколько товаров
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
