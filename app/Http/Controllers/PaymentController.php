<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Billbook;
use App\BillingOrderItem;
use App\BillTax;
use App\BillDiscount;
use App\TransactionDetail;
use App\Category;
use App\SubCategory;
use App\Item;
use App\ItemImage;
use App\Variety;
use App\Restaurant;
use App\Table;
use App\TempCart;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\ItemDescription;
use App\Question;
use App\QuestionOption;
use App\QuestionAnswer;
use App\Qrcode;
use App\Currency;
use App\Tax;
use App\OrderTax;
use App\Feedback;
use App\PaymentGateway;
use App\PaymentConfig;
use App\Customer;
use DB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display payment page with mandatory details.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){ 


      //   $amt =$request->amt;
      //   $mob =$request->mob;
      //   $orderId =$request->idOrder;

      //  // return view('user/payment/index',compact('amt','mob','orderId'));

      //   return view('user/payment/payu',compact('amt','mob','orderId'));

      
        // dd($request->all());
        // $amt =$request->amt;
        // $mob =$request->mob;
        // $orderId =$request->idOrder;

        // return view('user/payment/payu',compact('amt','mob','orderId'));

        $amt =$request->amt;
       // $mob =$request->mob;
        $orderId =$request->idOrder;
       // $coupon_id =$request->applied_coupon;
        $billdetails=Order::where('id',$orderId)->first();
        //dd($request->all());
        if($billdetails)
        {
  
          $res_id=$billdetails->restaurant_id;
          $restaurant=Restaurant::where('id',$res_id)->first();
          $razor =PaymentConfig::where(['restaurant_id'=>$res_id,'active'=>1])->first();
          $gateway = PaymentConfig::select('payment_config.*','payment_gateways.gateway_name')
              ->join('payment_gateways','payment_gateways.id','payment_config.payment_gateway_id')
              ->where(['payment_config.restaurant_id'=>$res_id])->get();
  
           // return view('user/payment/index',compact('amt','mob','orderId'));
          return view('user/payment/payforinstant',compact('amt','orderId','billdetails','razor','gateway','restaurant'));
        }
        else{
          return redirect()->back()->withInput()->with('error', 'Order Id is not found in system.');;
        }

    }

    

    public function payments(Request $request){ 

      $amt =$request->amt;
      $mob =$request->mob;
      $orderId =$request->idOrder;
      $coupon_id =$request->applied_coupon;
      $billdetails=Billbook::where('id',$orderId)->first();

      if($billdetails)
      {


        $res_id=$billdetails->restaurant_id;
        $restaurant=Restaurant::where('id',$res_id)->first();
        $razor =PaymentConfig::where(['restaurant_id'=>$res_id,'active'=>1])->first();
        $gateway = PaymentConfig::select('payment_config.*','payment_gateways.gateway_name')
            ->join('payment_gateways','payment_gateways.id','payment_config.payment_gateway_id')
            ->where(['payment_config.restaurant_id'=>$res_id])->get();

         // return view('user/payment/index',compact('amt','mob','orderId'));
        return view('user/payment/paybylink',compact('amt','mob','orderId','coupon_id','billdetails','razor','gateway','restaurant'));
      }
      else{
        return redirect()->back()->withInput()->with('error', 'Order Id is not found in system.');;
      }

    }
    

    /**
     * Display payment response page with basic details.
     *
     * @return \Illuminate\Http\Response
     */
    public function charge(Request $request){
        Order::where('order_id',$request->order_id)->update(['payment_id'=>$request->razorpay_payment_id]);
        $data = Order::where('order_id',$request->order_id)->first(['order_id','payment_id','restaurant_id','table_id','created_at']);
        $url =Qrcode::where(['restaurant_id'=>$data->restaurant_id,'table_id'=>$data->table_id])->first(['project_url']);
        return view('user.success',compact('data','url'));
    }
     
    public function chargebylink(Request $request){
        //dd($request->all());
      if($request->gateway_name == "razor"){
        Billbook::where('id',$request->order_id)->update(['payment_id'=>$request->razorpay_payment_id,'payment_mode'=>'1']);
      }
      elseif($request->gateway_name == "paypal"){
        Billbook::where('id',$request->order_id)->update(['payment_id'=>$request->payment_id,'payment_mode'=>'1']);
      }
        $data = Billbook::where('id',$request->order_id)->first(['id','bill_number','order_id','payment_id','restaurant_id','table_id','mobile_no','total','created_at']);  
        TransactionDetail::create([
          'restaurant_id' => $data->restaurant_id,
          'table_id' => $data->table_id,
          'bill_id' => $data->id,
          'order_id' => $data->order_id,
          'payment_id' => $data->payment_id,
          'mobile_no' => $data->mobile_no,
          'payment_mode' => $request->gateway_name,
          'amount' => $data->total,
      ]);      
        $url =Qrcode::where(['restaurant_id'=>$data->restaurant_id,'table_id'=>$data->table_id])->first(['project_url']);
        
//        $this->thankyoumessage($data->mobile_no);

        $customer=Customer::where(['mobile_no'=>$data->mobile_no])->first();

        if($customer->isd_code=='91')
        {
            $this->thankyoumessage($customer->mobile_no,$data->id);                
        } 
        else{   
            $mobile_no = $customer->isd_code.$customer->mobile_no;
            $this->thankyou_isd_sms($mobile_no,$data->id);                
        }

        $mobile_no=$customer->isd_code.$customer->mobile_no;
        $this->thankyou_whatsapp($mobile_no,$data->id);


        $qrDetails=Qrcode::where('table_id',$data->table_id)->where('restaurant_id',$data->restaurant_id)->where('enabled',1)->first();

        //     print_r($qrDetails);
        if($qrDetails)
        {
            $url=$qrDetails->unique_code;


            $find_table='';
            $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
            $currency =Currency::where('code',$find_resto->currency)->first('symbol');
            if($qrDetails->table_id)
            {
              $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
            }
//            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
            $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();
            
            $question =Question::where('restaurant_id',$find_resto->id)->get();
            foreach($question as $val){
              $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
            }

            $questions =$question->toArray(); 

            $array=array();
            $images=array();
            $desc=array();
            $i=0;
            foreach($categories as $val){

                $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
                foreach($sub_cat as $val1){
                    $val['sub'.$val->category_name]=$sub_cat;
                   $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();
    
                   foreach($items as $val2){
                       $val1[$val1->category_name] =$items;
                       $images =ItemImage::where('item_id',$val2->id)->get();
                       foreach($images as $val3){
                           $val2[$val2->item_name] = $images;
                       }
                       $desc =ItemDescription::where('item_id',$val2->id)->get();
                       foreach($desc as $val4){
                        $val2['desc'.$val2->item_name] = $desc;
                       }
                       
                       $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                       if($varients)
                       {                
                        $val2['varient'.$val2->item_name] = $varients;
                       }
                   }
    
                }
    
                $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
                foreach($items1 as $value){
                    $val[$val->category_name]=$items1;
                 
                    $images1 =ItemImage::where('item_id',$value->id)->get();
                    foreach($images1 as $value1){
                        $value[$value->item_name] = $images1;
                    }
    
                    $desc1 =ItemDescription::where('item_id',$value->id)->get();
                    foreach($desc1 as $val4){
                     $value['desc'.$value->item_name] = $desc1;
                    }
    
                    $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                    if($varients)
                    {
                      $value['varient'.$value->item_name] = $varients;
                    }

                }    
            }
        }






        return view('user.payment.paylinksuccess',compact('data','url','categories','items','find_resto','find_table','questions','currency','url'));
    }
  

    public function thankyoumessage($receiverMobile, $bill_id)
    {

      $status = "failed";
      $billdetails=Billbook::where('id',$bill_id)->first();
      if($billdetails)
      {
        $restaurant=Restaurant::where('id',$billdetails->restaurant_id)->first();
      
        // $receiverMobile=$billdetails->mobile_no;
        $template = "Thank you for dining with us. Your payment has been accepted. View your invoice at:  ".url('/').'/invoice/'.$bill_id;
        $parameters = http_build_query([
        'username' => 'outdosolution',
        'apikey' => 'E50D9-FFA5D',
        'apirequest' => 'Text',
        'sender' => 'QRESTR',
        'route' => 'TRANS',
        'format' => 'json',
        'mobile'=> $receiverMobile,
        'message' => $template
        ]);

        $url = "http://smstech.techstreet.in/sms-panel/api/http/index.php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'?'.$parameters); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);

        if(curl_errno($ch))  //catch if curl error exists and show it
        {
        //      echo 'Curl error: ' . curl_error($ch); //save the response in db;
          $status = "failed";
        }
        else
        {
        //      $result;  // save result;
          $status = "success";
        }
        curl_close($ch);
      }
      return $status;
    }
  

    public function thankyou_isd_sms($receiverMobile, $bill_id)
    {

      $status = "failed";
      $billdetails=Billbook::where('id',$bill_id)->first();
      if($billdetails)
      {
        $restaurant=Restaurant::where('id',$billdetails->restaurant_id)->first();

        $template = "Thank you for dining with us. Your payment has been accepted. View your invoice at:  ".url('/').'/invoice/'.$bill_id;

        $parameters = json_encode([
         'to'=> '+'.$receiverMobile,
         'platform'=> 'web',
         'text' => $template
        ]);

        $url = "https://api.checkmobi.com/v1/sms/send";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
                                                                    
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: 67D23A97-F6AE-4EC0-A8EA-63382F5D3168'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        // print_r($result);
        if(curl_errno($ch))  //catch if curl error exists and show it
        {
          $status = "failed";
        }
        else
        {
          $status = "success";
        }
        curl_close($ch);
      }
      return $status;
    }


    public function thankyou_whatsapp($receiverMobile, $bill_id)
    {

      $status = "failed";
      $billdetails=Billbook::where('id',$bill_id)->first();
      if($billdetails)
      {
        $restaurant=Restaurant::where('id',$billdetails->restaurant_id)->first();
      
        // $receiverMobile=$billdetails->mobile_no;
        // $receiverMobile = '9716076512';
        $template = "Thank you for dining with us. Your payment has been accepted. View your invoice at:  ".url('/').'/invoice/'.$bill_id;

        $parameters = http_build_query([
         'channel' => 'whatsapp',
         // 'destination'=> '91'.$receiverMobile,
         'destination'=> $receiverMobile,
         'source' => '917834811114',
         'src.name'=> 'qrestroapi2',
         'message' => $template
        ]);


        $url = "https://api.gupshup.io/sm/api/v1/msg";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'apikey: d0fb0073a14c46a4c67f2dc7f34e2a5f'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);

        if(curl_errno($ch))  //catch if curl error exists and show it
        {
        //      echo 'Curl error: ' . curl_error($ch); //save the response in db;
          $status = "failed";
        }
        else
        {
        //      $result;  // save result;
          $status = "success";
        }
        curl_close($ch);
      }
      return $status;
    }
  




