<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CreateProduct extends Controller
{
    public function create()
    {
        // Product::create([
        //     'name' => 'MOLKK',
        //     'price' => '2',
        //     'description' =>'FDSFDSFSD',
        //     'stock_quantity' => '23',
        // ]);
        // $product = Product::all();
        // dd($product);

        return view('livewire.create-product');
    }
}
