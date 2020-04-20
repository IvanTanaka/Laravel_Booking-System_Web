<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed1 = new MenuSeed();
        $seed1->name = "Nasi Goreng Terasi";
        $seed1->description = "";
        $seed1->price = 23000;

        $seed2 = new MenuSeed();
        $seed2->name = "Nasi Goreng Seafood";
        $seed2->description = "";
        $seed2->price = 23000;
        
        $seed3 = new MenuSeed();
        $seed3->name = "Nasi Goreng Telur";
        $seed3->description = "";
        $seed3->price = 20000;

        $seed4 = new MenuSeed();
        $seed4->name = "Nasi Goreng Tom Yum";
        $seed4->description = "";
        $seed4->price = 25000;

        $seed5 = new MenuSeed();
        $seed5->name = "Indomie Becek";
        $seed5->description = "";
        $seed5->price = 16000;

        $seed6 = new MenuSeed();
        $seed6->name = "Indomie Goreng";
        $seed6->description = "";
        $seed6->price = 16000;

        $seed7 = new MenuSeed();
        $seed7->name = "Indomie Kuah";
        $seed7->description = "";
        $seed7->price = 16000;

        $seed8 = new MenuSeed();
        $seed8->name = "Ifumie Polos";
        $seed8->description = "";
        $seed8->price = 18000;

        $seed9 = new MenuSeed();
        $seed9->name = "Ifumie Seafood";
        $seed9->description = "";
        $seed9->price = 23000;

        $seed10 = new MenuSeed();
        $seed10->name = "Ifumie Tom Yum";
        $seed10->description = "";
        $seed10->price = 23000;

        $data = array($seed1, $seed2, $seed3, $seed4, $seed5, $seed6, $seed7, $seed8, $seed9, $seed10);
        
        foreach($data as $seed){
            $franchise =  \App\Models\Franchise::where('name', 'Benson Resto')->get();
            //
            $menu = new \App\Models\Menu;
            $menu->franchise_id = $franchise[0]->id;
            $menu->name = $seed->name;
            $menu->description = $seed->description;
            $menu->price = $seed->price;
            $menu->save();
        }
    }
}

class MenuSeed{
    public $name;
    public $description;
    public $price;
}
