<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    public function user()
    {
        // однин элемент корзины пренадлежит одному пользваотелю
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        // один элемент корзины может принадлежать одному проудкту
        return $this->belongsTo(Product::class);
    }
     // связь на pivot-запись, где хранится stock
    public function colorProduct()
    {
        return $this->belongsTo(ColorProduct::class);
    }
}
