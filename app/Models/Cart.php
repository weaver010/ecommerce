<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;
use Session;
use Auth;

class Cart extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id')->with('brand','images');
    }
}
