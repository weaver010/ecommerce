<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($country){
        $shippingDetails = ShippingCharge::where('country',$country)->first()->toArray();
        $shipping_charges = $shippingDetails['rate'];
        return $shipping_charges;
    }
}
