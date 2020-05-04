<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Topup;
use function App\Helpers\api_response;
use App\Enums\TopupStatus;

class WalletController extends Controller
{
    //
    public function index(Request $request){
        $token = $request->bearerToken();

        $wallet = Wallet::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->first();

        $topups = Topup::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->where('status',TopupStatus::PENDING)->get();

        foreach($topups as $topup){
            $curl = curl_init();
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/".$topup->id."/status",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    // Set here requred headers
                    "content-type:application/json",
                    "accept:application/json",
                    "authorization:Basic U0ItTWlkLXNlcnZlci1oSU1GWXBpZVFrS25tMnA0Nmh4enA1MDk6"
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                try{
                    $result = json_decode($response);
                    $topup = Topup::find($topup->id);
                    $topup->status = $result->transaction_status=='settlement'?TopupStatus::SUCCESS:($result->transaction_status=='pending'?TopupStatus::PENDING:TopupStatus::FAILED);
                    $topup->update();
                    if($topup->status == TopupStatus::SUCCESS){
                        $wallet->amount = $wallet->amount+$topup->amount;
                    }
                }catch(Exception $e){
                    return api_response(true, 500,$e->getMessage());
                }
            }
        }
        $wallet->update();
        

        $wallet = Wallet::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->first();
        
        
        return api_response(true, 200,"Success.",$wallet);

    }

}
