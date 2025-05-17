<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;

class HomeProductList extends Component
{
    use WithPagination;

    public $selectedSubcategory = null;
    public $searchInput = null;

    public $sortField = 'id'; // поле для сортировки
    public $sortDirection = 'asc';    // направление сортировки

    public function updatingSelectedSubcategory()
    {
        // Сброс пагинации при выборе подкатегории
        $this->resetPage();
    }
    
 

    public function selectSubcategory($id)
    {
        $this->selectedSubcategory = Subcategory::find($id);

    }

    public function loadProduct($id)
    {
        return redirect()->route('product.show', ['id' => $id]);
    }

        //сортировка, передаем имя столба по которому сотрируем и направление сортировки
        public function sortBy($field, $direction)
    {

            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            $this->sortField = $field;
            $this->sortDirection = $direction;
        

        $this->resetPage(); // сброс пагинации при смене сортировки
    }

    public function render()
    {
        $products = Product::query();
        
        //при выбре категории
        if ($this->selectedSubcategory) {
           $products = $this->selectedSubcategory->products();

        }
        // при осуществлении поиска
        // фильтрация по поисковому запросу
        if (strlen($this->searchInput) >= 3) {
            $products->where('name', 'like',  $this->searchInput . '%');
        }

        // Сортировка
        $products->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.home-product-list', [
            'products' => $products->paginate(16),
            'categories' => Category::with('subcategories')->get(),
            'subcategories' => $this->selectedSubcategory
        ]);
    }
}
