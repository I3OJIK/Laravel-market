<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property string $status статус заказа например (Processing)
 * @property int $total_price Итоговая сумма заказа
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 */
class Order extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    protected static function boot()
    {
        parent::boot();

        // Обработка удаления связанных товаров заказа
        static::deleting(function ($order) {
            if ($order->isForceDeleting()) {
                $order->orderItems()->forceDelete(); // Полное удаление
            } else {
                $order->orderItems()->delete();      // Мягкое удаление
            }
        });

        // При восстановлении заказа — восстановить и связанные товары
        static::restoring(function ($order) {
            $order->orderItems()->restore();
        });
    }

    /**
     * Получить позиции (orderItems), которые относятся к заказу
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
         // Определение связи с моделью OrderItem (Один Order может иметь несколько OrderItems)
        return $this->hasMany(OrderItem::class);// В заказе могут быть несколько товаров
    }


     /**
     * Получить адресс который относится к заказу
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
