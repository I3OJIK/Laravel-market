<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Категории товаров
 *
 * @property int $id
 * @property string $name
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\subcategory[] $subcategories
 */
class Category extends Model
{
    protected $guarded =[];
    public $timestamps = false;
    
    /**
     * Получить подкатегории (Subcategories), которые относятся к выбранной категории
     * 
     * @return hasMany
     */
    public function subcategories(): hasMany
    {
        // одной категории принадлежит много подкатегорий
        return $this->hasMany(Subcategory::class);
    }
}

