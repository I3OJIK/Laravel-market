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
     * @param int $ttl Время жизни кеша в секундах
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function getProducts(?int $subcategoryId = null, ?string $searchInput, string $sortField, string $sortDirection, int $page, int $perPage = 16, int $ttl = 3600) : \Illuminate\Pagination\LengthAwarePaginator
    {
        $cacheKey = $this->makeCacheKey($subcategoryId, $searchInput, $sortField, $sortDirection, $page);

        $products = Cache::tags("products")->remember($cacheKey, $ttl, function () use ($subcategoryId, $searchInput, $sortField, $sortDirection, $perPage){
            $query = Product::query();

            if ($subcategoryId) {
                $query->whereHas('subcategories', function ($q) use ($subcategoryId) {
                    $q->where('subcategories.id', $subcategoryId);
                });
            }

            if (strlen($searchInput) >= 3) {
                $query->where('name', 'like', '%'. $searchInput . '%');
            }

            return $query->with(['category', 'subcategories', 'colors'])->orderBy($sortField, $sortDirection)->paginate($perPage);
        });

        return $products;
    }

    /**
     * Получить один продукт с кэшем
     *
     * @param int $id
     * @param int $ttl Время жизни кеша в секундах
     * @return Product|null
     */
    public function getProduct(int $id, int $ttl = 1800): ?Product
    {
        $cacheKey = "product:{$id}";

        return Cache::tags("product")->remember($cacheKey, $ttl, function () use ($id) {
            return Product::with(['subcategories','colors','category'])->find($id);
        });
    }

    /**
     * Очистить кэш одного продукта
     * 
     * @return void
     */
    private function clearProduct(int $id) : void
    {
        Cache::tags('product')->forget("product:{$id}");
    }


    /**
     * Очистить весь кэш под тегом products
     * 
     * @return void
     */
    private function clearAll() : void
    {
        Cache::tags("products")->flush();
    }

    /**
     * Очистить кеш продуктов (Списков и если есть id единичные продукты)
     * 
     * @param int|null $productId
     * 
     * @return void
     */
    public function clearCache(?int $productId = null): void
    {
        if ($productId) {
            $this->clearProduct($productId); // отдельный продукт
        }
        $this->clearAll(); // списки
    }

}
