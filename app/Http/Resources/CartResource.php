<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'items_count' => (double)$this->items_count,
            'saved' => $this->when($this->saved_amount > 0, $this->saved_amount, 0),
            'discount' => $this->when((double)$this->discount > 0, (double)$this->discount),
            'sub_total' => (double)$this->sub_total,
            'net_total' => (double)$this->net_total, //before add shipping cost and decrease discount percentage
            'grand_total' => (double)$this->grand_total,
            'address_id' => $this->address_id,
            'tax' => (double)$this->tax,
            'shipping_cost' => (double)$this->shipping_cost,
            'pounds_for_points'=>(double) changePointsToPounds((float)$this->user?->points),
            'items' => CartItemsResource::collection($this->whenLoaded('items')),
        ];
    }
}
