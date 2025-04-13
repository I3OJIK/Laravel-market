<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    public function products()
    {
        // одной категории может принадлежать много продуктов
        return $this->belongsToMany(Product::class);
    }
}
