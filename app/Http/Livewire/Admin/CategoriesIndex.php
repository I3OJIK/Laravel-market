<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Route;
use Livewire\Component;

class CategoriesIndex extends Component
{
    public $categories;

    // редактирование подкатегории
    public $editingSubcategoryId = null;
    public $editedSubcategoryName = '';
    public $editedSubcategoryDescription = '';


    

    public function deleteSubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        if($subcategory){
            $subcategory->products()->detach(); //удаляем из пивот таблицы продукты сабкатегории все записи с данной подкатегорией
            $subcategory->delete();
        }
    }

    public function editSubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $this->editingSubcategoryId = $id;
        $this->editedSubcategoryName = $subcategory->name;
        $this->editedSubcategoryDescription = $subcategory->description;
    }

    public function saveSubcategory()
    {
        $editedSubcategory = Subcategory::findOrFail($this->editingSubcategoryId);
        $editedSubcategory->name = $this->editedSubcategoryName;
        $editedSubcategory->description = $this->editedSubcategoryDescription;
        $editedSubcategory->save();

        $this->editingSubcategoryId = null;

    }

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.admin.categories-index');
    }
}
