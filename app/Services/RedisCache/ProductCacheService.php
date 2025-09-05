<?php

namespace App\Services\RedisCache;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\ColorProduct;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProductCacheService
{
    /**
     * Создание ключа для кэша
     * 
     * @param int|null $subcategoryId
     * @param string $searchInput
     * @param string $sortField
     * @param string $sortDirection
     * @param int $page
     * 
     * @return string
     */
    private function makeCacheKey(?int $subcategoryId, ?string $searchInput, string $sortField, string $sortDirection, int $page) : string
    {
        // Если поисковой запрос пустой либо меньше 3 символов - присвоить none
        $searchKey = 'none';
        if (!empty($searchInput) && strlen($searchInput) >= 3) {
            $searchKey = $searchInput;
        }

        return sprintf(
            'products:%s:%s:%s:%s:%d',
            $subcategoryId ?? 'all',
            $searchKey,
            $sortField ?? 'id',
            $sortDirection ?? 'asc',
            $page ?? '1'
        );
    }

    /**
     * Получить продукты с кэшем
     * 
     * @param int|null $subcategoryId
     * @param string|null $searchInput
     * @param string $sortField
     * @param string $sortDirection
     * @param int $page
     * @param int $perPage
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function getProducts(?int $subcategoryId, ?string $searchInput, string $sortField, string $sortDirection, int $page, int $perPage = 16) : \Illuminate\Pagination\LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey($subcategoryId, $searchInput, $sortField, $sortDirection, $page);

        $products = Cache::tags("products")->remember($cacheKey, 3600, function () use ($subcategoryId, $searchInput, $sortField, $sortDirection, $perPage){
            $query = Product::query();

            if ($subcategoryId) {
                $query->whereHas('subcategories', function ($q) use ($subcategoryId) {
                    $q->where('subcategories.id', $subcategoryId);
                });
            }

            if (strlen($searchInput) >= 3) {
                $query->where('name', 'like', '%'. $searchInput . '%');
            }

            return $query->orderBy($sortField, $sortDirection)->paginate($perPage);
        });

        return $products;
    }

    /**
     * Очистить весь кэш под тегом products
     * 
     * @return void
     */
    function clearAll() : void
    {
        Cache::tags("products")->flush();
    }

}
