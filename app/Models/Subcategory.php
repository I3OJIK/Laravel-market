<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $guarded =[];
    public function products()
    {
        // одной категории может принадлежать много продуктов
        return $this->belongsToMany(Product::class);
    }
    public function category()
    {
        // одной подкатегории принадлежит одна категория
        return $this->belongsTo(Category::class);
    }
}
