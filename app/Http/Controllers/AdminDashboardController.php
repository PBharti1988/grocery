<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Item;
use App\Qrcode;
use App\Feedback;
use App\Currency;
use App\Order;
use App\Restaurant;
use App\Manager;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::guard('restaurant')->id() || Auth::guard('manager')->id()){
           
            if(Auth::guard('restaurant')->id()){
            $id= Auth::guard('restaurant')->id();
           
            }
            else{
               $manager_id = Auth::guard('manager')->id();
               $res_id=Manager::find($manager_id);
               $id=$res_id->restaurant_id;
            }
         // $id= Auth::guard('restaurant')->id();
          $lang =Restaurant::find($id);
          session(['locale'=>$lang->language]);
          
          $resturant_qr =QrCode::where('restaurant_id',$id)->first();  
          $counter =QrCode::where('restaurant_id',$id)->sum('counter');        

          $resturant =Restaurant::where('id',$id)->first();             
          $currency =Currency::where('code',$resturant->currency)->first('symbol');

          if(!empty($currency)){
              $symbol =$currency->symbol;
          }else{
            $symbol = "";
          }

          $orderPlaced =Order::where('restaurant_id',$id)->count(); 
          $orderAccept =Order::where('restaurant_id',$id)->whereNotIn('order_status',[1,2,3])->count();
          $lastTenOrder = Order::select('orders.*','order_statuses.name as status')
          ->join('order_statuses','order_statuses.id','orders.order_status')  
          ->where('restaurant_id',$id)
          ->orderBy('id','DESC')->take(10)->get(); 

          $lastFeed =Feedback::where('restaurant_id',$id) ->orderBy('id','DESC')->take(5)->get();

          $totalItems =Item::where(['restaurant_id'=>$id])->count();
          
          $activeItem =Item::where(['restaurant_id'=>$id,'enabled'=>1])->count();
         // dd($orderAccept);
         // $today =Order::where('restaurant_id',$id)
         $today =Order::where('restaurant_id',$id)->whereDate('created_at', Carbon::today())->count(); 
         //$weekly =Order::where('restaurant_id',$id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();    
         $weekly =Order::where('restaurant_id',$id)->whereDate('created_at','>',Carbon::today()->subDays(7))
         ->count(); 
         $monthly =Order::where('restaurant_id',$id)->whereMonth('created_at', date('m'))
         ->whereYear('created_at', date('Y'))->count();  

         $monthly_amt =Order::where('restaurant_id',$id)->whereMonth('created_at', date('m'))
         ->whereYear('created_at', date('Y'))->sum('total'); 
         
         $weekly_amt =Order::where('restaurant_id',$id)->whereDate('created_at','>',Carbon::today()->subDays(7))->sum('total');
         $today_amt =Order::where('restaurant_id',$id)->whereDate('created_at', Carbon::today())->sum('total'); 
  
          return view('admin.home',compact('resturant_qr','resturant','orderAccept','totalItems','activeItem','lastFeed','lastTenOrder','today','weekly','monthly','monthly_amt','weekly_amt','today_amt','currency','symbol','counter','orderPlaced'));
        }
        else if(isset($request->webview_user)){
          if (Auth::guard('restaurant')->loginUsingId($request->webview_user)) {
            return redirect('/admin');
          }
          if (Auth::guard('manager')->loginUsingId($request->webview_user)) {
            return redirect('/admin');
          }
        }
        else{
            return view('admin.login');
        }
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

    public function takeAwayAction(Request $request)
    {
    
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

        $action = $request->action;
    
        $update = Restaurant::where('id',$id)->update(['take_away' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }


    public function deliveryAction(Request $request)
    {
    
       // $id= Auth::guard('restaurant')->id();
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
        $action = $request->action;
    
        $update = Restaurant::where('id',$id)->update(['home_delivery' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }



    public function orderAcceptingAction(Request $request)
    {
    
      //  $id= Auth::guard('restaurant')->id();
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

        $action = $request->action;
    
        $update = Restaurant::where('id',$id)->update(['order_accepting' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }


}
