<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\RedisCache\ProductCacheService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Компонент Livewire для отображения списка продуктов на главной странице.
 * 
 * Функции:
 * - Фильтрация по подкатегории
 * - Поиск по названию
 * - Сортировка по выбранному полю
 * - Постраничная навигация
 *
 * @property string|null $searchInput Поисковый запрос
 * @property string $sortField Поле сортировки (по умолчанию 'id')
 * @property string $sortDirection Направление сортировки (по умолчанию 'asc' )
 * @property \App\Models\Subcategory|null $selectedSubcategory  Выбранная подкатегория
 */

class ProductCatalog extends Component
{
    use WithPagination;

    public $searchInput = null;
    public string $sortField = 'id'; // поле для сортировки
    public string $sortDirection = 'asc';    // направление сортировки
    public $selectedSubcategory = null;

    protected ProductCacheService $cacheService;

    public function boot(ProductCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    
    /**
     * Сброс страницы при смене подкатегории
     * 
     * @return void
     */
    public function updatingSelectedSubcategory(): void
    {
        // Сброс пагинации при выборе подкатегории
        $this->resetPage();
    }
 


    /**
     *  Установка выбранной подкатегории по ID
     * 
     * @param int $id id покатегории
     * @return void
     */
    public function selectSubcategory(int $id): void
    {
        $this->selectedSubcategory = Subcategory::find($id);

    }

    /**
     * Переход на страницу выбранного продукта.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loadProduct(int $id)
    {
        return redirect()->route('product.show', ['id' => $id]);
    }

        //сортировка, передаем имя столба по которому сотрируем и направление сортировки

    /**
     * Сортировка
     * 
     * @param string $field поле для сортировки
     * @param string $direction направление сортировки
     * 
     * @return void
     */
    public function sortBy(string $field, string $direction): void
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
        $this->resetPage(); // сброс пагинации при смене сортировки
    }

    /**
     * Отображение компонента
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $products = $this->cacheService->getProducts(
            $this->selectedSubcategory->id ?? null,
            $this->searchInput,
            $this->sortField,
            $this->sortDirection,
            $this->page
        );
        // Категории
        $categories = Cache::remember('categories_with_subcategories', 3600, function () {
            return Category::with('subcategories')->get();
        });
        return view('livewire.product-catalog', [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $this->selectedSubcategory
        ]);
    }
}
