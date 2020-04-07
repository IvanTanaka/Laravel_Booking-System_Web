<?php

use Illuminate\Database\Seeder;
use function App\Helpers\convertToTime;

class FranchiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $seed1 = new Seed();
        $seed1->user_name = "Ivan Tanaka";
        $seed1->user_email = "ivan@gmail.com";
        $seed1->user_phone_number = "082123450000";
        $seed1->franchise_name = "Benson Resto";
        $seed1->branch_address = "Jl. P. Pasar No. 141/149";
        $seed1->branch_phone_number = "082234560000";
        $seed1->branch_open_time = "06.00 AM";
        $seed1->branch_close_time = "11.00 PM";


        $seed2 = new Seed();
        $seed2->user_name = "Leonardy Khanady";
        $seed2->user_email = "leo98@gmail.com";
        $seed2->user_phone_number = "082123450001";
        $seed2->franchise_name = "Bakso Malang 98";
        $seed2->branch_address = "Jln. Krakatau No 89.";
        $seed2->branch_phone_number = "082234560001";
        $seed2->branch_open_time = "10.00 AM";
        $seed2->branch_close_time = "06.00 PM";


        $seed3 = new Seed();
        $seed3->user_name = "Meghan Robbie";
        $seed3->user_email = "meghan_robbie@gmail.com";
        $seed3->user_phone_number = "082123450002";
        $seed3->franchise_name = "Bakmi Kerang Cemara";
        $seed3->branch_address = "Jln. Cemara Asri, No 72.";
        $seed3->branch_phone_number = "082234560002";
        $seed3->branch_open_time = "09.00 AM";
        $seed3->branch_close_time = "08.00 PM";


        $seed4 = new Seed();
        $seed4->user_name = "Joko Lokasari";
        $seed4->user_email = "joko2323@gmail.com";
        $seed4->user_phone_number = "082123450003";
        $seed4->franchise_name = "Rumah Makan Joko";
        $seed4->branch_address = "Jln. Magellang, No 3.";
        $seed4->branch_phone_number = "082234560003";
        $seed4->branch_open_time = "11.30 AM";
        $seed4->branch_close_time = "10.00 PM";


        $seed5 = new Seed();
        $seed5->user_name = "M. Abdulah";
        $seed5->user_email = "abdul23@gmail.com";
        $seed5->user_phone_number = "082123450004";
        $seed5->franchise_name = "Nasi Sunda";
        $seed5->branch_address = "Jl Mojopahit No 2A";
        $seed5->branch_phone_number = "082234560004";
        $seed5->branch_open_time = "09.00 AM";
        $seed5->branch_close_time = "09.00 PM";


        $seed6 = new Seed();
        $seed6->user_name = "Tan Wei Teng";
        $seed6->user_email = "tanweitang63@gmail.com";
        $seed6->user_phone_number = "082123450005";
        $seed6->franchise_name = "Kwetiau Ateng";
        $seed6->branch_address = "Jln. S. Parman, No 73";
        $seed6->branch_phone_number = "082234560005";
        $seed6->branch_open_time = "05.30 PM";
        $seed6->branch_close_time = "08.00 PM";

        $data = array($seed1, $seed2, $seed3, $seed4, $seed5, $seed6);

        foreach($data as $seed){
            $user = new \App\Models\Owner();
            $user->name = $seed->user_name;
            $user->email = $seed->user_email;
            $user->phone_number = $seed->user_phone_number;
            $user->password = Hash::make("123123");
            $user->save();
        
            $franchise =  new \App\Models\Franchise();
            $franchise->id = uniqid();
            $franchise->owner_id = $user->id;
            $franchise->name = $seed->franchise_name;
            $franchise->type = "food";
            $franchise->save();
        
            $branch = new \App\Models\Branch();
            $branch->id = uniqid();
            $branch->franchise_id = $franchise->id;
            $branch->name = $franchise->name;
            $branch->address = $seed->branch_address;
            $branch->phone_number = $seed->branch_phone_number;
            $branch->open_time = convertToTime($seed->branch_open_time);
            $branch->close_time = convertToTime($seed->branch_close_time);
            $branch->save();
        }
        
    }
}

class Seed{
    public $user_name;
    public $user_email;
    public $user_phone_number;
    public $franchise_name;
    public $branch_address;
    public $branch_phone_number;
    public $branch_open_time;
    public $branch_close_time;
}
