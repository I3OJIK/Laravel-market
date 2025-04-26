<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function products()
    {
        // одному продукту может принадлежать несколько категорий
        return $this->belongsToMany(Product::class)
                    ->withPivot('stock');
    }
}
