<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorProduct extends Model
{
    protected $table = 'color_product';
    protected $guarded =[];

    public function color()
    {
         // Определение связи с моделью Order (Один OrderItem принадлежит одному Order)
        return $this->belongsTo(Color::class); // foreign_id в таблице order_items будет ссылаться на id в таблице orders
    }

}
