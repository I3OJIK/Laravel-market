<?php

namespace App\Models;

use App\Services\RedisCache\ProductCacheService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

/**
 * Продукт
 *
 * @property int $id
 * @property int $category_id
 * @property string $name имя 
 * @property string $description описаниие
 * @property int $price цена
 * @property string|null $image_url ссылка на фото
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subcategory[] $subcategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Color[] $colors
 */
class Product extends Model
{
    protected $guarded =[];
    use SoftDeletes;


    /**
     * Удаление кэша
     * 
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function ($product) {
            app(ProductCacheService::class)->clearCache($product->id);
        });
    
        static::deleted(function ($product) {
            app(ProductCacheService::class)->clearCache($product->id);
        });
    }
    /**
     * Получить все подкатегории, к которым относится продукт.
     *
     * @return BelongsToMany
     */
    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class);
    }

    /**
     * Получить категорию, к которой относится продукт.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        // одному продукту может принадлежать несколько подкатегорий
        return $this->belongsTo(Category::class);
    }
    
     /**
     * Получить все цвета, доступные для данного продукта.
     *
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class )
                    ->withPivot(['id', 'stock']);
    }
}
