<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Компонент Livewire для добавления нового товара в админке.
 *
 * Позволяет выбрать категорию, подкатегории, цвета, указать остаток и загрузить изображение.
 * 
 * @property string|null $name Название товара 
 * @property string|null $description Описание товара 
 * @property int|null $price Цена товара 
 * @property int|null $categoryId Id категории товара 
 * @property array $subcategoryIds Массив ID выбранных подкатегорий 
 * @property Collection|null $subcategories Подкатегории, относящиеся к выбранной категории
 * @property array $colorStocks Массив вида [color_id => stock]
 * @property Collection $allCategories Все категории
 * @property Collection $allSubcategories Все подкатегории
 * @property Collection $allColors Все цвета
 * @property UploadedFile|null $image Загруженное изображение
 * @property Product $product  Созданный товар после сохранения
 */
class AddProduct extends Component
{
    use WithFileUploads;

    public ?string $name = null;
    public ?string $description = null;
    public ?int $price = null;
    public ?int $categoryId = null;
    public array $subcategoryIds = [];
    public $subcategories;
    public array $colorStocks = []; // [color_id => stock]

    public $allCategories;
    public $allSubcategories;
    public $allColors;
    public $image;
    public $product;


    /**
     * Инициализация компонента.
     *
     * Загружает все категории, подкатегории и цвета.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->allCategories = Category::all();
        $this->allSubcategories = Subcategory::all();
        $this->allColors = Color::all();
        $this->updatedCategoryId();
    }
    
    /**
     * Обновляет список подкатегорий при изменении категории.
     *
     * @return void
     */
    public function updatedCategoryId(): void
    {
        $this->subcategories =$this->allSubcategories->where('category_id',$this->categoryId );
        $this->subcategoryIds =[];
    }

    /**
     * Создает товар и сохраняет изображение, связи с подкатегориями и цветами.
     *
     * @return void
     */
    public function create(): void
    {
        // Сохраняем в storage/app/public/images
        if ($this->image){
            $imagePath = $this->image->store('images', 'public');
        }
        else {
            session()->flash('error', 'Добавьте фото');
            return;
        }

        // Создаём товар
        $this->product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $imagePath,
            'category_id' => $this->categoryId,
        ]);
        
        $this->product->subcategories()->sync($this->subcategoryIds); //sync удаляет все кроме того что есть в массиве и добавит новые
        
        foreach ($this->colorStocks as $colorId => $stock) {
            $this->product->colors()->attach([
                $colorId => ['stock' => $stock]
            ]);
        }
        $this->reset(['name', 'description', 'price', 'categoryId', 'subcategoryIds', 'colorStocks', 'image', 'product']);
        session()->flash('success', 'Товар успешно добавлен!');

    }
    public function render()
    {
        return view('livewire.admin.add-product');
    }
}

