<?php

namespace App\Traits;

use App\Enum\PaymentMethodEnum;
use App\Exceptions\NotFoundException;
use App\Models\Order;
use App\Models\User;
use App\Services\AddressService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

trait OrderTrait
{

    /**
     * @throws NotFoundException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function storeOrder(Request $request, User $user)
    {
        //1- get cart data for user
        $orderData = app()->make(CartService::class)->getCart($request->temp_user_id);
        //2-get address info
        $userAddress = app()->make(AddressService::class)->find(id: $request->address_id, withRelations: ['city:id,title,shipping_cost', 'user:id,name,phone,email']);
        if (!$userAddress)
            throw new NotFoundException(trans('lang.address_not_found'));
//    check availability stocks of products
        foreach ($orderData->items as $item) {
            if ($item->quantity > $item->product->stock)
               throw new NotFoundException(trans('lang.quantity_is_more_stock :product', ['product' => $item->product->name]));
        }
        $payment_type = $request->payment_type == PaymentMethodEnum::CREDIT ?PaymentMethodEnum::CREDIT : PaymentMethodEnum::CASH;
        $deleted_at = $payment_type == PaymentMethodEnum::CREDIT ? true : null;
        $order = app()->make(OrderService::class)->store(user: $user, order_data: $orderData, shipping_address: $userAddress, payment_type: $payment_type, deleted_at: $deleted_at);
        return (object)[
            'order' => $order,
            'userAddress' => $userAddress,
            'code' => 200
        ];
    }

    public function setUserOfferAsOrder(User $user, array $order_data, array $items): \Illuminate\Database\Eloquent\Model
    {
        $order = $user->orders()->create($order_data);
        $order->items()->create($items);
        return $order->load('items');
    }

}
