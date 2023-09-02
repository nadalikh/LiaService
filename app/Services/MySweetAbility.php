<?php

namespace App\Services;

use App\Models\Product;

class MySweetAbility
{
    static function missingResponse(){
        return response()->json(["errors" => [\App\Consts\Response::ENTITY_NOT_FOUND]], 404);
    }
    static function productCalculator($body){
        $products = array();
        $sumOfProducts = 0;
        $totalPrice = 0;
        foreach ($body['products_quantity'] as $product_quantity) {
            $product = Product::find($product_quantity['product_id']);
            $products[] = $product;
            $sumOfProducts += $product_quantity['quantity'];
            $totalPrice += ($product->price * $product_quantity['quantity']);
            $product->inventory -= $product_quantity['quantity'];
            $product->save();
        }
        return [
            "products" => $products,
            "totalPrice" => $totalPrice,
            "sumOfProducts" => $sumOfProducts
        ];
    }

}
