<?php

namespace App\Http\Controllers;

use App\Consts\Response;
use App\Http\Requests\Stores\StoreProductRequest;
use App\Http\Requests\Updates\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::paginate(10);
        return $this->respondWithSuccess($products);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Stores\StoreProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $body = $request->only('name', "inventory", "price");
        try {
            $product = Product::create($body);
            return $this->respondCreated($product);
        }catch (\Exception $e){
            return $this->respondError(Response::SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        $product->load("orders");
        return $this->respondWithSuccess($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updates\UpdateProductRequest $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $body = $request->only('name', "inventory", "price");
            $product->name = $body['name'] ?? $product->name;
            $product->inventory = $body['inventory'] ?? $product->inventory;
            $product->price = $body['price'] ?? $product->price;
        try{
            $product->save();
            return $this->respondWithSuccess($product);
        }catch (\Exception $e){
//            return $this->respondError(Response::SERVER_ERROR);
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return $this->respondOk(Response::SUCCESSFULLY_DELETED);
        }catch (\Exception $e){
            return $this->respondError(Response::SERVER_ERROR);
        }
    }
}
