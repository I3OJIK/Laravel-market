<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

/**
 * Цвет товара
 *
 * @property int $id
 * @property string $name Название цвета
 * @property string $color_class CSS-класс для отображения цвета (например, 'bg-red-500')
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products Продукты, связанные с цветом (многие ко многим)
 */
class Color extends Model
{
    /**
     * Получить продукты (Products), имеющие данный цвет
     * 
     * @return belongsToMany
     */
    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot(['id', 'stock']);
    }
}
