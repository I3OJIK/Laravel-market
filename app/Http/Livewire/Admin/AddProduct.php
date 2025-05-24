<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProduct extends Component
{
    use WithFileUploads;

    public $name, $description, $price;
    public $categoryId ;
    public $subcategoryIds = [];
    public $subcategories;
    public $colorStocks = []; // [color_id => stock]

    public $allCategories;
    public $allSubcategories;
    public $allColors;
    public $image;
    public $product;

    public function mount()
    {
        $this->allCategories = Category::all();
        $this->allSubcategories = Subcategory::all();
        $this->allColors = Color::all();
        $this->updatedCategoryId();
    }
    //при выборе категории подгружает ее подкатегории
    public function updatedCategoryId()
    {
        $this->subcategories =$this->allSubcategories->where('category_id',$this->categoryId );
        $this->subcategoryIds =[];
    }

    public function create()
    {
        // Сохраняем в storage/app/public/images
        $imagePath = $this->image->store('images', 'public');

        // Создаём товар
        $this->product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image_url' => $imagePath,
        ]);
        
        $this->product->subcategories()->sync($this->subcategoryIds); //sync удаляет все кроме того что есть в массиве и добавит новые
        
        foreach ($this->colorStocks as $colorId => $stock) {
            $this->product->colors()->attach([
                $colorId => ['stock' => $stock]
            ]);
        }
    }
    public function render()
    {
        return view('livewire.admin.add-product');
    }
}

