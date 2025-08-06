<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
                'id' => $this->id,
                'quantity' => $this->quantity,
                'color_product_id'=>$this->colorProduct->id,
                'product' => [
                    'id' => $this->product->id,
                    'name' => $this->product->name,
                    'description' => $this->product->description,
                    'price' => $this->product->price,
                    'image_url' => $this->product->image_url
                ],
                'color' => [
                    'id' => $this->colorProduct->color->id,
                    'name' => $this->colorProduct->color->name,
                ],
                'created_at' => $this->created_at
            ];
    }
}
