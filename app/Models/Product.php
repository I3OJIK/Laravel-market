<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $guarded =[];
    use SoftDeletes;
    public function categories()
    {
        // одному продукту может принадлежать несколько категорий
        return $this->belongsToMany(Category::class);
    }
    
    public function colors()
    {
        // одному продукту может принадлежать несколько цветов
        return $this->belongsToMany(Color::class)
                    ->withPivot('stock');
    }
}
