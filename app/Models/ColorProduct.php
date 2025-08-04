<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

/**
 * Пивот таблица Цвет-продукт (содержит строку с остатком товара данного цвета)
 *
 * @property int $id
 * @property int $product_id
 * @property int $color_id
 * @property int $stock Остаток товара
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \App\Models\Color $color
 */
class ColorProduct extends Model
{
    protected $table = 'color_product';
    protected $guarded =[];

    /**
     * Color, связанный с данной таблицей
     * 
     * @return belongsTo
     */
    public function color(): belongsTo
    {
        return $this->belongsTo(Color::class); 
    }

}
