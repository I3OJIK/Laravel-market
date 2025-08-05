<?php
namespace App\Services;

use App\Models\CartItem;
use App\Models\ColorProduct;
use Illuminate\Support\Facades\Auth;

class ColorProductService
{
        /**
         * @param int $productId
         * @param int $colorId
         * 
         * @return ColorProduct|null
         */
        public function getColorProduct(int $productId, int $colorId): ?ColorProduct //Метод возвращает объект ColorProduct, если найден подходящий результат
        {
            return ColorProduct::where('product_id', $productId)
                ->firstWhere('color_id', $colorId);
        }   
}
