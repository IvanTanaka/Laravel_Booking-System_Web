<?php

namespace App\Http\Controllers\APi\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topup;
use function App\Helpers\api_response;
use App\Models\Customer;
use App\Models\Wallet;
use App\Enums\TopupStatus;

class TopupController extends Controller
{
    //
    public function index(Request $request){
        $token = $request->bearerToken();
        $topup = Topup::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->orderBy('created_at','desc')->paginate(10);
        
        return api_response(true, 200,"Success.",$topup);
        
    }
    
    public function store(Request $request){
        $token = $request->bearerToken();
        $user = Customer::where('api_token', $token)->first();
        
        $topup = new Topup();
        $topup->customer_id = $user->id;
        $topup->amount = $request->amount;
        $topup->status = TopupStatus::PENDING;
        $topup->save();
        
        $data = [
            "payment_type"=> "bank_transfer",
            "transaction_details"=> [
                "gross_amount"=> $topup->amount,
                "order_id"=> $topup->id
            ],
            "customer_details"=> [
                "email"=> $user->email,
                "first_name"=> $user->name,
                "phone"=> $user->phone_number
            ],
            "item_details"=> [
                [
                    "id"=> "$topup->id",
                    "price"=> $topup->amount,
                    "quantity"=> 1,
                    "name"=> "Top Up"
                ]
            ],
            "bank_transfer"=>[
                "bank"=> "bca",
                "bca"=> [
                    "sub_company_code"=> "00000"
                ]
            ]
                        
        ];
                    
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
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
            $result = json_decode($response);
            $topup = Topup::find($topup->id);
            $topup->va_number = $result->va_numbers[0]->va_number;
            $topup->update();
            return api_response(true, 200,"Success.",$topup);
        }
        
        
    }
    
    
    public function view(Request $request){
        $token = $request->bearerToken();
        $user = Customer::where('api_token', $token)->first();

        $wallet = Wallet::whereHas('customer', function($query) use($token){
            $query->where('api_token',$token);
        })->first();
        
        $topup = TopUp::find($request->topup_id);
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
            $result = json_decode($response);
            $topup = Topup::find($topup->id);
            if($topup->status == TopupStatus::PENDING){
                $topup->status = $result->transaction_status=='settlement'?TopupStatus::SUCCESS:($result->transaction_status=='pending'?TopupStatus::PENDING:TopupStatus::FAILED);
                if($topup->status == TopupStatus::SUCCESS){
                    $wallet->amount = $wallet->amount+$topup->amount;
                    $wallet->update();
                }
            }
            $topup->update();
            return api_response(true, 200,"Success.",$topup);
        }
        
        
    }
}
            