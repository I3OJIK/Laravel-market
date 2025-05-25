<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $guarded =[];
    use SoftDeletes;

    public function subcategories()
    {
        // одному продукту может принадлежать несколько подкатегорий
        return $this->belongsToMany(Subcategory::class);
    }

    public function category()
    {
        // одному продукту может принадлежать несколько подкатегорий
        return $this->belongsTo(Category::class);
    }
    
    public function colors()
    {
        // одному продукту может принадлежать несколько цветов
        return $this->belongsToMany(Color::class )
                    ->withPivot('stock');
    }
}
