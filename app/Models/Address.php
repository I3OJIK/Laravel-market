<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    protected $guarded =[];
    use SoftDeletes;
    public function user()
    {
        // один адрес принадлежит одному пользователю
        return $this->belongsTo(User::class);
    }
    
    public function orders()
    {
        // один адрес может имиеть несколько заказов
        return $this->hasMany(Order::class);
    }

}
