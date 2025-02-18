<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                  =>$this->id,
            'center'              => $this->whenLoaded('center', new CentersResource($this->center)),
            'package'             => $this->whenLoaded('package', $this->package?->name),
            'num_nabadat'         => $this->num_nabadat,
            'price'               => $this->price,
            'discount_percentage' => $this->discount_percentage,
            'price_after_discount' =>$this->price - ($this->price *($this->discount_percentage/100)),
            'payment_method'      => $this->payment_method,
            'payment_status'      => $this->payment_status,
            'status'              => $this->getStatusAsString($this->status),
            'used'                => $this->used,
            'remain'              => $this->remain,
            'expire_date'         => $this->expire_date,
        ];
    }
}
