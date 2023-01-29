<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Resources\ReservationsResource;
use App\Services\ReservationService;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private ReservationService $reservationService)
    {

    }

    // listing all reservations for logged in center
    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            if (auth('sanctum')->user()->center_id == null)
                throw new NotFoundException('route not found');
            $withRelations = ['history', 'nabadatHistory', 'user', 'center'];
            $reservations = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            return apiResponse(data: ReservationsResource::collection($reservations));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function patientReservations(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            $filters['user_id'] = auth('sanctum')->id();
            $withRelations = ['history', 'nabadatHistory', 'user', 'center'];
            $reservations = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            return apiResponse(data: ReservationsResource::collection($reservations));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    /////////////////////////

    /**
     * @param ReservationStoreRequest $reservationStoreRequest
     * @return ReservationsResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $reservationStoreRequest): \Illuminate\Http\Response|ReservationsResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $reservation = $this->reservationService->store($reservationStoreRequest->validated());
            return apiResponse(data: new ReservationsResource($reservation));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function find(string $id)
    {
        try {
            $withRelations = ['history', 'nabadatHistory', 'user', 'center'];
            $reservation = $this->reservationService->findByQr($id, $withRelations);
            if ($reservation)
                return apiResponse(new ReservationsResource($reservation), trans('lang.operation_success'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

}
