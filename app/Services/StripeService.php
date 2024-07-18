<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;

class StripeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createProductAndPrice($room)
    {
        $product = Product::create([
            'name' => $room->title,
            'description' => $room->description,
        ]);

        $price = Price::create([
            'product' => $product->id,
            'unit_amount' => $room->daily_rent * 100,
            'currency' => 'usd',
        ]);
        return ['product'=>$product,'price'=>$price];
    }
}
