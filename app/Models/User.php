<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function cartItems()
    {
        //один пользователь может иметь несколько товаров в корзине
        return $this->hasMany(CartItem::class);
    }
    
    public function addresses()
    {
        //один пользователь может иметь несколько адресов
        return $this->hasMany(Address::class);
    }
    public function orders()
    {
        //один пользователь может иметь несколько заказов
        return $this->hasMany(Order::class);
    }
    
    
}
