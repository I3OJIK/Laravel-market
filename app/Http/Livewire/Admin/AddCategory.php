<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

class AddCategory extends Component
{   
    public $categories;
    public $optionAdd = 'sub'; //переменная для селектора выбора доабвления - категория или подкатегория
    public $selectedCategoryId; // если выбрано добавление подкатегории сохраняет выбранную категорию к которой приклепляется
    public $subcategoryDescription; //описание для покдкатегории
    public $name; //имя новой категори/подкатегории

    public function create()
    {
        if ($this->optionAdd == 'sub'){
            $subcategory = Subcategory::create([
                'name' => $this->name,
                'description' => $this->subcategoryDescription,
                'category_id' => $this->selectedCategoryId,
            ]);
        }
        else if ($this->optionAdd == 'cat'){
            $category = Category::create([
                'name' => $this->name,
            ]);
            
        }
    }

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.admin.add-category');
    }
}
