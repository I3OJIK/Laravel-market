<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product'  => $this->product->name,    
            'color'    => $this->color->name,      
            'quantity' => $this->quantity,
            'price'    => $this->price,
        ];
    }
}
