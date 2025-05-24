<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;

class Orders extends Component
{
    public $orders; //все заказы данного пользовталея
    public $showModal = false; //для модального окна
    public $selectedOrderIdDelete; //для модального окна
    public $activeFilter = 'all'; // По умолчанию активна вкладка "All Order"


    public function mount()
    {
        $this->orders = auth()->user()->orders; //все заказы пользователя с данным id
        
    }

    // фильтрация заказов
    public function filterOrders($status)
    {
         $this->activeFilter = $status; // для подсвечивания выбранного статуса на странице
        // $this->orders = auth()->user()->orders
        //     ->filter(function($order) use ($status){
        //         return $status == 'all' || $order->status === $status; // если  status = all выводит все
        //     });
        
        $id =  auth()->user()->id;
        $user =  User::find($id);
        $query = $user->orders(); 
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        $this->orders = $query->get();
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
