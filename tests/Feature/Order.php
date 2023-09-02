<?php

namespace Tests\Feature;

use App\Services\MySweetAbility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Order extends TestCase
{
    use withFaker;
    /**
     * Store test for order.
     * @return void
     */
    public function test_success_store()
    {
        $products = \App\Models\Product::all("id")->random(2);
        $content = array();
        foreach ($products as $product) {
            $content[] = [
                "product_id" => $product->id,
                "quantity" => 1
            ];
        }
        $response = $this->post('api/order',
            [
                "products_quantity" => $content,
            ], [
                "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2OTM2MzUzMTksImV4cCI6MTY5MzcyMTcxOSwibmJmIjoxNjkzNjM1MzE5LCJqdGkiOiJtaXBmemNocGlUcHdqWkVaIiwic3ViIjoiNjRlZWZjMGMyMmM2MzU4NmZjMDZiMjgyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.oeDyZhvxQCzwRmILmjckJwTjJSFE2jvZ8s9w5w9f9sQ"

            ]);
        $response->assertStatus(201);
    }

    /**
     * Test invalid authentication
     * @return void
     */
    public function test_store_invalid_authentication()
    {
        $products = \App\Models\Product::all("id")->random(2);
        $content = array();
        foreach ($products as $product) {
            $content[] = [
                "product_id" => $product->id,
                "quantity" => 1
            ];
        }
        $response = $this->post('api/order',
            [
                "products_quantity" => $content,
            ], [
                "Authorization" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2OTM1NDM5MzQsImV4cCI6MTY5MzYzMDMzNCwibmJmIjoxNjkzNTQzOTM0LCJqdGkiOiJIQ2VaRWp2SG1rMDd3QjBFIiwic3ViIjoiNjRlZWZjMGMyMmM2MzU4NmZjMDZiMjgyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.RnZdhVUNEaIUehpNOSp08hijrVPfVXQwEmP3leRLYbA"

            ]);
        $response->assertStatus(401);
    }

    /**
     * IS used for invalid name for create a order
     * @return void
     */
    public function test_store_invalid_params(){
        $ids = [
            ["quantity" => 222, "product_id" => "33"],
        ];
        $response = $this->post('api/order',
            [
                "products_quantity" => $ids,
            ], [
                "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2OTM2MzUzMTksImV4cCI6MTY5MzcyMTcxOSwibmJmIjoxNjkzNjM1MzE5LCJqdGkiOiJtaXBmemNocGlUcHdqWkVaIiwic3ViIjoiNjRlZWZjMGMyMmM2MzU4NmZjMDZiMjgyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.oeDyZhvxQCzwRmILmjckJwTjJSFE2jvZ8s9w5w9f9sQ"
            ]);
        $response->assertJsonStructure([
            "errors" =>[
                "products_quantity"
                ]

        ]);
        $response->assertStatus(400);
    }

    /**
     * Get a order by id.
     * @return void
     */
    public function test_get_by_id(){
        $order = \App\Models\Order::all()->first();
        $response = $this->get("api/order/" . $order->id);
        $response->assertJsonStructure([
            "products",
            "count",
            "total_price",
            "user"
        ]);
    }

    /**
     * Update test for order.
     * @return void
     */
    public function test_update(){
        $products = \App\Models\Product::all("id")->random(2);
        $content = array();
        foreach ($products as $product) {
            $content[] = [
                "product_id" => $product->id,
                "quantity" => 1
            ];
        }

        $order = \App\Models\Order::all()->first();
        $result = MySweetAbility::productCalculator(array("products_quantity" => $content));
        $response = $this->put('api/order/' . $order->id,
            [
                "products_quantity" => $content,
            ], [
                "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2OTM2MzUzMTksImV4cCI6MTY5MzcyMTcxOSwibmJmIjoxNjkzNjM1MzE5LCJqdGkiOiJtaXBmemNocGlUcHdqWkVaIiwic3ViIjoiNjRlZWZjMGMyMmM2MzU4NmZjMDZiMjgyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.oeDyZhvxQCzwRmILmjckJwTjJSFE2jvZ8s9w5w9f9sQ"

            ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "products",
            "count",
            "total_price",
            "user"
        ]);
        $updatedOrder = json_decode($response->content());
        self::assertTrue($updatedOrder->total_price == $result['totalPrice']);
        self::assertTrue($updatedOrder->count == $result['sumOfProducts']);
        $response->assertStatus(200);
    }

    /**
     * Unknown entity on update test.
     * @return void
     */
    public function test_invalid_update(){
        $response = $this->put("api/order/21");
        $response->assertStatus(404);
        $response->assertJsonStructure([
            "errors"
        ]);
    }

    /**
     * Invalid params for update order test.
     * @return void
     */
    public function test_update_invalid_params(){
        $ids = [
            ["quantity" => 222, "product_id" => "33"],
        ];
        $response = $this->put('api/order',
            [
                "products_quantity" => $ids,
            ], [
                "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2OTM1NDM5MzQsImV4cCI6MTY5MzYzMDMzNCwibmJmIjoxNjkzNTQzOTM0LCJqdGkiOiJIQ2VaRWp2SG1rMDd3QjBFIiwic3ViIjoiNjRlZWZjMGMyMmM2MzU4NmZjMDZiMjgyIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.RnZdhVUNEaIUehpNOSp08hijrVPfVXQwEmP3leRLYbA"
            ]);
        $response->assertStatus(400);

        $response->assertJsonStructure([
            "errors" => [
                "products_quantity",
            ]
        ]);
    }
    /**
     * Delete test for order
     * @return void
     */
    public function test_delete(){
        $order = \App\Models\Order::all()->first();
        $response = $this->delete("api/order/" . $order->id);
        $response->assertStatus(200);
    }

    /**
     * Invalid delete test for order
     * @return void
     */
    public function test_invalid_delete(){
        $response = $this->delete("api/order/21");
        $response->assertStatus(404);
        $response->assertJsonStructure([
            "errors"
        ]);
    }
}
