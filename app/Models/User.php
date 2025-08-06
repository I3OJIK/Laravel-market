<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Пользователь
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|\App\Models\CartItem[] $cartItems
 * @property-read Collection|\App\Models\Address[] $addresses
 * @property-read Collection|\App\Models\Order[] $orders
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;


    protected $fillable = [
        'name', 'email', 'password','role',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Получить все элементы корзины пользователя.
     * 
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        //один пользователь может иметь несколько товаров в корзине
        return $this->hasMany(CartItem::class);
    }
    
    /**
     * Получить все адреса пользователя.
     * 
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        //один пользователь может иметь несколько адресов
        return $this->hasMany(Address::class);
    }

    /**
     * Получить все заказы пользователя.
     * 
     * @return HasMany
     */
    public function orders(): HasMany
    {
        //один пользователь может иметь несколько заказов
        return $this->hasMany(Order::class);
    }
    
     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
}
