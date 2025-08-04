<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Component;


/**
 * Компонент Livewire для отображения списка заказов.
 * 
 * Функции:
 * - Фильтрация по статусу
 * - Удаление заказа
 *
 * @property bool $showModal Видимость модального окна удаления заказа
 * @property int|null $selectedOrderIdDelete id выбранного для удаления товара
 * @property string $activeFilter фильтр заказов по статусу (например 'all', 'pending')
 */
class Orders extends Component
{
    public bool $showModal = false; //для модального окна
    public $selectedOrderIdDelete; //для модального окна
    public string $activeFilter = 'all'; // По умолчанию активна вкладка "All Order"


    /**
     * Получение заказов текущего пользователя с применением фильтра по статусу.
     * Это computed-свойство, вызывается при вызове к $this->orders
     * 
     * @return Collection
     */
    public function getOrdersProperty(): Collection
    {
        // все заказы пользователя
        $query = Order::where('user_id', auth()->id());

        // Если фильтр по статусу — добавляем условие
        if ($this->activeFilter !== 'all') {
            $query->where('status', $this->activeFilter);
        }
        // Возвращаем коллекцию
        return $query->get();
    }

    /**
     * Передает статус для фильтрации в свойство - activeFilter
     * 
     * @param string $status
     * 
     * @return void
     */
    public function filterOrders(string $status): void
    {
        $this->activeFilter = $status; 
    }

    /**
     * Подготавливает модальное окно для удаления заказа
     * Сохраняет ID выбранного заказа и открывает окно
     * 
     * @param int $id
     * 
     * @return void
     */
    public function preventDelete(int $id): void
    {
        $this->selectedOrderIdDelete = $id;
        $this->showModal = true;
    }

    /**
     * Удаление заказа
     * 
     * @return void
     */
    public function deleteOrder(): void
    {
        $order = Order::find($this->selectedOrderIdDelete);
        if ($order) {
            $order->delete();
            $this->showModal = false;
        }
    }
    public function render()
    {
        return view('livewire.orders',[
            'orders' => $this->orders
        ]);
    }
}
