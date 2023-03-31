<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceResource;
use App\Http\Resources\ReservationsResource;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Services\InvoiceService;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Cache;

class CenterHomeController extends Controller
{
    public function __construct(protected ReservationService $reservationService, protected InvoiceService $invoiceService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data=[];
        $centerId = auth('sanctum')->user()->center_id;
        $upcoming_reservations = $this->reservationService->queryGet(where_condition: ['center_id' => $centerId, 'status_in' => [Reservation::PENDING,Reservation::APPROVED]], withRelation: ['user.attachments', 'latestStatus'])->orderBy('id')->limit(10)->get();
        $finance = $this->invoiceService->queryGet(filters: ['center_id' => $centerId, 'status' => Invoice::PENDING], withRelations: ['transactions'])->first();
        $done_appointments = $this->reservationService->queryGet(where_condition: ['center_id' => $centerId, 'status' => Reservation::COMPLETED], withRelation: ['user.attachments', 'latestStatus'])->orderBy('id')->limit(10)->get();
        $data ['upcoming_reservations'] = $upcoming_reservations ? ReservationsResource::collection($upcoming_reservations):null;
        $data ['finance'] = $finance ? new FinanceResource($finance):null;
        $data ['done_appointments'] = $done_appointments ? ReservationsResource::collection($done_appointments):null;

        //        return $data;
//
//        $data = Cache::remember('center-home-api', 60 * 60 * 24, function () use ($centerId) {
//            $data ['upcoming_reservations'] = ReservationsResource::collection($this->reservationService->queryGet(where_condition: ['center_id' => $centerId, 'status' => Reservation::PENDING], withRelation: ['user.attachments', 'latestStatus'])->orderByDesc('id')->limit(8)->get());
//            $data ['finance'] = new FinanceResource($this->invoiceService->queryGet(filters: ['center_id' => $centerId, 'status' => Invoice::PENDING], withRelations: ['transactions'])->first());
            // return $data;
//        });
        return apiResponse(data: $data);
    }
}
