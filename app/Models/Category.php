<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $guarded =[];

    public function subcategories()
    {
        // одной категории принадлежит много подкатегорий
        return $this->hasmany(Subcategory::class);
    }
}

