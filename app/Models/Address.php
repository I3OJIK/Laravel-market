<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Адресс
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $address_text Основная строка адреса например (Нижний Новгород, Красносельская улица, 2)
 * @property string|null $apartment_number номер кв/офиса
 * @property string $doorphone домофон
 * @property string $entrance подьезд
 * @property string $floor этаж
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 */
class Address extends Model
{
    protected $guarded =[];
    use SoftDeletes;

    /**
     * Получение User'a, которому принадлежит выбранный адрес
     * 
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        // один адрес принадлежит одному пользователю
        return $this->belongsTo(User::class);
    }
    
    /**
     * Получение одного или нескольких заказов
     * принадлежащих выбранному адресу
     * 
     * @return belongsTo
     */
    public function orders(): HasMany
    {
        // один адрес может имиеть несколько заказов
        return $this->hasMany(Order::class);
    }

}
