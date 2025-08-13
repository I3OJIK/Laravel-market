<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;
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
    public $categories = null;
    public string $optionAdd = 'sub'; //переменная для селектора выбора доабвления - категория или подкатегория
    public ?int $selectedCategoryId = null; // если выбрано добавление подкатегории сохраняет выбранную категорию к которой приклепляется
    public ?string $subcategoryDescription = null; //описание для покдкатегории
    public ?string $name = null; //имя новой категори/подкатегории


    /**
     * Создание новой подкатегории/ категории
     * 
     * @return void
     */
    public function create(): void
    {
        try {
            DB::transaction(function () {
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
            });
            // Отправляем JS-событие
            $this->dispatchBrowserEvent('toast', [
                'type'    => 'success',
                'message' => 'Запись успешно добавлена!',
            ]);
            $this->reset(['name', 'subcategoryDescription', 'selectedCategoryId']);
        } catch(\Throwable $e) {
            $this->dispatchBrowserEvent('toast', [
                'type'    => 'error',
                'message' => 'Ошибка при добавлении. ' . $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.admin.add-category');
    }
}
