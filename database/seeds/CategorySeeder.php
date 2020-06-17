<?php

use Illuminate\Database\Seeder;
use App\Enums\FoodCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $fast_food = new \App\Models\Category();
        $fast_food->name = FoodCategory::FAST_FOOD;
        $fast_food->save();

        $sea_food = new \App\Models\Category();
        $sea_food->name = FoodCategory::SEA_FOOD;
        $sea_food->save();

        $salad = new \App\Models\Category();
        $salad->name = FoodCategory::SALAD;
        $salad->save();
        
        $drinks = new \App\Models\Category();
        $drinks->name = FoodCategory::DRINKS;
        $drinks->save();
    }
}
