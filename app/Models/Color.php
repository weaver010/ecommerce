<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Model;

class Color extends Model
{
    use HasFactory;

    public static function colors(){
        $colors = Color::where('status',1)->get();
        return $colors;
    }
}
