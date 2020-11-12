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
use App\BillDiscount;
use App\BillingOrderItem;
use App\BillTax;
use App\Qrcode;
use App\Tax;
use App\Currency;
use App\Customer;
use App\Coupon;
use Auth;
use QR;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
            $perms=get_admin_module_permission($id,$user_type,'order');

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

        if($request->search){
           
            $data =Order::query();
            $data=$data->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'orders.order_status')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','order_statuses.name as orderstatus','tables.table_name as table_name','orders.name as customer_name')
            ->where('orders.restaurant_id', $id);
            if(!empty($request->order_number)){
               $data->where('orders.order_id',$request->order_number);
            }
            if(!empty($request->mobile)){
                $data->where('orders.mobile_no',$request->mobile);
             }
             if(!empty($request->customer_name)){
                $data->where('orders.name', 'like', '%' .$request->customer_name. '%');
             }
            $orders=$data->orderBy('orders.id','DESC')->paginate(10);
        }
       else{
        $orders = DB::table('orders')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'orders.order_status')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','order_statuses.name as orderstatus','tables.table_name as table_name','orders.name as customer_name')
            ->where('orders.restaurant_id', $id)->orderBy('orders.id','DESC')->paginate(10);
       }
     //   dd($orders);
        return view('admin.orders.index', compact('orders','currency_symbol'));
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
            $perms=get_admin_module_permission($id,$user_type,'table-order');

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
    public function tableorder(Request $request)
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
            $perms=get_admin_module_permission($id,$user_type,'table-order');

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
       
        if($request->table_name){
            $tables = DB::table('tables')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'tables.restaurant_id')
            ->select('tables.*','restaurants.name')
            ->where('tables.restaurant_id', $id)
            ->where('tables.table_name', 'like', '%' .$request->table_name. '%')
            ->orderBy('tables.table_name','ASC')->get();

        // $orders = DB::table('orders')
        $orders = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','varieties.name as variety_name')
            ->where('orders.restaurant_id', $id)
            ->where('tables.table_name', 'like', '%' .$request->table_name. '%')
            ->where('order_items.order_status', '2')
            ->where('order_items.deleted_at',null)
            ->orderBy('order_items.id','DESC')->get();
       // dd($orders);
        foreach ($orders as $key => $order) {
        	if(isset($itemCount[$order->table_id]))
        	$itemCount[$order->table_id]=$itemCount[$order->table_id]+1;
        	else
        	$itemCount[$order->table_id]=1;
        }
         
        }
        else{
        $tables = DB::table('tables')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'tables.restaurant_id')
            ->select('tables.*','restaurants.name')
            ->where('tables.restaurant_id', $id)->orderBy('tables.table_name','ASC')->get();

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
            ->where('order_items.deleted_at',null)
            ->orderBy('order_items.id','DESC')->get();
       // dd($orders);
        foreach ($orders as $key => $order) {
        	if(isset($itemCount[$order->table_id]))
        	$itemCount[$order->table_id]=$itemCount[$order->table_id]+1;
        	else
        	$itemCount[$order->table_id]=1;
        }
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
    public function tableorderdetail($tid){
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id()){
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($id,$user_type,'table-order');

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
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number')
            ->where('orders.restaurant_id', $id)
            ->where('tables.id', $tid)
            ->where('order_items.deleted_at',null)
            ->where('order_items.order_status', '2')->orderBy('order_items.id','DESC')->get();

        $coupons = Coupon::where(['restaurant_id'=>$id,'enabled'=>1])->get();
        $taxes=Tax::where(['restaurant_id'=>$id,'enabled'=>1])->get();

       // dd($coupons);
        return view('admin.orders.tableorderdetail', compact('orders','tid','taxes','coupons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_apply_coupon(Request $request){
       // $id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
           $manager = Auth::guard('manager')->user();
           $id=$manager->restaurant_id;
        }
        else{
            return redirect('admin');
        }
        
        $coupon_id=$request->cid;
        $coupon = Coupon::where(['restaurant_id'=>$id,'enabled'=>1,'id'=>$coupon_id])->first();
        
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
            if($coupon_id=='')
            {
                $result= array('data' => $coupon, 'status'=>'fail' ,'message'=>'No Coupon applied.');
            }
            else
            {
                $result= array('data' => $coupon, 'status'=>'fail' ,'message'=>'Coupon is expired or does not exist.');
            }
        }
        return response()->json($result);
    }


    public function orderconclude (Request $request,$id){

       // $rest_id = Auth::guard('restaurant')->id();

        if(Auth::guard('restaurant')->id())
        {
            $rest_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $rest_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($rest_id,$user_type,'order');

            if(isset($perms))
            {
                if($perms->create)
                {}
                else{
                    return view('admin.nopermission')->with('error', 'Permission Denied');
                }         
            }
        }
        else{
            return redirect('admin');
        }
        
        $customer_notification= $request->customer_notification=='on'?1:0;
        
        $order_id=$id;
        $order_items = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'order_items.order_status')
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','items.item_type','items.short_description','varieties.name as variety_name','orders.order_id as order_number', 'order_statuses.name as order_status_name')
            ->where('orders.id', $order_id)
            ->where('order_items.order_status', '2')
            ->orderBy('order_items.id','DESC')->get();

       // dd($order_items);

        $subtotal=0;
        $bill_id='';
        $billdetails='';
        $mobile_no='';
        $orders='';
        if(count($order_items) > 0)
        {

            $order= Order::where('id',$order_id)->first();
            $billBook = Billbook::select('bill_number')->where('restaurant_id',$order->restaurant_id)->orderBy('id','DESC')->first();
            $taxes = Tax::where('restaurant_id',$order->restaurant_id)->get();
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
                            'sub_total' => 0,
                            'discount' => 0,
                            'tax' => 0,
                            'total' => 0,
                            'created_by' => 1
                        ])->id;
            
            $mobile_no=$order->mobile_no;
            
            if($bill_id)
            {
                $acceptedOrderItems=OrderItem::where('order_id',$order_id)->where('order_status','2')->get();
                foreach ($acceptedOrderItems as $itemId => $item) 
                {
                    BillingOrderItem::create([
                        'billing_id'=>$bill_id,
                        'order_id'=>$order_id,
                        'item_id'=>$item->item_id,
                        'varient_id'=>''.$item->varient_id,
                        'quantity'=>$item->quantity,
                        'price'=>$item->price,
                        'order_status'=>$item->order_status
                        // 'created_by' => 1
                    ]);
                    $subtotal+=($item->price)*($item->quantity );
                    Order::where('id',$item->order_id)->update(['order_status'=>'4']);
                    OrderItem::where('item_id',$item->item_id)->where('order_status','2')->update(['order_status'=>'4']);
                }

                $gstDetails = Restaurant::select('gst')->where('id',$rest_id)->orderBy('id','DESC')->first();
                $discount=0;

                if($request->applied_coupon!='')
                {
                    $coupon = Coupon::where(['restaurant_id'=>$rest_id,'enabled'=>1,'id'=>$request->applied_coupon])->first();
                    if($coupon)
                    {

                        if($coupon->coupon_type=='percentage'){
                            $p=$coupon->coupon_value;
                            $dis=(($subtotal*$p)/100);
                            if($coupon->max_discount!='')
                            {
                                if($dis <= $coupon->max_discount)
                                {
                                    $discount=$dis;
                                }
                                else{                                
                                    $discount = $coupon->max_discount;
                                }
                            }
                            else{
                                $discount=$dis;
                            }
                        }
                        else if($coupon->coupon_type=='fixed'){
                            $dis=$coupon->coupon_value;

                            if($dis >= $subtotal)
                            {
                                $discount=$subtotal;
                            }
                            else{
                                $discount=$dis;
                            }
                        }

                        $bill_discount_id = BillDiscount::create([
                            'bill_id' => $bill_id,
                            'restaurant_id' => $rest_id,
                            'mobile_no' => $mobile_no,
                            'coupon_id' => $coupon->id,
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_type' => $coupon->coupon_type,
                            'coupon_value' => $coupon->coupon_value,
                            'max_discount' => $coupon->max_discount,
                            'bill_discount' => $discount,
                            'description' => $coupon->description
                        ])->id;

                    }

                }

                if($gstDetails->gst)
                {

                    $taxAmt=0;
                    $totalTax=0;
                    if(count($taxes)>0)
                    {
                      foreach($taxes as $tax)
                      {
                        $taxAmt= ((($subtotal-$discount)*$tax->tax_value)/100);
                        BillTax::create([
                            'bill_id' => $bill_id,
                            'tax_id'=>$tax->id,
                            'tax_value'=>$tax->tax_value,
                            'tax_amount'=>$taxAmt
                        ]);
                        $totalTax+=$taxAmt;
                      }
                    }
                    else{
                        $totalTax=0;
                    }
                }
                else{
                  $totalTax=0;
                } 


                $total=($subtotal-$discount)+$totalTax;
                Billbook::where('id',$bill_id)->update(['sub_total'=>$subtotal,'discount'=>$discount,'tax'=>$totalTax,'total'=>$total,'mobile_no'=>$mobile_no]); 
                $billdetails=Billbook::where('id',$bill_id)->first();

                if($customer_notification)
                {

                    $customer=Customer::where(['mobile_no'=>$mobile_no])->first();

                    $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
                    if($customer->isd_code=='91')
                    {
                        $mobile_no=$customer->mobile_no;
                        $status=send_local_sms($mobile_no ,$template);
                    }
                    else
                    {   
                        $mobile_no = $customer->isd_code.$customer->mobile_no;
                        $status=send_isd_sms($mobile_no ,$template);
                    }

                    $mobile_no=$customer->isd_code.$customer->mobile_no;
                    $status=send_whatsapp_message($mobile_no ,$template);
                }

            }
        }
        $bill_taxes=DB::table('bill_taxes')
            ->LeftJoin('taxes', 'bill_taxes.tax_id', '=' ,'taxes.id')
            ->select('taxes.*','bill_taxes.*', 'bill_taxes.tax_value as tax_percentage')
            ->where('bill_taxes.bill_id', $bill_id)->orderBy('bill_taxes.id','ASC')->get();

        $discount_details=BillDiscount::where('bill_id',$bill_id)->first();

        // dd($bill_taxes);
        return view('admin.orders.orderconclude', compact('orders','order_items','order_id','taxes','bill_taxes','bill_id','billdetails','discount_details'));
    }

    public function tableorderconclude(Request $request, $tid){
      //  $rest_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $rest_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $rest_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($rest_id,$user_type,'table-order');

            if(isset($perms))
            {
                if($perms->create)
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
        $customer_notification= $request->customer_notification=='on'?1:0;

        $orders = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=' ,'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=' ,'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=' ,'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number')
            ->where('orders.restaurant_id', $rest_id)
            ->where('tables.id', $tid)
            ->where('order_items.deleted_at',null)
            ->where('order_items.order_status', '2')->orderBy('order_items.id','DESC')->get();

        $taxes=Tax::where(['restaurant_id'=>$rest_id,'enabled'=>1])->get();


        $subtotal=0;
        $bill_id='';
        $billdetails='';
        $mobile_no='';


        $billBook = Billbook::select('bill_number')->where('restaurant_id',$rest_id)->orderBy('id','DESC')->first();
        if($billBook){
          $bill_number = $billBook->bill_number+1;
        }
        else{
          $bill_number = 1;
        }
        // $order_id = 8;
        if(count($orders) > 0)
        {
            $bill_id = Billbook::create([
                            'bill_number' => $bill_number,
                            'order_id' => '',
                            'payment_id' => '',
                            'payment_mode' => 0,
                            'restaurant_id' => $rest_id,
                            'table_id' => $tid,
                            // 'mobile_no' => $order->mobile_no,
                            'mobile_no' => '',
                            'order_status' => '1',
                            'sub_total' => 0,
                            'discount' => 0,
                            'tax' => 0,
                            'total' => 0,
                            // 'created_by' => Auth::id()
                            'created_by' => 1
                        ])->id;

            foreach ($orders as $key => $item) {
                BillingOrderItem::create([
                    'billing_id'=>$bill_id,
                    'order_id'=>$item->order_id,
                    'item_id'=>$item->item_id,
                    'varient_id'=>''.$item->varient_id,
                    'quantity'=>$item->quantity,
                    'price'=>$item->price,
                    'order_status'=>$item->order_status,
                    // 'created_by' => 1
                ]);
                $subtotal+=($item->price)*($item->quantity );
                // Order::where('id',$item->order_id)->where('order_status','2')->update(['order_status'=>4]);
                Order::where('id',$item->order_id)->update(['order_status'=>'4']);
                OrderItem::where('item_id',$item->item_id)->where('order_status','2')->update(['order_status'=>'4']);
                $mobile_no=$item->mobile_no;
            }
        }

        if($bill_id!='')
        {

            $gstDetails = Restaurant::select('gst')->where('id',$rest_id)->orderBy('id','DESC')->first();
            $discount=0;

            if($request->applied_coupon!='')
            {
                $coupon = Coupon::where(['restaurant_id'=>$rest_id,'enabled'=>1,'id'=>$request->applied_coupon])->first();
                if($coupon)
                {

                    if($coupon->coupon_type=='percentage'){
                        $p=$coupon->coupon_value;
                        $dis=(($subtotal*$p)/100);
                        if($coupon->max_discount!='')
                        {
                            if($dis <= $coupon->max_discount)
                            {
                                $discount=$dis;
                            }
                            else{                                
                                $discount = $coupon->max_discount;
                            }
                        }
                        else{
                            $discount=$dis;
                        }
                    }
                    else if($coupon->coupon_type=='fixed'){
                        $dis=$coupon->coupon_value;

                        if($dis >= $subtotal)
                        {
                            $discount=$subtotal;
                        }
                        else{
                            $discount=$dis;
                        }
                    }


                    $bill_discount_id = BillDiscount::create([
                        'bill_id' => $bill_id,
                        'restaurant_id' => $rest_id,
                        'mobile_no' => $mobile_no,
                        'coupon_id' => $coupon->id,
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_type' => $coupon->coupon_type,
                        'coupon_value' => $coupon->coupon_value,
                        'max_discount' => $coupon->max_discount,
                        'bill_discount' => $discount,
                        'description' => $coupon->description
                    ])->id;

                }

            }

            if($gstDetails->gst)
            {

                $taxAmt=0;
                $totalTax=0;
                if(count($taxes)>0)
                {
                  foreach($taxes as $tax)
                  {
                    $taxAmt= ((($subtotal-$discount)*$tax->tax_value)/100);
                    BillTax::create([
                        'bill_id' => $bill_id,
                        'tax_id'=>$tax->id,
                        'tax_value'=>$tax->tax_value,
                        'tax_amount'=>$taxAmt
                    ]);
                    $totalTax+=$taxAmt;
                  }
                }
                else{
                  $totalTax=0;
                }
            }
            else{
              $totalTax=0;
            }


            $total=($subtotal-$discount)+$totalTax;
            Billbook::where('id',$bill_id)->update(['sub_total'=>$subtotal,'discount'=>$discount,'tax'=>$totalTax,'total'=>$total,'mobile_no'=>$mobile_no]); 
            $billdetails=Billbook::where('id',$bill_id)->first();

            if($customer_notification)
            {

                $customer=Customer::where(['mobile_no'=>$mobile_no])->first();
                
                $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
                if($customer->isd_code=='91')
                {
                    $mobile_no=$customer->mobile_no;
                    $status=send_local_sms($mobile_no ,$template);
                }
                else
                {   
                    $mobile_no = $customer->isd_code.$customer->mobile_no;
                    $status=send_isd_sms($mobile_no ,$template);
                }

                $mobile_no=$customer->isd_code.$customer->mobile_no;
                $status=send_whatsapp_message($mobile_no ,$template);
            }        
        }
        
        $bill_taxes=DB::table('bill_taxes')
            ->LeftJoin('taxes', 'bill_taxes.tax_id', '=' ,'taxes.id')
            ->select('taxes.*','bill_taxes.*', 'bill_taxes.tax_value as tax_percentage')
            ->where('bill_taxes.bill_id', $bill_id)->orderBy('bill_taxes.id','ASC')->get();

        // dd($bill_taxes);

        $discount_details=BillDiscount::where('bill_id',$bill_id)->first();

        // dd($bill_taxes);

        return view('admin.orders.tableorderconclude', compact('orders','tid','taxes','bill_taxes','bill_id','billdetails','discount_details'));
       // dd($orders);
    }



    public function sendbilldetails($receiverMobile, $bill_id)
    {
        // $data=json_decode($request->mob,true);
        // return response()->json($data);
        //http://smstech.techstreet.in/sms-panel/api/http/index.php?username=outdosolution&apikey=E50D9-FFA5D&apirequest=Text&sender=TSTMSG&mobile=9716440096&message=SMSMessage&route=TRANS&format=json

        //    $five_digit_otp = mt_rand(10000, 99999);


        $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
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
        return $status;
    }

    public function send_isd_sms($receiverMobile, $bill_id)
    {
        $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
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
        return $status;
    }

    public function send_whatsapp($receiverMobile, $bill_id)
    {
        // $data=json_decode($request->mob,true);
        // return response()->json($data);
        //http://smstech.techstreet.in/sms-panel/api/http/index.php?username=outdosolution&apikey=E50D9-FFA5D&apirequest=Text&sender=TSTMSG&mobile=9716440096&message=SMSMessage&route=TRANS&format=json

        //    $five_digit_otp = mt_rand(10000, 99999);


        $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
        $parameters = http_build_query([
         'channel' => 'whatsapp',
         // 'destination'=> '91'.$receiverMobile,
         'destination'=> $receiverMobile,
         'source' => '917834811114',
         'src.name'=> 'qrestroapi2',
         'message' => $template
        ]);

/*
        $parameters = json_encode([
         'channel' => 'whatsapp',
         'destination'=> '919716076512',
         'source' => '917834811114',
         'src.name'=> 'qrestroapp',
          // 'message' => json_encode(array( "isHSM" =>"false", "type" => "text", "text" => $template ))
         'message' => array( 
                              "isHSM" =>"false",
                              "type" => "text",
                              "text" => $template
                            )
        ]);
*/

        $url = "https://api.gupshup.io/sm/api/v1/msg";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        // curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
        // curl_setopt($ch, CURLOPT_HEADER, 0);
                                                                    
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);

        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

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
          $status = "success";
        }
        curl_close($ch);
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
        $order = Order::find($id);
        // $orderItems = OrderItem::where('order_id',$id)->get();

        return view('admin.orders.edit', compact('order','orderItems'));
    }  

    public function detail($id)
    {

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
            ->select('orders.*','restaurants.name','tables.table_name','order_items.*', 'items.item_name','items.item_type','items.short_description','varieties.name as variety_name','orders.order_id as order_number', 'order_statuses.name as order_status_name')
            ->where('order_items.deleted_at',null)
            ->where('orders.id', $order_id)->orderBy('order_items.id','DESC')->get();

        $check_kot =Order::where(['id'=>$order_id,'order_status'=>2])->first();

            
// dd($order_items);

		$billdetails= Billbook::where('order_id', $order_id)->first();

        // check the bill book with order id if exist then generate order button will not displayed. Pass a variable named $bill_generated = 1 (deative all the buttons) 

        $isBillGenerated=Billbook::where('order_id',$order_id)->orderBy('id','DESC')->first();
		// print_r($order_id);
        if($isBillGenerated)
        {
	    	$generate_bill=0;
        }

		$acceptedOrderItem=OrderItem::where('order_id',$order_id)->where('order_status','1')->first();
    $order_table= Order::where('id', $id)->first(['table_id']);
		if($acceptedOrderItem)
		{				
	    	$show_gen_btn=0;
		}
    else if($order_table)
    {
      if($order_table->table_id == '0')
      {
        $show_gen_btn=1;        
      } 
      else{
        $show_gen_btn=2;              
      }


    }

/* if all items are rejected then generate order button need to be disabled */		
/*		else{
			$isAcceptedOrderItem=OrderItem::where('order_id',$order_id)->where('order_status','2')->first();			
			if(!$$isAcceptedOrderItem)
			{				
		    	$show_gen_btn=0;
			}

		} */
    
            // ->where('order_items.order_status', '1')->orderBy('order_items.id','DESC')->paginate(10);

       // dd($order_items);

      //  $rest_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $rest_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $rest_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($rest_id,$user_type,'order');

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
            ->select('restaurants.name','order_items.*', 'items.item_name','varieties.name as variety_name','orders.order_id as order_number')
            ->where('orders.restaurant_id', $rest_id)
            ->where('orders.id', $id)
            ->where('order_items.deleted_at',null)
            ->where('order_items.order_status', '2')->orderBy('order_items.id','DESC')->get();

        $coupons = Coupon::where(['restaurant_id'=>$rest_id,'enabled'=>1])->get();
        $taxes=Tax::where(['restaurant_id'=>$rest_id,'enabled'=>1])->get();

       // dd($orders);

        return view('admin.orders.detail', compact('orders','taxes','coupons','order_items','check_kot','order_id','show_gen_btn','generate_bill','isBillGenerated','billdetails'));

    }  

  	public function neworder_update_status(Request $request){
			
		$status =$request->status;
		$order_id = $request->order_id;
		$item_id = $request->item_id;
        $varient_id = $request->varient_id;
        //$res_id = Auth::guard('restaurant')->id();
    
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
        
		if($varient_id!='')
		{
        OrderItem::where('order_id',$order_id)->where('item_id',$item_id)->where('varient_id',$varient_id)->update(['order_status'=>$status]);
        if($status == 3 && $status != ""){

          //  $rejectItem=OrderItem::where('order_id',$order_id)->where('order_status','3')->where('varient_id',$varient_id)->where('item_id',$item_id)->first();
          //  $taxes=Tax::where(['restaurant_id'=>$res_id,'enabled'=>1])->first();
          //    $order=Order::where('id',$order_id)->where('order_status',2)->first();
                  
          //    if(!empty($rejectItem)){
          //        $item_price = $rejectItem->price;
          //        $tax_item = (100 * (int)$taxes->tax_value) / $item_price;
          //        $tot = $item_price + $tax_item;
          //        $all_tax =  $order->tax - $tax_item;
          //        $all_price =   $order->sub_total - $item_price;
          //        $all_total =   $order->total - $tot;
          //       Order::where('id',$order_id)->update(['sub_total'=>$all_price,'tax'=>$all_tax,'total'=>$all_total]);
          //       }



        }
		}
		else{
        OrderItem::where('order_id',$order_id)->where('item_id',$item_id)->update(['order_status'=>$status]);
        if($status == 3 && $status != ""){

          //  $rejectItem=OrderItem::where('order_id',$order_id)->where('item_id',$item_id)->where('order_status','3')->first();
          //  $taxes=Tax::where(['restaurant_id'=>$res_id,'enabled'=>1])->first();
          //  $order=Order::where('id',$order_id)->where('order_status',2)->first();
           
          //  if(!empty($rejectItem)){
          //  $item_price = $rejectItem->price;
          //   $tax_item = (100 * (int)$taxes->tax_value) / $item_price;
          //   $tot = $item_price + $tax_item;
          //   $all_tax =  $order->tax - $tax_item;
          //   $all_price =   $order->sub_total - $item_price;
          //   $all_total =   $order->total - $tot;
          //  Order::where('id',$order_id)->update(['sub_total'=>$all_price,'tax'=>$all_tax,'total'=>$all_total]);
          //  }

        }
		}
    	if($status=='2')
    	{
			// Order::where('id',$order_id)->update(['order_status'=>$status]);
    	}
    	else if($status=='3')
    	{
        
    		$acceptedOrderItem=OrderItem::where('order_id',$order_id)->where('order_status','2')->first();
		  	if($acceptedOrderItem)
			{				        
		    	// Order::where('id',$order_id)->update(['order_status'=>'2']);
			}
    	}

        $allItemNotAccepted=OrderItem::where('order_id',$order_id)->where('order_status','<>', '2')->first();

        if(!$allItemNotAccepted)
        {

            Order::where('id',$order_id)->update(['order_status'=>'2']);
            $order = Order::where('id',$order_id)->first();

            $customer=Customer::where(['mobile_no'=>$order->mobile_no])->first();

            $template = "Your Order has been accepted.";
            
            if($customer->isd_code=='91')
            {

                $status=send_local_sms($customer->mobile_no ,$template);
            }
            else{   
                $mobile_no = $customer->isd_code.$customer->mobile_no;
                send_isd_sms($mobile_no ,$template);
            }
            $mobile_no=$customer->isd_code.$customer->mobile_no;
            $status=send_whatsapp_message($mobile_no ,$template);

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

            if($status=='2')
            {
                $order = Order::where('id',$order_id)->first();


                $customer=Customer::where(['mobile_no'=>$order->mobile_no])->first();
    
                $template = "Your Order has been accepted.";
                
                if($customer->isd_code=='91')
                {

                    $status=send_local_sms($customer->mobile_no ,$template);
                }
                else{   
                    $mobile_no = $customer->isd_code.$customer->mobile_no;
                    send_isd_sms($mobile_no ,$template);
                }
                $mobile_no=$customer->isd_code.$customer->mobile_no;
                $status=send_whatsapp_message($mobile_no ,$template);
            }
		}

	    $result = array('status' => 'success','res' => $resdiv);
	    return response()->json($result);

	}

  	public function generate_bill (Request $request){

	    $subtotal=0;
	    $bill_id='';
      $billdetails='';
      $mobile_no='';


		$status =$request->status;
		$order_id = $request->order_id;
		// $order_id = 8;
		if($order_id)
		{

	    	$order= Order::where('id',$order_id)->first();
		    $billBook = Billbook::select('bill_number')->where('restaurant_id',$order->restaurant_id)->orderBy('id','DESC')->first();
        $taxes = Tax::where('restaurant_id',$order->restaurant_id)->get();
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
                  'order_status'=>$item->order_status
	                    // 'created_by' => 1
		          	]);
		          	$subtotal+=($item->price)*($item->quantity );
                Order::where('id',$item->order_id)->update(['order_status'=>'4']);
                OrderItem::where('item_id',$item->item_id)->where('order_status','2')->update(['order_status'=>'4']);
                $mobile_no=$item->mobile_no;

		        }
			     


          $gstDetails = Restaurant::select('gst')->where('id',$order->restaurant_id)->orderBy('id','DESC')->first();
          if($gstDetails->gst)
          {

              $taxAmt=0;
              $totalTax=0;
              if(count($taxes)>0){                      
                foreach($taxes as $tax)
                {
                  $taxAmt= (($subtotal*$tax->tax_value)/100);
                  $totalTax+=$taxAmt;
                  // OrderTax::create([
                  //   'order_id'=>$order_id,
                  //   'tax_id'=>$tax->id,
                  //   'tax_value'=>$tax->tax_value,
                  //   'tax_amount'=>$taxAmt
                  // ]);
                }
              }
              else{
                $totalTax=0;
              }
          }
          else{
            $totalTax=0;
          }

          $total=$subtotal+$totalTax;
          Billbook::where('id',$bill_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total,'mobile_no'=>$order->mobile_no]); 

            $customer=Customer::where(['mobile_no'=>$order->mobile_no])->first();

            if($customer->isd_code=='91')
            {
                $this->sendbilldetails($customer->mobile_no,$bill_id);                
            }
            else{   
                $mobile_no = $customer->isd_code.$customer->mobile_no;
                $this->send_isd_sms($mobile_no,$bill_id);                
            }

            $mobile_no=$customer->isd_code.$customer->mobile_no;

            $this->send_whatsapp($mobile_no,$bill_id);

			}
		}

				// dd($acceptedOrderItems);
	    $result = array('status' => 'success','res' => $bill_id);
	    return response()->json($result);

    }
    

    public function get_neworder(Request $request)
    {
    
       // $rest_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $rest_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
           $manager = Auth::guard('manager')->user();
           $rest_id=$manager->restaurant_id;
        }
        else{
            return redirect('admin');
        }
        
        if($request->update_status == 'read')
        {
            $order_id =$request->order_id;
            $order_details =Order::where('orders.id',$order_id)->update(['view_status'=>1]);
            // $result['data'] = $order_details;
            $result['status']='success'; 
            return response()->json($result);
        }
        else{
            
            $order_id =$request->order_id;
            
            $order_details = DB::table('orders')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'orders.restaurant_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=' ,'orders.order_status')
            ->LeftJoin('tables', 'tables.id', '=' ,'orders.table_id')
            ->select('orders.*','restaurants.name','order_statuses.name as orderstatus','tables.table_name as table_name','orders.name as customer_name')
            ->where('orders.id','>', $order_id)
            ->where('orders.restaurant_id', $rest_id)->orderBy('orders.id','DESC')->get();


            // $order_details =Order::where('orders.id','>',$order_id)->where('orders.restaurant_id',$rest_id)->orderBy('id','DESC')->get();
            if (count($order_details) > 0)
            {
                $data = $order_details->toArray();
                foreach ($data as $key => $value) {
                    
                    $value->created_at=date("d-M-Y", strtotime($value->created_at));
                    if(isset($value->table_name) && $value->table_name!='')
                    {}
                    else{                        
                    $value->table_name = 'Restaurant';
                    }

                }


                $result['data'] = $data;
                $result['status']='success'; 
            } 
            else 
            {
                $result['data']=array();
                $result['status']='fail'; 
            }
            return response()->json($result);

        }
    
    }


    public function updateItemQty(Request $request){
     
        $item_id=$request->item_id;
        $item_name =$request->item_name;
        $item_orderid=$request->item_orderid;
        $price =$request->item_price;
        $qty=(int)$request->item_qty;
        $order_id=$request->order_id;
        $data=$request->all();
        $action =$request->action; 
        $order_status=$request->order_status;
        
        if($action =="plus"){

         OrderItem::where(['id'=>$item_orderid,'order_id'=>$order_id])->delete();
         $updated=OrderItem::create(['order_id'=>$order_id,'item_id'=>$item_id,'quantity'=>$qty,'price'=>$price,'order_status'=>$order_status]);
         if($updated){
           $OrderItem =OrderItem::where('order_id',$order_id)->get();
           $res_id=Order::where('id',$order_id)->first();
           $tax =Tax::where('restaurant_id',$res_id->restaurant_id)->where('enabled',1)->get();
           $subtotal=0.00;
          foreach($OrderItem as $val){
            $subtotal+=$val->quantity*$val->price;
          }
          $taxAmt=0;
          $totalTax=0;
          if(count($tax)){
            foreach($tax as $val)
            {
              $taxAmt= (($subtotal*$val->tax_value)/100);
              $totalTax+=$taxAmt; 
            }
          }
          
          $total = $subtotal+$totalTax;
          Order::where('id',$order_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total]);

         }
        }else{
         // if($qty > 0){
            OrderItem::where(['id'=>$item_orderid,'order_id'=>$order_id])->delete();
            $updated=OrderItem::create(['order_id'=>$order_id,'item_id'=>$item_id,'quantity'=>$qty,'price'=>$price,'order_status'=>$order_status]);
           // $updated = OrderItem::where(['id'=>$item_orderid,'order_id'=>$order_id])->update(['quantity'=>$qty]);
            if($updated){
                $OrderItem =OrderItem::where('order_id',$order_id)->get();
                $res_id=Order::where('id',$order_id)->first();
                $tax =Tax::where('restaurant_id',$res_id->restaurant_id)->where('enabled',1)->get();
                $subtotal=0.00;
               foreach($OrderItem as $val){
                 $subtotal+=$val->quantity*$val->price;
               }
               $taxAmt=0;
               $totalTax=0;
               if(count($tax)){
                 foreach($tax as $val)
                 {
                   $taxAmt= (($subtotal*$val->tax_value)/100);
                   $totalTax+=$taxAmt; 
                 }
               }
               
               $total = $subtotal+$totalTax;
               Order::where('id',$order_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total]);
              }

            // }else{
            //   // $updated= OrderItem::where(['id'=>$item_orderid,'order_id'=>$order_id])->update(['quantity'=>$qty]);
            //   OrderItem::where(['id'=>$item_orderid,'order_id'=>$order_id])->delete();
            //   $updated=OrderItem::create(['order_id'=>$order_id,'item_id'=>$item_id,'quantity'=>$qty,'price'=>$price,'order_status'=>$order_status]);
            //   if($updated){
            //     $OrderItem =OrderItem::where('order_id',$order_id)->get();
            //     $res_id=Order::where('id',$order_id)->first();
            //     $tax =Tax::where('restaurant_id',$res_id->restaurant_id)->where('enabled',1)->get();
            //     $subtotal=0.00;
            //    foreach($OrderItem as $val){
            //      $subtotal+=$val->quantity*$val->price;
            //    }
            //    $taxAmt=0;
            //    $totalTax=0;
            //    if(count($tax)){
            //      foreach($tax as $val)
            //      {
            //        $taxAmt= (($subtotal*$val->tax_value)/100);
            //        $totalTax+=$taxAmt; 
            //      }
            //    }
               
            //    $total = $subtotal+$totalTax;
            //    Order::where('id',$order_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total]);
            //   }
            // }
           
        }
        if($updated){
            $status="success";
        }else{
            $status="error";
        }
        return response()->json(array('status'=>$status));
    }


    public function addMoreToOrder($id,$type,$tab){
     $order_id =$id;
     $order_type=$type;
     
      return view('admin.orders.add-more-item',compact('order_id','order_type','tab'));

    }

    public function searchItem(Request $request){
        $val =$request->keyword;
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
         $result =Item::where('restaurant_id',$res_id)->where('enabled',1)->where('item_name', 'like', '%'.$val.'%')->take(6)->get();
         ?>
        <ul id="item-list">
        <?php
        foreach($result as $val) {
            if(!empty($val->discount_price)){
                $price =$val->discount_price;
            }else{
                $price =$val->item_price;
            }
        ?>
        <li onClick="selectItem('<?php echo $val->item_name; ?>','<?php echo $val->id; ?>','<?php echo $price; ?>');"><?php echo $val->item_name; ?></li>
        <?php } ?>
        </ul>
<?php
        
    }


  public function addItemToOrder(Request $request,$id,$type,$tab){
    $this->validate($request, [
        'item_name' => 'required',
        'qty' => 'required',
        'price' => 'required',
    ]);

    if($type == 'new'){
    $order_status=Order::where('id',$id)->first();
    $order_id=$id;
    $item_qty =$request->qty;
    if(count($item_qty) > 0){
        $name=$request->item_name;
        $price=$request->price;
        $qty=$request->qty;
        $item_id=$request->item_id;
       $arr=array();
      for($i=0;$i<count($qty);$i++){
         $arr=[
           "order_id"=>$order_id,
           "item_id"=>$item_id[$i],
           "quantity"=>$qty[$i],
           "price"=>$price[$i],
           "order_status"=>$order_status->order_status
         ];
         OrderItem::create($arr);
      }

      $OrderItem =OrderItem::where('order_id',$order_id)->get();
      $res_id=Order::where('id',$order_id)->first();
      $tax =Tax::where('restaurant_id',$res_id->restaurant_id)->where('enabled',1)->get();
      $subtotal=0.00;
      foreach($OrderItem as $val){
      $subtotal+=$val->quantity*$val->price;
      }
      $taxAmt=0;
      $totalTax=0;
               if(count($tax)){
                 foreach($tax as $val)
                 {
                   $taxAmt= (($subtotal*$val->tax_value)/100);
                   $totalTax+=$taxAmt; 
                 }
               }
               
      $total = $subtotal+$totalTax;
      Order::where('id',$order_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total]);
      return redirect('order/'.$order_id.'/detail')->with('success', 'item added successfully');
    }else{
        return redirect()->back()->with('error', 'no item found');
    }

}else{
    $order_status=Order::where('id',$id)->first();
    $order_id=$id;
    $item_qty =$request->qty;
    if(count($item_qty) > 0){
        $name=$request->item_name;
        $price=$request->price;
        $qty=$request->qty;
        $item_id=$request->item_id;
       $arr=array();
      for($i=0;$i<count($qty);$i++){
         $arr=[
           "order_id"=>$order_id,
           "item_id"=>$item_id[$i],
           "quantity"=>$qty[$i],
           "price"=>$price[$i],
           "order_status"=>$order_status->order_status
         ];
         OrderItem::create($arr);
      }

      $OrderItem =OrderItem::where('order_id',$order_id)->get();
      $res_id=Order::where('id',$order_id)->first();
      $tax =Tax::where('restaurant_id',$res_id->restaurant_id)->where('enabled',1)->get();
      $subtotal=0.00;
      foreach($OrderItem as $val){
      $subtotal+=$val->quantity*$val->price;
      }
      $taxAmt=0;
      $totalTax=0;
               if(count($tax)){
                 foreach($tax as $val)
                 {
                   $taxAmt= (($subtotal*$val->tax_value)/100);
                   $totalTax+=$taxAmt; 
                 }
               }
               
      $total = $subtotal+$totalTax;
      Order::where('id',$order_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total]);
      return redirect('table-order/'.$tab);
    }else{
        return redirect()->back()->with('error', 'no item found');
    }
}
  }

  

}
