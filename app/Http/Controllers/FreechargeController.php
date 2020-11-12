<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentConfig;
use App\AppUser;
use App\Freecharge;
use App\Cart;
use App\FreechargeTransaction;
use App\TransactionDetail;
use Illuminate\Support\Facades\Validator;

class FreechargeController extends Controller
{
    public function index(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        $user_id = $request->user_id;
        $merchantTxnId = $request->merchantTxnId;
        $channel = $request->channel; // WEB,ANDROID,IOS,WINDOWS
        $instruction = $request->instruction;
        
        $PaymentConfig = PaymentConfig::where('restaurant_id',$restaurant_id)->where('payment_type',1)->where('payment_gateway_id',6)->where('active',1)->first();
        $platformId = $PaymentConfig->key_1;
        $merchantId = $PaymentConfig->key_2;

        $AppUser = AppUser::where('id',$user_id)->where('is_verified',1)->where('is_blocked',0)->first();
        $email = $AppUser->email_address;
        $mobile = $AppUser->mobile_number;
        $customerName = $AppUser->name;

        $subtotal = 0;
        $cart = Cart::where('user_id',$user_id)->get();
        if($cart->count() > 0){
            foreach($cart as $value){
                $subtotal = $subtotal+$value->amount;
            }
        }
        $amount = $subtotal+getDeliveryFee($subtotal);

        $currency = "INR";
        $productInfo = "Home Delivery";

        $furl = url("/payment-failed?user_id=".$user_id."&restaurant_id=".$restaurant_id.'&merchantTxnId='.$merchantTxnId.'&instruction='.$instruction);
        $surl = url("/payment-successful?user_id=".$user_id."&restaurant_id=".$restaurant_id.'&merchantTxnId='.$merchantTxnId.'&instruction='.$instruction);

        $freecharge = new Freecharge();

        $params = array("amount" => "$amount","channel" => $channel,"currency" => $currency,"customerName" => $customerName,"email" => $email,"furl" => $furl,"merchantId" => $merchantId,"merchantTxnId" => $merchantTxnId,"mobile" => $mobile,"platformId" => $platformId,"productInfo" => $productInfo,"surl" => $surl);

        $response = json_decode($freecharge->checksum($params));
        $checksum = $response->checksum;
        
        $action = "https://checkout-sandbox.freecharge.in/api/v1/co/pay/init";
        return view('payment-gateway.index', compact('merchantTxnId','merchantId','platformId','checksum','amount','currency','productInfo','email','mobile','customerName','furl','surl','channel','action'));
    }
    public function failed(Request $request){
        // print_r($request->all());
        // die;

        $rules = [
            "merchantTxnId" => "required",
            "restaurant_id" => "required",
            "user_id" => "required",
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return "Something went wrong!!";
        }

        $PaymentConfig = PaymentConfig::where('restaurant_id',$request->restaurant_id)->where('payment_type',1)->where('payment_gateway_id',6)->where('active',1)->first();
        $platformId = $PaymentConfig->key_1;
        $merchantId = $PaymentConfig->key_2;

        $freecharge = new Freecharge();
        $params = array("merchantId" => $merchantId,"merchantTxnId" => $request->merchantTxnId,"platformId" => $platformId,"txnType" => "CUSTOMER_PAYMENT");
        $response = json_decode($freecharge->checksum($params));
        $checksum = $response->checksum;

        $txn_params = array("checksum" => $checksum,"merchantId" => $merchantId,"merchantTxnId" => $request->merchantTxnId,"platformId" => $platformId,"txnType" => "CUSTOMER_PAYMENT");
        $txn_response = json_decode($freecharge->txnStatus($txn_params));

        if($txn_response->status == 'FAILED'){
            $txn = FreechargeTransaction::where('merchant_txn_id',$request->merchantTxnId)->first();
            if(!$txn){
                FreechargeTransaction::insert(['amount' => $txn_response->amount,'merchant_txn_id' => $txn_response->merchantTxnId,'txn_id' => $txn_response->txnId,'status' => $txn_response->status]);
            }
        }

        return view('payment-gateway.failed');
    }
    public function successful(Request $request){
        // print_r($request->all());
        // die;

        $rules = [
            "merchantTxnId" => "required",
            "restaurant_id" => "required",
            "user_id" => "required",
        ];
        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return "Something went wrong!!";
        }

        $AppUser = AppUser::where('id',$request->user_id)->first();
        $mobile_no = $AppUser->mobile_number;
        
        $PaymentConfig = PaymentConfig::where('restaurant_id',$request->restaurant_id)->where('payment_type',1)->where('payment_gateway_id',6)->where('active',1)->first();
        $platformId = $PaymentConfig->key_1;
        $merchantId = $PaymentConfig->key_2;

        $freecharge = new Freecharge();
        $params = array("merchantId" => $merchantId,"merchantTxnId" => $request->merchantTxnId,"platformId" => $platformId,"txnType" => "CUSTOMER_PAYMENT");
        $response = json_decode($freecharge->checksum($params));
        $checksum = $response->checksum;

        $txn_params = array("checksum" => $checksum,"merchantId" => $merchantId,"merchantTxnId" => $request->merchantTxnId,"platformId" => $platformId,"txnType" => "CUSTOMER_PAYMENT");
        $txn_response = json_decode($freecharge->txnStatus($txn_params));

        if($txn_response->status == 'SUCCESS'){
            $txn = FreechargeTransaction::where('merchant_txn_id',$request->merchantTxnId)->first();
            if(!$txn){
                FreechargeTransaction::insert(['amount' => $txn_response->amount,'merchant_txn_id' => $txn_response->merchantTxnId,'txn_id' => $txn_response->txnId,'status' => $txn_response->status]);
                $params = array("user_id" => $request->user_id,"instruction" => $request->instruction);
                $order = $freecharge->placeOrder($params);
                $json_order = json_decode($order);
                TransactionDetail::insert(['restaurant_id' => $request->restaurant_id,'table_id' => 0,'order_id' => $json_order->Response->order_id,'mobile_no' => $mobile_no,'payment_id' => $txn_response->txnId,'payment_mode' => 'online','amount' => $txn_response->amount,'created_by' => $request->user_id]);
            }
        }

        return view('payment-gateway.success');
    }
}
