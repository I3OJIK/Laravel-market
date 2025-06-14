<?php

namespace App\Http\Livewire\Rules;

class CartValidationRules
{
    public static function address(): array
    {
        return [
            'addressData.apartment_number' => 'required|string|min:3',
            'addressData.doorphone'        => 'required|min:1',
            'addressData.entrance'         => 'required|min:1',
            'addressData.floor'            => 'required|min:1',
            'addressData.phone'            => 'required|min:5',
            'addressData.address_text'     => 'required|string|min:5',
        ];
    }

    public static function cart(): array
    {
        return [
            'selectedCartItems' => 'required|array|min:1',
            'totalPrice'        => 'required|numeric|min:1',
        ];
    }
}