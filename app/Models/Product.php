<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["name", "price", "inventory"];
    public function orders(){
        return $this->belongsToMany(Order::class, "order_product");
    }
}
