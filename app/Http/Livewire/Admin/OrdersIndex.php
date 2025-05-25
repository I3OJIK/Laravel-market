<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class OrdersIndex extends Component
{
    public $orders;
    public $activeFilter = 'all'; // По умолчанию активна вкладка "All Order"
    public $editingOrderId;
    public $newStatus;
    public $searchInput;

    // // фильтрация заказов
    // public function filterOrders($status)
    // {
    //     $this->activeFilter = $status; // для подсвечивания выбранного статуса на странице
    //     $query = Order::query(); 
    //     if ($status !== 'all') {
    //         $query->where('status', $status);
    //     }
    //     $this->orders = $query->get();
    // }

    // при наждатии кнопки edit запоминает айдишник
    public function editOrderStatus($id)
    {
        $this->editingOrderId = $id;
    }

    // изменение статуса заказа
    public function updatedNewStatus()
    {
        $order = Order::findOrFail($this->editingOrderId);
        if($order){
            $order->status = $this->newStatus;
            $order->save();
            $this->editingOrderId = null;
        }
    }

    public function render()
    {
        $query = Order::query();
        // фильтр по статусу
        if ($this->activeFilter !== 'all') {
            $query->where('status', $this->activeFilter);
        }
        // фильтр по поиску

        if ($this->searchInput) {
            $query->where('id', 'like', $this->searchInput . '%');
         } 

        $this->orders = $query->get();
        
        return view('livewire.admin.orders-index');
    }
}
