<?php

use Illuminate\Database\Seeder;
use function App\Helpers\generateUuid;
use function App\Helpers\random_str;

class CashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\Customer;
        $user->name = "Ivan Tanaka";
        $user->phone_number = "082272675309";
        $user->email = "tanakaivann97@gmail.com";
        $user->password = bcrypt("123123");
        $user->api_token = random_str(100);

        $user->save();
    }
}
