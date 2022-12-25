<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CentersResource;
use Carbon\Carbon;

class ReservationsResource extends JsonResource
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
            'id'              => $this->id,
            'check_date'      => $this->check_date,
            'check_day'       => Carbon::parse($this->check_date)->dayName,
            'payment_type'    => $this->payment_type,
            'payment_status'  => $this->payment_status,
            'qr_code'         => $this->qr_code,
            'from'            => $this->from,
            'to'              => $this->to,
            'customer'        => $this->relationLoaded('user') ? new AuthUserResource($this->user):null,
            'center'          => $this->relationLoaded('center') ? new CentersResource($this->center):null,
            'status'          => $this->relationLoaded('history') ? $this->history->last() !== null ? Reservation::getStatusText($this->history->last()->status):'' :null,
            'nabadat_history' => $this->relationLoaded('nabadatHistory') ? NabadatHistoryResource::collection($this->nabadatHistory):null,
        ];
    }
}
