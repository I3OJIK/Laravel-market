<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;

class ProductsIndex extends Component
{
    public $productId;
    public $product;
    public $input = 'dsf';
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


    public $searchInput;

    public function mount()
    {
        $this->allCategories = Category::all();
        $this->allSubcategories = Subcategory::all();
        $this->allColors = Color::all();
    }
    
    public function editingProduct($id)
    {
        if ($id) {

            $this->product = Product::with(['subcategories','colors'])->findOrFail($id);
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->categoryId = $this->product->subcategories->first()->category->id;
            // dd($this->product->subcategories->first()->category->id);
            $this->updatedCategoryId();
            $this->subcategoryIds = $this->product->subcategories->pluck('id')->toArray();
            foreach ($this->product->colors as $color) {
                $this->colorStocks[$color->id] = $color->pivot->stock;
            }
            $this->showModal= true;
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->subcategories()->detach(); 
            $product->colors()->detach();        
            $product->delete();                  
        }
    }
    public function update()
    {
        // dd($this->subcategoryIds);
        $this->product->name = $this->name;
        $this->product->description = $this->description;
        $this->product->price = $this->price;
        $this->product->save();
        
        $this->product->subcategories()->sync($this->subcategoryIds); //sync удаляет все кроме того что есть в массиве и добавит новые
        foreach ($this->colorStocks as $colorId => $stock) {
            $this->product->colors()->syncWithoutDetaching([
                $colorId => ['stock' => $stock]
            ]);
        }
        $this->showModal= false;
    }
    public function updatedCategoryId()
    {
        $this->subcategories =$this->allSubcategories->where('category_id',$this->categoryId );
        $this->subcategoryIds =[];
    }
    public function render()
    {
        // осуществление поиска
        $query = Product::query();

        if (strlen($this->searchInput) >= 3) {
            $query->where('name', 'like', $this->searchInput . '%');
        }

        return view('livewire.admin.products-index', [
            'products' => $query->get()
        ]);
    }
}
