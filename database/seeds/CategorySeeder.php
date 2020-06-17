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
        $fast_food->name = "Fast Food";
        $fast_food->slug = FoodCategory::FAST_FOOD;
        $fast_food->save();

        $sea_food = new \App\Models\Category();
        $sea_food->name = "Sea Food";
        $sea_food->slug = FoodCategory::SEA_FOOD;
        $sea_food->save();

        $salad = new \App\Models\Category();
        $salad->name = "Salad";
        $salad->slug = FoodCategory::SALAD;
        $salad->save();
        
        $drinks = new \App\Models\Category();
        $drinks->name = "Drinks";
        $drinks->slug = FoodCategory::DRINKS;
        $drinks->save();
    }
}
