<?php

namespace App\Http\Controllers;

use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusChangeRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(OrdersDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_order');
        try {
            $loadRelation = ['latestStatus','user:id,name,phone'];
            $filters = array_filter($request->get('filters', []), function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $filters['is_order'] = 1;
            return $dataTable->with(['filters' => $filters, 'withRelations' => $loadRelation])->render('dashboard.orders.index');
        } catch (\Exception $exception) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $exception->getMessage()];
            return back()->with('toast', $toast);
        }
    } //end of index

    public function updateOrderStatus(OrderStatusChangeRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $data=$request->validated();
            $this->orderService->updateOrderStatus($data);
           return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
           return apiResponse(message: $exception->getMessage(),code: 422);
        }
    } //end of update order Status

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_order');
        $loadRelation = ['user:id,name,phone' , 'items','latestStatus'];
        $order = $this->orderService->find($id,$loadRelation);
        if (!$order) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.order_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.orders.show', compact('order'));
    } //end of show

    public function paymentStatus(Request $request)
    {
        try {
            //first forget cash
            $result = $this->orderService->paymentStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
