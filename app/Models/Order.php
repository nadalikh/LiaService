<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Order extends Model
{
    use HasFactory;

    /**
     * The fillable attributes.
     * @var string[]
     */
    protected $fillable = ["count", "total_price"];

    /**
     * THe relation between an order and it's products.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Jenssegers\Mongodb\Relations\BelongsToMany
     */
    public function products(){
        return $this->belongsToMany(Product::class, "product_ids");
    }

    /**
     * An order can belong to a user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