/*
    public function thankyoumessage($receiverMobile)
    {

        $template = "Your Order is Completed Now. Thank you for visiting us. We look forward to seeing you again";
        $parameters = http_build_query([
            'username' => 'outdosolution',
            'apikey' => 'E50D9-FFA5D',
            'apirequest' => 'Text',
            'sender' => 'TSTMSG',
            'route' => 'TRANS',
            'format' => 'json',
            'mobile'=> $receiverMobile,
            'message' => $template
        ]);

        $url = "http://smstech.techstreet.in/sms-panel/api/http/index.php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'?'.$parameters); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);

        if(curl_errno($ch))  //catch if curl error exists and show it
        {
            $status = "failed";
        }
        else
        {
            $status = "success";
        }
        curl_close($ch);
        return $status;
    }
*/


    public function payu(Request $request){

     dd($request->all());

    }

    public function showbill($billid){
        
      $tid=$billid;
      // $id = Auth::guard('restaurant')->id();
      // $orders = DB::table('orders')
      $bill=Billbook::where('id',$tid)->first();



      if($bill)
      {
        $restaurant_id = $bill->restaurant_id;
        $table_id = $bill->table_id;


//        dd($bill);

        $orders = DB::table('billing_order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'billing_order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'billing_order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','orders.name as customer_name','restaurants.name','tables.table_name','billing_order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number')
            // ->where('orders.restaurant_id', $id)
            ->where('billing_order_items.billing_id', $tid)->orderBy('billing_order_items.id','DESC')->get();
            
            $billdetails= DB::table('billbooks')
                ->LeftJoin('orders', 'orders.id', '=' ,'billbooks.order_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.order_id as order_number','tables.table_name','billbooks.*')
            ->where('billbooks.id', $tid)->orderBy('billbooks.id','DESC')->first();


        $taxes=Tax::where(['restaurant_id'=>$restaurant_id,'enabled'=>1])->get();

        $gstDetails = Restaurant::select('gst')->where('id',$restaurant_id)->orderBy('id','DESC')->first();


        $bill_taxes=DB::table('bill_taxes')
            ->LeftJoin('taxes', 'bill_taxes.tax_id', '=' ,'taxes.id')
            ->select('taxes.*','bill_taxes.*', 'bill_taxes.tax_value as tax_percentage')
            ->where('bill_taxes.bill_id', $tid)->orderBy('bill_taxes.id','ASC')->get();

        $discount_details=BillDiscount::where('bill_id',$tid)->first();


        $qrDetails=Qrcode::where('table_id',$table_id)->where('restaurant_id',$restaurant_id)->where('enabled',1)->first();

        //     print_r($qrDetails);
        if($qrDetails)
        {
            $url=$qrDetails->unique_code;


            $find_table='';
            $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
            $currency =Currency::where('code',$find_resto->currency)->first('symbol');
    

            if($currency)
            {
                $currency_symbol=$currency->symbol;            
            }
            else{
                $currency_symbol = '&#36;';
            }
            


            if($qrDetails->table_id)
            {
              $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
            }
//            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
            $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();
            
            $question =Question::where('restaurant_id',$find_resto->id)->get();
            foreach($question as $val){
              $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
            }

            $questions =$question->toArray(); 

            $array=array();
            $images=array();
            $desc=array();
            $i=0;
            foreach($categories as $val){

                $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
                foreach($sub_cat as $val1){
                    $val['sub'.$val->category_name]=$sub_cat;
                   $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();
    
                   foreach($items as $val2){
                       $val1[$val1->category_name] =$items;
                       $images =ItemImage::where('item_id',$val2->id)->get();
                       foreach($images as $val3){
                           $val2[$val2->item_name] = $images;
                       }
                       $desc =ItemDescription::where('item_id',$val2->id)->get();
                       foreach($desc as $val4){
                        $val2['desc'.$val2->item_name] = $desc;
                       }
                       
                       $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                       if($varients)
                       {                
                        $val2['varient'.$val2->item_name] = $varients;
                       }
                   }
    
                }
    
                $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
                foreach($items1 as $value){
                    $val[$val->category_name]=$items1;
                 
                    $images1 =ItemImage::where('item_id',$value->id)->get();
                    foreach($images1 as $value1){
                        $value[$value->item_name] = $images1;
                    }
    
                    $desc1 =ItemDescription::where('item_id',$value->id)->get();
                    foreach($desc1 as $val4){
                     $value['desc'.$value->item_name] = $desc1;
                    }
    
                    $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                    if($varients)
                    {
                      $value['varient'.$value->item_name] = $varients;
                    }

                }    
            }
        }

      // dd($billdetails);
        return view('user.payment.billdetail', compact('orders','tid','billdetails','bill','gstDetails','taxes','bill_taxes','discount_details','categories','items','find_resto','find_table','questions','currency_symbol','url'));




      }
      else{
        return redirect()->back()->withInput()->with('error', 'Order Id is not found in system.');;
      }

    }

    public function showinvoice($billid){
        
        $tid=$billid;
        // $id = Auth::guard('restaurant')->id();
        // $orders = DB::table('orders')
        $bill=Billbook::where('id',$tid)->first();
        if($bill)
        {
          $restaurant_id = $bill->restaurant_id;
          $table_id = $bill->table_id;

  //        dd($bill);
          $singleBillDetail=BillingOrderItem::where('billing_id',$billid)->first();

          $order=Order::where('id',$singleBillDetail->order_id)->first();
          // dd($order);
          $customer_name=$order->name;
          $order_number=$order->order_id;

          $orders = DB::table('billing_order_items')
              ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
              ->LeftJoin('items', 'items.id', '=' ,'billing_order_items.item_id')
              ->LeftJoin('varieties', 'varieties.id', '=' ,'billing_order_items.varient_id')
              ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
              ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
              ->select('orders.*','restaurants.name','tables.table_name','billing_order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number')
              // ->where('orders.restaurant_id', $id)
              ->where('billing_order_items.billing_id', $tid)->orderBy('billing_order_items.id','DESC')->get();
              
              $billdetails= DB::table('billbooks')
                  ->LeftJoin('orders', 'orders.id', '=' ,'billbooks.order_id')
              ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
              ->select('orders.order_id as order_number','tables.table_name','billbooks.*')
              ->where('billbooks.id', $tid)->orderBy('billbooks.id','DESC')->first();


          $taxes=Tax::where(['restaurant_id'=>$restaurant_id,'enabled'=>1])->get();

          $gstDetails = Restaurant::select('gst')->where('id',$restaurant_id)->orderBy('id','DESC')->first();

          $bill_taxes=DB::table('bill_taxes')
              ->LeftJoin('taxes', 'bill_taxes.tax_id', '=' ,'taxes.id')
              ->select('taxes.*','bill_taxes.*', 'bill_taxes.tax_value as tax_percentage')
              ->where('bill_taxes.bill_id', $tid)->orderBy('bill_taxes.id','ASC')->get();

          $discount_details=BillDiscount::where('bill_id',$tid)->first();




    //      $qrDetails=Qrcode::where('table_id',$table_id)->where('enabled',1)->first();
          $qrDetails=Qrcode::where(['restaurant_id'=>$restaurant_id,'table_id'=>$table_id])->where('enabled',1)->first();

          //     print_r($qrDetails);
          if($qrDetails)
          {
              $url=$qrDetails->unique_code;


              $find_table='';
              $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
              $currency =Currency::where('code',$find_resto->currency)->first('symbol');

              if($currency)
              {
                  $currency_symbol=$currency->symbol;            
              }
              else{
                  $currency_symbol = '&#36;';
              }
            


              if($qrDetails->table_id!='0')
              {
                $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
              }
              else{
                $find_table='0';
              }
  //            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
              $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();
              
              $question =Question::where('restaurant_id',$find_resto->id)->get();
              foreach($question as $val){
                $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
              }

              $questions =$question->toArray(); 

              $array=array();
              $images=array();
              $desc=array();
              $i=0;
              foreach($categories as $val){

                  $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
                  foreach($sub_cat as $val1){
                      $val['sub'.$val->category_name]=$sub_cat;
                     $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();
      
                     foreach($items as $val2){
                         $val1[$val1->category_name] =$items;
                         $images =ItemImage::where('item_id',$val2->id)->get();
                         foreach($images as $val3){
                             $val2[$val2->item_name] = $images;
                         }
                         $desc =ItemDescription::where('item_id',$val2->id)->get();
                         foreach($desc as $val4){
                          $val2['desc'.$val2->item_name] = $desc;
                         }
                         
                         $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                         if($varients)
                         {                
                          $val2['varient'.$val2->item_name] = $varients;
                         }
                     }
      
                  }
      
                  $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
                  foreach($items1 as $value){
                      $val[$val->category_name]=$items1;
                   
                      $images1 =ItemImage::where('item_id',$value->id)->get();
                      foreach($images1 as $value1){
                          $value[$value->item_name] = $images1;
                      }
      
                      $desc1 =ItemDescription::where('item_id',$value->id)->get();
                      foreach($desc1 as $val4){
                       $value['desc'.$value->item_name] = $desc1;
                      }
      
                      $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                      if($varients)
                      {
                        $value['varient'.$value->item_name] = $varients;
                      }

                  }    
              }
          }
      } 
      // dd($orders);
      // dd($billdetails);
      // dd($find_resto);
        return view('user.payment.bill-invoice', compact('orders','find_resto','customer_name','order_number','tid','billdetails','bill','gstDetails','taxes','categories','find_resto','find_table','questions', 'currency_symbol', 'url','bill_taxes','discount_details'));
    }




    public function chargebyinstant(Request $request){
      // dd($request->all());
     if($request->gateway_name == "razor"){
       Order::where('id',$request->order_id)->update(['payment_id'=>$request->razorpay_payment_id]);
     }
     elseif($request->gateway_name == "paypal"){
       Order::where('id',$request->order_id)->update(['payment_id'=>$request->payment_id]);
     }
       $data = Order::where('id',$request->order_id)->first(['id','order_id','payment_id','restaurant_id','mobile_no','total','created_at']);  
       TransactionDetail::create([
         'restaurant_id' => $data->restaurant_id,
         'table_id' => 0,
         'bill_id' => 0,
         'order_id' => $request->order_id,
         'payment_id' => $data->payment_id,
         'mobile_no' => $data->mobile_no,
         'payment_mode' => $request->gateway_name,
         'amount' => $data->total,
     ]);      
      // $url =Qrcode::where(['restaurant_id'=>$data->restaurant_id,'table_id'=>$data->table_id])->first(['project_url']);
       
 //        $this->thankyoumessage($data->mobile_no);
 
       $customer=Customer::where(['mobile_no'=>$data->mobile_no])->first();
 
       if($customer->isd_code=='91')
       {
           $this->thankyoumessage($customer->mobile_no,$data->id);                
       } 
       else{   
           $mobile_no = $customer->isd_code.$customer->mobile_no;
           $this->thankyou_isd_sms($mobile_no,$data->id);                
       }
 
       $mobile_no=$customer->isd_code.$customer->mobile_no;
       $this->thankyou_whatsapp($mobile_no,$data->id);
 
 
       $qrDetails=Order::where('restaurant_id',$data->restaurant_id)->first();
 
       //     print_r($qrDetails);
       if($qrDetails)
       {
           $url=$qrDetails->unique_code;
 
 
           $find_table='';
           $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
           $currency =Currency::where('code',$find_resto->currency)->first('symbol');
           // if($qrDetails->table_id)
           // {
           //   $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
           // }
 //            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
           $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();
           
           $question =Question::where('restaurant_id',$find_resto->id)->get();
           foreach($question as $val){
             $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
           }
 
           $questions =$question->toArray(); 
 
           $array=array();
           $images=array();
           $desc=array();
           $items="";
           $i=0;
           foreach($categories as $val){
 
               $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
               foreach($sub_cat as $val1){
                   $val['sub'.$val->category_name]=$sub_cat;
                  $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();
   
                  foreach($items as $val2){
                      $val1[$val1->category_name] =$items;
                      $images =ItemImage::where('item_id',$val2->id)->get();
                      foreach($images as $val3){
                          $val2[$val2->item_name] = $images;
                      }
                      $desc =ItemDescription::where('item_id',$val2->id)->get();
                      foreach($desc as $val4){
                       $val2['desc'.$val2->item_name] = $desc;
                      }
                      
                      $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                      if($varients)
                      {                
                       $val2['varient'.$val2->item_name] = $varients;
                      }
                  }
   
               }
   
               $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
               foreach($items1 as $value){
                   $val[$val->category_name]=$items1;
                
                   $images1 =ItemImage::where('item_id',$value->id)->get();
                   foreach($images1 as $value1){
                       $value[$value->item_name] = $images1;
                   }
   
                   $desc1 =ItemDescription::where('item_id',$value->id)->get();
                   foreach($desc1 as $val4){
                    $value['desc'.$value->item_name] = $desc1;
                   }
   
                   $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                   if($varients)
                   {
                     $value['varient'.$value->item_name] = $varients;
                   }
 
               }    
           }
       }
       return view('user.payment.paylinksuccess',compact('data','categories','items','find_resto','find_table','questions','currency','url'));
 
 
     }


}
