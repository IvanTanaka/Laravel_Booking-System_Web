<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = new \App\Models\Admin();
        $admin->name = "Admin";
        $admin->email = "admin@membee.com";
        $admin->password = Hash::make("admin");
        $admin->save();
    }
}
