<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{
    public $orders; //все заказы данного пользовталея
    public $showModal = false; //для модального окна
    public $selectedOrderIdDelete; //для модального окна



    public function mount()
    {
        $this->orders = auth()->user()->orders; //все заказы пользователя с данным id

    }

    // Загружаем заказы пользователя
    public function loadOrders()
    {
        $this->orders = auth()->user()->orders;
    }

    //выщзывается при нажатии удалить заказ, для сохранения айди и открытия модального окна
    public function preventDelete($id)
    {
        $this->selectedOrderIdDelete = $id;
        $this->showModal = true;
    }

    public function deleteOrder()
    {
        $order = Order::find($this->selectedOrderIdDelete);
        if ($order) {
            $order->delete();
            $this->showModal = false;
            $this->loadOrders(); // Обновляем список заказов
        }
    }
    public function render()
    {
        return view('livewire.orders');
    }
}
