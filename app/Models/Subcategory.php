<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Подкатегории
 *
 * @property int $id
 * @property string $name
 * @property string $description описание
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 */
class Subcategory extends Model
{
    protected $guarded =[];

    /**
     * Получить все продукты, относящиеся к подкатегории.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        // одной категории может принадлежать много продуктов
        return $this->belongsToMany(Product::class);
    }

    /**
     * Получить категорию, к которой относится подкатегория.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        // одной подкатегории принадлежит одна категория
        return $this->belongsTo(Category::class);
    }

  
}
