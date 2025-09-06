<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\RedisCache\ProductCacheService;
use Livewire\Component;
use Livewire\WithPagination;


/**
 * Управление списком товаров в админке.
 *
 * @property int|null $productId ID выбранного продукта для редактирования
 * @property \App\Models\Product|null $product Загруженная модель продукта (для редактирования)
 * @property string|null $searchInput Поисковая строка
 * @property string $sortField Поле сортировки
 * @property string $sortDirection Направление сортировки ('asc'|'desc')
 * @property int|null $categoryId Выбранная категория
 * @property int[] $subcategoryIds Выбранные подкатегории (ids)
 * @property array<int,int> $colorStocks Массив вида [color_id => stock]
 * @property \Illuminate\Support\Collection|\App\Models\Category[] $allCategories Все категории
 * @property \Illuminate\Support\Collection|\App\Models\Subcategory[] $allSubcategories Все подкатегории
 * @property \Illuminate\Support\Collection|\App\Models\Color[] $allColors Все цвета
 * @property \App\Models\Subcategory|null $selectedSubcategory Выбранная подкатегория (если нужно)
 * @property bool $showModal Флаг открытия модалки редактирования
 * @property bool $showModalDelete Флаг открытия модалки удаления
 * @property string $name Название товара
 * @property string|null $description Описание товара
 * @property float|int $price Цена товара
 */
class ProductsIndex extends Component
{
    use WithPagination;
    
    public $productId;
    public $product;
    public $categories;
    public bool $showModal = false;
    public bool $showModalDelete = false;

    public $name, $description, $price;
    public $categoryId ;
    public $subcategoryIds = [];
    public $subcategories;
    public $colorStocks = []; // [color_id => stock]

    public $allCategories;
    public $allSubcategories;
    public $allColors;

    public $searchInput = null;
    public string $sortField = 'id'; // поле для сортировки
    public string $sortDirection = 'asc';    // направление сортировки
    public $selectedSubcategory = null;

    protected ProductCacheService $cacheService;

    public function boot(ProductCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function mount(): void
    {
        $this->allCategories = Category::all();
        $this->allSubcategories = Subcategory::all();
        $this->allColors = Color::all();
    }
    
    /**
    * Подготовка данных и открытие модалки редактирования.
    *
    * @param  int  $id
    * @return void
    */
    public function editingProduct($id): void
    {
        if ($id) {
            $this->product = $this->cacheService->getProduct($id);
            $this->productId = $this->product->id;
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->categoryId = $this->product->category->id;
            
            $this->subcategoryIds = $this->product->subcategories->pluck('id')->toArray();
            $this->subcategories = $this->product->category->subcategories;
            foreach ($this->product->colors as $color) {
                $this->colorStocks[$color->id] = $color->pivot->stock;
            }
            $this->showModal= true;
        }
    }
    

    /**
     * Удаление товара.
     *
     * @param  int  $id
     * @return void
     */
    public function deleteProduct($id): void
    {
        $product = Product::find($id);

        if ($product) {
            $product->subcategories()->detach(); 
            $product->colors()->detach();        
            $product->delete();                  
        }
    }

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
     * Обновление продукта 
     *
     * @return void
     */
    public function update(): void
    {
        $product = Product::findOrFail($this->productId);

        $product->update([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
        ]);
    
        $product->subcategories()->sync($this->subcategoryIds);
    
        $syncData = [];
        foreach ($this->colorStocks as $colorId => $stock) {
            $stockNormalized = (int)$stock;
            if ($stockNormalized > 0) {
                $syncData[(int)$colorId] = ['stock' => $stockNormalized];
            }
        }
        // Если syncData пуст — отвязываем все цвета, иначе синхронизируем
        $this->product->colors()->sync($syncData);
        dd($this->product->colors);
        $this->colorStocks = [];
        $this->showModal= false;
    }
    
    public function render()
    {
        $products = $this->cacheService->getProducts(
            null,
            $this->searchInput,
            $this->sortField,
            $this->sortDirection,
            $this->page,
        );
        

        return view('livewire.admin.products-index', [
            'products' => $products
        ]);
    }
}
