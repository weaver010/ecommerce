<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Color;
        $product->color_name = 'Black';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Blue';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Brown';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Green';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Grey';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Multi';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Olive';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Orange';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Pink';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Purple';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Red';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'White';
        $product->status = 1;
        $product->save();

        $product = new Color;
        $product->color_name = 'Yellow';
        $product->status = 1;
        $product->save();
    }
}
