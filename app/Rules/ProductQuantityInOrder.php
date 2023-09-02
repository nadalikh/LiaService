<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class ProductQuantityInOrder implements Rule
{
    private $productName;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $product_quantity) {
            try {
                $product = Product::findOrFail($product_quantity['product_id']);
            }catch(\Exception $exception){
                return false;
            }
            if ($product_quantity['quantity'] > $product->inventory) {
                $this->productName = $product->name;
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "the quantity of $this->productName is larger than it's inventory";
    }
}
