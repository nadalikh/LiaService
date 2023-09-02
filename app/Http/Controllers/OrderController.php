<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stores\StoreOrder;
use App\Http\Requests\Updates\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\MySweetAbility;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrder $request)
    {
        $user = auth()->user();
        $body = $request->only('products_quantity');
        $productCal = MySweetAbility::productCalculator($body);
        $order = new Order(
            [
                "count" => $productCal['sumOfProducts'],
                "total_price" => $productCal['totalPrice'],
            ]
        );
        $order->products()->saveMany($productCal['products']);
        $order->user()->associate($user)->save();
        $order->load( "user");
        return $this->respondCreated($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        $order->load("user", "products");
        return $this->respondWithSuccess($order);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $body = $request->only('products_quantity');
        $productCal = MySweetAbility::productCalculator($body);
        $order->products()->saveMany($productCal['products']);
        $order->count = $productCal['sumOfProducts'];
        $order->total_price = $productCal['totalPrice'];
        $order->save();
        return $this->respondWithSuccess($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return $this->respondWithSuccess($order);
    }
}
