<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PaymentGateway;
use App\PaymentConfig;
class PaymentConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $gateway=PaymentGateway::get();
       //  $res_id = Auth::guard('restaurant')->id();
       if(Auth::guard('restaurant')->id())
       {
        $res_id= Auth::guard('restaurant')->id();
       }
        else if(Auth::guard('manager')->id())
        {
         $manager = Auth::guard('manager')->user();
          $res_id=$manager->restaurant_id;
           }
         else{
           return redirect('admin');
        }
         foreach($gateway as $val){
             $check = PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>$val->id])->first();
             if(!$check){
                PaymentConfig::create(['restaurant_id'=>$res_id,'payment_gateway_id'=>$val->id]);
             }
         }

         $paypal =PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>1])->first();
         $strip =PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>2])->first();
         $payu =PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>3])->first();
         $razor =PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>4])->first();

         $gateway = PaymentConfig::select('payment_config.*','payment_gateways.gateway_name')
          ->join('payment_gateways','payment_gateways.id','payment_config.payment_gateway_id')
          ->where(['payment_config.restaurant_id'=>$res_id])->get();
         
         return view('admin.payment-config.index',compact('paypal','strip','payu','razor','res_id','gateway'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function PaymentDetailStore(Request $request){
         $gateway_id = $request->payment_gateway_id;
         $type = $request->payment_type_id;
         $customer_id =$request->customer_id;
         $merchant = $request->merchant_id;
         $res_id =$request->restaurant_id;
         $active = $request->active == 'on' ? 1 : 0;
         $live_mode =$request->live_mode == 'on' ? 1 : 0;

         if($gateway_id != 5){
          if($active == 1){
         $check_active = PaymentConfig::where([
            ['active',1],
            ['restaurant_id', $res_id],
            // ['payment_gateway_id', '!=', $gateway_id],
            ['payment_gateway_id', '!=', $gateway_id],
            ['payment_gateway_id', '<', 5],
           ])->first();

           if ($check_active) {
            return redirect()->back()->withInput($request->input())->with('error', 'Cannot activate two payment gateway at same time');
        }
    }

         $array=array(
             'payment_type'=>$type,
             'key_1'=> $customer_id,
             'key_2'=> $merchant,
             'active'=>$active,
             'live_mode'=>$live_mode
         );
        
            PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>$gateway_id])->update($array);
        }else{
            $array=array(
                'payment_type'=>$type,
                'active'=>$active,
                'live_mode'=>$live_mode
            );
           
               PaymentConfig::where(['restaurant_id'=>$res_id,'payment_gateway_id'=>$gateway_id])->update($array);

        }

        return redirect()->back()->withInput($request->input())->with('success', 'updated successfully');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
