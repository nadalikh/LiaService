<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Product extends TestCase
{
    use withFaker;
    /**
     * Store test for product.
     *
     * @return void
     */
    public function test_success_store()
    {
        $response = $this->post('api/product',
        [
            "name" => $this->faker->name,
            "inventory" => $this->faker->numberBetween(0,100),
            "price" => $this->faker->numberBetween(100, 9999999)
        ]);
        $response->assertStatus(201);
    }

    /**
     * IS used for invalid name for create a product
     * @return void
     */
    public function test_store_invalid_params(){
        $response = $this->post('api/product',
            [
                "name" => $this->faker->numberBetween(0,10),
                "inventory" => $this->faker->name(),
                "price" => $this->faker->name()
            ]);
        $response->assertJsonStructure([
            "errors" => [
                "name",
                "inventory",
                "price"
            ]
        ]);
        $response->assertStatus(400);
    }

    /**
     * Delete test for product
     * @return void
     */
    public function test_delete(){
        $product = \App\Models\Product::all()->first();
        $response = $this->delete("api/product/" . $product->id);
        $response->assertStatus(200);
    }

    /**
     * Invalid delete test for product
     * @return void
     */
    public function test_invalid_delete(){
        $response = $this->delete("api/product/21");
        $response->assertStatus(404);
        $response->assertJsonStructure([
            "errors"
        ]);

    }

    /**
     * Update test for product.
     * @return void
     */
    public function test_update(){
        $product = \App\Models\Product::all()->first();
        $name = $this->faker->name;
        $inventory = $this->faker->numberBetween(0,100);
        $price = $this->faker->numberBetween(100, 9999999);

        $response = $this->put('api/product/' . $product->id,
        [
            "name" => $name,
            "inventory" => $inventory,
            "price" => $price
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "name",
            "inventory",
            "price"
        ]);
        $updatedProduct = json_decode($response->content());
        self::assertTrue($updatedProduct->name == $name);
        self::assertTrue($updatedProduct->inventory == $inventory);
        self::assertTrue($updatedProduct->price == $price);
    }

    /**
     * Unknown entity on update test.
     * @return void
     */
    public function test_invalid_update(){
        $response = $this->put("api/product/21");
        $response->assertStatus(404);
        $response->assertJsonStructure([
            "errors"
        ]);
    }

    /**
     * Invalid params for update product test.
     * @return void
     */
    public function test_update_invalid_params(){
        $response = $this->post('api/product',
            [
                "name" => $this->faker->numberBetween(0,10),
                "inventory" => $this->faker->name(),
                "price" => $this->faker->name()
            ]);
        $response->assertJsonStructure([
            "errors" => [
                "name",
                "inventory",
                "price"
            ]
        ]);
        $response->assertStatus(400);
    }
}
