<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderStatus;
use App\TransactionDetail;
use Auth;
use DB;
use Carbon\Carbon;

class ReportController extends Controller
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
            $perms=get_admin_module_permission($id,$user_type,'report');

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


        $status = OrderStatus::get();
        if ($request->search) {
           
            $from_date = Carbon::parse($request->from_date)->startOfDay();
            $to_date = Carbon::parse($request->to_date)->endOfDay();

            $data = Order::query();
            $data = $data->LeftJoin('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
                ->LeftJoin('order_statuses', 'order_statuses.id', '=', 'orders.order_status')
                ->LeftJoin('tables', 'tables.id', '=', 'orders.table_id')
                ->select('orders.*', 'restaurants.name', 'order_statuses.name as orderstatus', 'tables.table_name as table_name', 'orders.name as customer_name')
                ->where('orders.restaurant_id', $id)
                ->whereBetween('orders.created_at', [$from_date, $to_date]);
            if (!empty($request->status)) {     
                if ($request->status != 'blank') {  
                $data->where('orders.order_status', $request->status);
                }
            }
            $order = $data->orderBy('orders.id', 'DESC')->paginate(10);
           // dd($order);
        } else {

            $order = DB::table('orders')
                ->LeftJoin('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
                ->LeftJoin('order_statuses', 'order_statuses.id', '=', 'orders.order_status')
                ->LeftJoin('tables', 'tables.id', '=', 'orders.table_id')
                ->select('orders.*', 'restaurants.name', 'order_statuses.name as orderstatus', 'tables.table_name as table_name', 'orders.name as customer_name')
                ->where('orders.restaurant_id', $id)->orderBy('orders.id', 'DESC')->paginate(10);
        }
        return view('admin.order-report.index', compact('order', 'status'));
    }


    public function orderDetail($id)
    {
        $order_id = $id;
        $order_items = DB::table('order_items')
            ->LeftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->LeftJoin('items', 'items.id', '=', 'order_items.item_id')
            ->LeftJoin('varieties', 'varieties.id', '=', 'order_items.varient_id')
            ->LeftJoin('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
            ->LeftJoin('tables', 'tables.id', '=', 'orders.table_id')
            ->LeftJoin('order_statuses', 'order_statuses.id', '=', 'order_items.order_status')
            ->select('orders.*', 'restaurants.name', 'tables.table_name', 'order_items.*', 'items.item_name', 'varieties.name as variety_name', 'orders.order_id as order_number', 'order_statuses.name as order_status_name')
            ->where('orders.id', $order_id)->orderBy('order_items.id', 'DESC')->paginate(10);

        return view('admin.order-report.order-detail', compact('order_items'));
    }


    public function customerReport(Request $request)
    {

        //$res_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'report');
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
        $status = OrderStatus::get();
        if($request->search) {
            $from_date = Carbon::parse($request->from_date)->startOfDay();
            $to_date = Carbon::parse($request->to_date)->endOfDay();

            $data = Order::query();
            $data = $data->Join('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
                 ->Join('order_statuses', 'order_statuses.id', '=', 'orders.order_status')
                ->select('orders.*', 'restaurants.name','order_statuses.name as orderstatus','orders.name as customer_name')
                ->where('orders.restaurant_id', $res_id)
                ->whereNotNull('orders.name')
                ->whereNotNull('orders.address')
                ->whereNotNull('orders.mobile_no')
                ->whereBetween('orders.created_at', [$from_date, $to_date]);
                if (!empty($request->status)) {
                    if ($request->status != 'blank') {  
                 $data->where('orders.order_status', $request->status);
                    }
                 }
                 $customers = $data->orderBy('orders.id', 'DESC')->paginate(10);
        } else {


            $customers = Order::Join('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
                ->Join('order_statuses', 'order_statuses.id', '=', 'orders.order_status')
                ->select('orders.*', 'restaurants.name','order_statuses.name as orderstatus','orders.name as customer_name')
                ->where('orders.restaurant_id', $res_id)
                ->whereNotNull('orders.name')
                ->whereNotNull('orders.address')
                ->whereNotNull('orders.mobile_no')
                ->orderBy('orders.id', 'DESC')
                ->paginate(10);
               
        }

        return view('admin.customer-report.index', compact('customers', 'status'));
    }



    public function paymentReport(Request $request)
    {
      //  dd($request->all());
        //$res_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'report');

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
        //$mode = OrderStatus::get();
        if($request->search) {
            $from_date = Carbon::parse($request->from_date)->startOfDay();
            $to_date = Carbon::parse($request->to_date)->endOfDay();

            $data = TransactionDetail::query();
            $data = $data->Join('restaurants', 'restaurants.id', '=', 'transaction_details.restaurant_id')
                ->select('transaction_details.*', 'restaurants.name')
                ->where('transaction_details.restaurant_id', $res_id)
                // ->whereNotNull('orders.name')
                // ->whereNotNull('orders.address')
                // ->whereNotNull('orders.mobile_no')
                ->whereBetween('transaction_details.created_at', [$from_date, $to_date]);
                if (!empty($request->mode)) {
                    if ($request->mode != 'blank') {  
                 $data->where('transaction_details.payment_mode', $request->mode);
                    }
                 }
                 $payments = $data->orderBy('transaction_details.id', 'DESC')->paginate(10);
        } else {


            $payments = TransactionDetail::Join('restaurants', 'restaurants.id', '=', 'transaction_details.restaurant_id')
                ->select('transaction_details.*', 'restaurants.name')
                ->where('transaction_details.restaurant_id', $res_id)
                // ->whereNotNull('orders.name')
                // ->whereNotNull('orders.address')
                // ->whereNotNull('orders.mobile_no')
                ->orderBy('transaction_details.id', 'DESC')
                ->paginate(10);
               
        }

        return view('admin.payment-report.index', compact('payments'));
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
