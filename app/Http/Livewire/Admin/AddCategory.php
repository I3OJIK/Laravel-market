<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

/**
 * Создание новой категории/подкатегории
 * 
 * 
 * @property App\Models\Category $categories 
 * @property string $optionAdd переменная для селектора выбора доабвления (добалвение категории или подкатегории)
 * @property int|null $selectedCategoryId Если добавление подкатегории то хранит Id связанной категории
 * @property string|null $subcategoryDescription Описание подкатегории
 * @property string|null $name Имя категории/подкатегории
 */
class AddCategory extends Component
{   
    public $categories;
    public string $optionAdd = 'sub'; //переменная для селектора выбора доабвления - категория или подкатегория
    public ?int $selectedCategoryId = null; // если выбрано добавление подкатегории сохраняет выбранную категорию к которой приклепляется
    public ?string $subcategoryDescription; //описание для покдкатегории
    public ?string $name; //имя новой категори/подкатегории

    /**
     * Создание новой подкатегории/ категории
     * 
     * @return void
     */
    public function create(): void
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
