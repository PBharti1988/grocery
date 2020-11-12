<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use App\Item;
use App\ItemDescription;
use App\Variety;
use App\ItemImage;
use App\Restaurant;
use App\Order;
use App\OrderItem;
use App\Billbook;
use App\BillTax;
use App\BillingOrderItem;
use App\BillDiscount;
use App\Qrcode;
use App\Tax;
use App\Currency;
use App\TransactionDetail;
use App\Customer;
use App\Coupon;
use Auth;
use QR;
use DB;
use Illuminate\Http\Request;

class BillbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'billbook');
  
          if(isset($perms))
          {
            if($perms->view)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }

        }
        else{
          return redirect('admin');
        }


        $find_resto = Restaurant::where(['id'=>$id,'enabled'=>1])->first();
        $currency=$currency =Currency::where('code',$find_resto->currency)->first('symbol');
        if($currency)
        {
            $currency_symbol=$currency->symbol;            
        }
        else{
            $currency_symbol = '&#36;';
        }
/*
        $orders = DB::table('billbooks')
            ->LeftJoin('billing_order_items', 'billing_order_items.billing_id', '=' ,'billbooks.id')
            ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'billbooks.restaurant_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'orders.order_status')
            ->select('restaurants.name','order_statuses.name as orderstatus','billbooks.*','orders.order_id as order_number', 'orders.name as customer_name')
            ->where('billbooks.restaurant_id', $id)->orderBy('billbooks.id','DESC')->distinct()->paginate(10);
*/
        
        $orders = DB::table('billbooks')
            ->LeftJoin('billing_order_items', 'billing_order_items.billing_id', '=' ,'billbooks.id')
            ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'billbooks.restaurant_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'orders.order_status')
            ->select('restaurants.name','order_statuses.name as orderstatus','billbooks.*')
            ->where('billbooks.restaurant_id', $id)->orderBy('billbooks.id','DESC')->distinct()->paginate(10);

        if(count($orders)>0)
        {
          foreach ($orders as $billbook)
          {
            $orders1 = DB::table('billbooks')
            ->LeftJoin('billing_order_items', 'billing_order_items.billing_id', '=' ,'billbooks.id')
            ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
            ->select('billbooks.*','orders.order_id as order_number','orders.id as order_id', 'orders.name as customer_name')
            ->where('billbooks.id', $billbook->id)->orderBy('orders.id','DESC')->distinct()->get();
            
            foreach($orders1 as $odd)
            {
              if(isset($billbook->order_number))
              {
                $billbook->order_number = $billbook->order_number . '<br> <a href="'.url('/order/'.$odd->order_id.'/detail').'">'.$odd->order_number.'</a>';
              }
              else{
                $billbook->order_number= '<a href="'.url('/order/'.$odd->order_id.'/detail').'">'.$odd->order_number.'</a>';
              }
              $billbook->customer_name=$odd->customer_name;
            }
          }
        }

  
  //      dd($orders);

        return view('admin.billbook.index', compact('orders','currency_symbol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function newtableorder()
    {
       // $id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'billbook');
  
          if(isset($perms))
          {
            if($perms->view)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }


        }
        else{
          return redirect('admin');
        }

        // $orders = DB::table('orders')
        $orders = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','varieties.name as variety_name')
            ->where('orders.restaurant_id', $id)
            ->where('order_items.order_status', '0')->orderBy('order_items.id','DESC')->paginate(10);

       // dd($orders);
        return view('admin.orders.neworder', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tableorder()
    {
       // $id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id()){
          $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $res_id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($res_id,$user_type,'billbook');
  
          if(isset($perms))
          {
            if($perms->view)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }
        }
        else{
          return redirect('admin');
        }

        $itemCount=array();
        $tables = DB::table('tables')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'tables.restaurant_id')
            ->select('tables.*','restaurants.name')
            ->where('tables.restaurant_id', $id)->orderBy('tables.id','ASC')->get();

        // $orders = DB::table('orders')
        $orders = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','varieties.name as variety_name')
            ->where('orders.restaurant_id', $id)
            ->where('order_items.order_status', '2')
            ->orderBy('order_items.id','DESC')->get();
       // dd($orders);
        foreach ($orders as $key => $order) {
        	if(isset($itemCount[$order->table_id]))
        	$itemCount[$order->table_id]=$itemCount[$order->table_id]+1;
        	else
        	$itemCount[$order->table_id]=1;
        }
        // print_r($itemCount);
        // die;
        return view('admin.orders.tableorder', compact('tables','itemCount'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function billdetail(Request $request, $tid){
           
      //  $id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'billbook');
  
          if(isset($perms))
          {
            if($perms->view)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }

        }
        else{
          return redirect('admin');
        }


        $find_resto = Restaurant::where(['id'=>$id,'enabled'=>1])->first();
        $coupons = Coupon::where(['restaurant_id'=>$id,'enabled'=>1])->get();
        $currency=$currency =Currency::where('code',$find_resto->currency)->first('symbol');
        if($currency)
        {
            $currency_symbol=$currency->symbol;            
        }
        else{
            $currency_symbol = '&#36;';
        }

        if($request->payment_mode=='cash')
        {

          if(isset($perms))
          {
            if($perms->create)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }


          $payment_id=date('Ym').$this->unique_id(9);
          TransactionDetail::create([
                        'restaurant_id' => $id,
                        'table_id' => $request->table_id,
                        'bill_id' => $request->bill_id,
                        'order_id' => $request->order_id,
                        'payment_id' => $payment_id,
                        'mobile_no' => $request->mobile_no,
                        'payment_mode' => $request->payment_mode,
                        'amount' => $request->amount,
                        'created_by' => $id
                    ])->id;


          Billbook::where('id',$request->bill_id)->update(['payment_id'=>$payment_id,'payment_mode'=>'2']);

          $customer=Customer::where(['mobile_no'=>$request->mobile_no])->first();

          if($customer->isd_code=='91')
          {
              $this->thankyoumessage($customer->mobile_no,$request->bill_id);                
          }
          else{   
              $mobile_no = $customer->isd_code.$customer->mobile_no;
              $this->thankyou_isd_sms($mobile_no,$request->bill_id);                
          }

          $mobile_no=$customer->isd_code.$customer->mobile_no;
          $this->thankyou_whatsapp($mobile_no,$request->bill_id);

        }



/*
        $quantitycounts = DB::table('billing_order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'billing_order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'billing_order_items.varient_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->selectRaw('count(billing_order_items.quantity) as itemCount')
            ->where('billing_order_items.billing_id', $tid)->groupBy('billing_order_items.item_id')->orderBy('billing_order_items.id','DESC')->get();

        dd($quantitycounts);
*/




        $orders = DB::table('billing_order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'billing_order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'billing_order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'billing_order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','tables.table_name','billing_order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number')
            ->where('orders.restaurant_id', $id)
            ->where('billing_order_items.billing_id', $tid)->orderBy('billing_order_items.id','DESC')->get();
			
		    $billdetails= DB::table('billbooks')
		        ->LeftJoin('orders', 'orders.id', '=' ,'billbooks.order_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'billbooks.table_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'billbooks.restaurant_id')
            ->select('orders.order_id as order_number','tables.table_name','billbooks.*','restaurants.name as restaurant_name','orders.name as customer_name')
            ->where('billbooks.id', $tid)->orderBy('billbooks.id','DESC')->first();

        $taxes=Tax::where(['restaurant_id'=>$id,'enabled'=>1])->get();

        $gstDetails = Restaurant::select('gst')->where('id',$id)->orderBy('id','DESC')->first();

        $bill_taxes=DB::table('bill_taxes')
            ->LeftJoin('taxes', 'bill_taxes.tax_id', '=' ,'taxes.id')
            ->select('taxes.*','bill_taxes.*', 'bill_taxes.tax_value as tax_percentage')
            ->where('bill_taxes.bill_id', $tid)->orderBy('bill_taxes.id','ASC')->get();

        $discount_details=BillDiscount::where('bill_id',$tid)->first();

      // dd($discount_details->coupon_code);
      // dd($bill_taxes);
      // dd($billdetails);
      // dd($orders);
        return view('admin.billbook.billdetail', compact('orders','tid','billdetails','gstDetails','taxes','bill_taxes','currency_symbol','coupons','discount_details'));
    }

    public function unique_id($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }


    public function thankyoumessage($receiverMobile,$bill_id)
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


    public function thankyou_whatsapp($receiverMobile,$bill_id)
    {

      $status = "failed";
      $billdetails=Billbook::where('id',$bill_id)->first();
      if($billdetails)
      {
        $restaurant=Restaurant::where('id',$billdetails->restaurant_id)->first();
      
        // $receiverMobile=$billdetails->mobile_no;
        // $template = "Thank you for Dine-In. Here is your payment link: ".url('/').'/billpayments/'.$bill_id;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::guard('restaurant')->id())
        {
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'billbook');
  
          if(isset($perms))
          {
            if($perms->update)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }

        }
        else{
          return redirect('admin');
        }


        $order = Order::find($id);
        // $orderItems = OrderItem::where('order_id',$id)->get();

        return view('admin.orders.edit', compact('order','orderItems'));
    }  

    public function detail($id)
    {
        // $orderItems = OrderItem::where('order_id',$id)->get();

        // $order = Order::find($id);
        // return view('admin.orders.detail', compact('order','orderItems'));
        // $id = Auth::guard('restaurant')->id();

        // $orders = DB::table('orders')
        $show_gen_btn = 1;
        $generate_bill=1;
        $order_id=$id;
        $order_items = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'order_items.order_status')
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number', 'order_statuses.name as order_status_name')
            ->where('orders.id', $order_id)->orderBy('order_items.id','DESC')->paginate(10);


        // check the bill book with order id if exist then generate order button will not displayed. Pass a variable named $bill_generated = 1 (deative all the buttons) 

        $isBillGenerated=Billbook::where('order_id',$order_id)->orderBy('id','DESC')->first();
		if($isBillGenerated)
        {
	    	$generate_bill=0;
        }

		$acceptedOrderItem=OrderItem::where('order_id',$order_id)->where('order_status','1')->first();
		if($acceptedOrderItem)
		{				
	    	$show_gen_btn=0;
		}
    
            // ->where('order_items.order_status', '1')->orderBy('order_items.id','DESC')->paginate(10);

       // dd($order_items);
        return view('admin.orders.detail', compact('order_items','order_id','show_gen_btn','generate_bill','isBillGenerated'));

    }  

  	public function neworder_update_status(Request $request){
			
		$status =$request->status;
		$order_id = $request->order_id;
		$item_id = $request->item_id;
		$varient_id = $request->varient_id;
		if($varient_id!='')
		{
	    	OrderItem::where('order_id',$order_id)->where('item_id',$item_id)->where('varient_id',$varient_id)->update(['order_status'=>$status]);
		}
		else{
	    	OrderItem::where('order_id',$order_id)->where('item_id',$item_id)->update(['order_status'=>$status]);
		}
    	if($status=='2')
    	{
			Order::where('id',$order_id)->update(['order_status'=>$status]);
    	}
    	else if($status=='3')
    	{
    		$acceptedOrderItem=OrderItem::where('order_id',$order_id)->where('order_status','2')->first();
			if($acceptedOrderItem)
			{				
		    	Order::where('id',$order_id)->update(['order_status'=>'2']);
			}
    	}
	    $result = array('status' => 'success');
	    return response()->json($result);

	}

  	public function accept_order(Request $request){
			
		$status =$request->status;
		$order_id = $request->order_id;
		if($order_id)
		{
	    	OrderItem::where('order_id',$order_id)->update(['order_status'=>$status]);
	    	if($status=='2')
	    	{
	    		$resdiv="accepted";
	    	}
	    	else if($status=='3')
	    	{
	    		$resdiv="rejected";	    		
	    	}
	    	Order::where('id',$order_id)->update(['order_status'=>$status]);
		}

	    $result = array('status' => 'success','res' => $resdiv);
	    return response()->json($result);

	}

  	public function generate_bill (Request $request){

	    $subtotal=0;
		$status =$request->status;
		$order_id = $request->order_id;
		// $order_id = 8;
		if($order_id)
		{

	    	$order= Order::where('id',$order_id)->first();
		    $billBook = Billbook::select('bill_number')->where('restaurant_id',$order->restaurant_id)->orderBy('id','DESC')->first();
		    $gstDetails = Restaurant::select('gst')->where('id',$order->restaurant_id)->orderBy('id','DESC')->first();
		    if($billBook){
		      $bill_number = $billBook->bill_number+1;
		    }
		    else{
		      $bill_number = 1;
		    }

		    $bill_id = Billbook::create([
		                    'bill_number' => $bill_number,
		                    'order_id' => $order->id,
                        'payment_id' => '',
                        'payment_mode' => 0,
		                    'restaurant_id' => $order->restaurant_id,
		                    'table_id' => $order->table_id,
		                    'mobile_no' => $order->mobile_no,
		                    'order_status' => '1',
		                    'sub_total' => '1',
		                    'tax' => '0',
		                    'total' => '1',
		                    // 'created_by' => Auth::id()
		                    'created_by' => 1
		                ])->id;



		    if($bill_id)
		    {
				$acceptedOrderItems=OrderItem::where('order_id',$order_id)->where('order_status','2')->get();
		      	foreach ($acceptedOrderItems as $itemId => $item) {
		      		BillingOrderItem::create([
			            'billing_id'=>$bill_id,
			            'order_id'=>$order_id,
			            'item_id'=>$item->item_id,
			            'varient_id'=>''.$item->varient_id,
			            'quantity'=>$item->quantity,
			            'price'=>$item->price,
			            'order_status'=>1,
	                    // 'created_by' => 1
		          	]);
		          	$subtotal+=($item->price);
		        }
			    if($gstDetails->gst)
			    {
			      $tax=(($subtotal*5)/100);
			    }
			    else{
			      $tax=0;
			    }
			    $total=$subtotal+$tax;
			    Billbook::where('id',$bill_id)->update(['sub_total'=>$subtotal,'tax'=>$tax,'total'=>$total]);
			}
		}

				// dd($acceptedOrderItems);
	    $result = array('status' => 'success','res' => $bill_id);
	    return response()->json($result);

	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function check_apply_coupon(Request $request){
    
    
    $code=$request->code;
    $bill_id=$request->bid;
    $bill_details= Billbook::where('id',$bill_id)->first();
    $coupon = Coupon::where(['restaurant_id'=>$bill_details->restaurant_id,'enabled'=>1,'coupon_code'=>$code])->first();
    
    if($coupon)
    {
        if($coupon->count > $coupon->applied_count)
        {
            $result= array('data' => $coupon, 'status'=>'success' );
        }
        else
        {
            $result= array('data' => $coupon, 'status'=>'fail','message'=>'Coupon Max Limit is reached. Try another coupon.' );                
        }
    }
    else{
        if($code=='')
        {
            $result= array('data' => $coupon, 'status'=>'fail' ,'message'=>'No Coupon applied.');
        }
        else
        {
            $result= array('data' => $coupon, 'status'=>'fail' ,'message'=>'Coupon is expired or does not exist.');
        }
    }

/*
    check coupon is valid
      
      if valid then update the bill_taxes
      update the Billbook
      update the coupon with create or update

      else
        update discount with 0 with subtotal
        and update bill_taxes
        update bill_discount with blank entry
*/

    return response()->json($result);
  }

}
