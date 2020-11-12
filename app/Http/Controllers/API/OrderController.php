<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Order;
use App\OrderItem;
use App\Cart;
use App\Address;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function myOrders(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
            "user_id" => "required"
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $orders = Order::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
                if($orders){
                    if($orders->count() > 0){
                        foreach ($orders as $value) {
                            $value->order_date = date_dfy($value->created_at);
                            $order_items = OrderItem::where('order_id',$value->id)
                            ->join('items', 'items.id', 'order_items.item_id')
                            ->select('items.item_id','items.item_name as product_name','items.image as product_image')
                            ->get();
    
                            $count = count($order_items);
                            if($count > 1){
                                $more = $count-1;
                                $value->title = $order_items[0]->product_name . ' & '. $more . ' more';
                                //$value->image = url('public/assets/images/item-images/'.$order_items[0]->product_image);
                                $value->image = url('public/uploads/product-images/'.$order_items[0]->item_id.'.jpg');
                            }
                            if($count == 1){
                                $more = $count-1;
                                $value->title = $order_items[0]->product_name;
                                //$value->image = url('public/assets/images/item-images/'.$order_items[0]->product_image);
                                $value->image = url('public/uploads/product-images/'.$order_items[0]->item_id.'.jpg');
                            }
                        }
                        $this->response = $orders;  
                    }
                    else{
                        $this->error_code = -101;
                    }
                } else {
                    $this->error_code = -101;
                }
            } else {
                $this->error_code = -108;
            }
        } catch (\Exception $e) {
            $this->error_code = -500;
            if ($request->debug == true) {
                $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
            }
        }
        // Store result in an array
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        // Return response
        return response()->json($result);
    }
    public function orderDetails(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $order_id = $request->order_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "order_id" => "required"
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $order = Order::where('user_id',$user_id)
                ->select('orders.*','payment_modes.name as payment_mode','order_statuses.name as order_status')
                ->where('orders.id',$order_id)
                ->join('payment_modes','payment_modes.id','orders.payment_id')
                ->join('order_statuses','order_statuses.id','orders.order_status')
                ->first();
                if($order){
                    $order_items = OrderItem::where('order_id',$order->id)
                        ->join('items', 'items.id', 'items.item_id', 'order_items.item_id')
                        ->select('order_items.quantity','order_items.price','items.item_name as product_name','items.image as product_image')
                        ->get();
                    foreach ($order_items as $value) {
                        //$value->product_image = url('public/assets/images/item-images/'.$value->product_image);
                        $value->product_image = url('public/uploads/product-images/'.$value->item_id.'.jpg');
                    }
                    $order->order_date = date_dfy($order->created_at);
                    $order->items = $order_items;
                    $this->response = $order;  
                } else {
                    $this->error_code = -101;
                }
            } else {
                $this->error_code = -108;
            }
        } catch (\Exception $e) {
            $this->error_code = -500;
            if ($request->debug == true) {
                $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
            }
        }
        // Store result in an array
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        // Return response
        return response()->json($result);
    }
    public function placeOrder(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $instruction = $request->instruction;
        // Add rules
        $rules = [
            "user_id" => "required",
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $order_id = 10000001;
                $order_type = '1';
                $order_status = '1';
                $payment_id = '5';
                $sub_total = 0;
                $order = Order::first();
                if($order){
                    $last_order_id = Order::orderBy('id', 'desc')->first()->order_id;
                    //$order_id = $last_order_id+1;
                    $order_id = substr(md5(mt_rand()), 0, 8);
                }
                $cart_items = Cart::where('user_id',$user_id)
                ->select('carts.*', 'items.item_price as rate')
                ->join('items','items.id','carts.product_id')
                ->get();
                if($cart_items){
                    foreach ($cart_items as $cart_item){
                        $sub_total = $sub_total + ($cart_item->quantity * $cart_item->rate);
                    }
                    if($request->time){
                        $delivery_fee = 0;
                    }
                    else{
                        $delivery_fee = getDeliveryFee($sub_total);
                    }
                    $total = $sub_total + $delivery_fee;
                    $shipment = Address::where('user_id',$user_id)->where('is_default','1')->first();
                    $mobile_no = $shipment->mobile_number;
                    $name = $shipment->name;
                    if($shipment->landmark){
                        $address = $shipment->address. ', ' .$shipment->landmark . ', ' .$shipment->city . ', ' .$shipment->state . ', Pincode: ' .$shipment->city ;
                    }
                    else{
                        $address = $shipment->address . ', ' .$shipment->city . ', ' .$shipment->state . ', Pincode: ' .$shipment->city ;
                    }

                    if($request->time){
                        $address = "Take away - Customer Name: ".$request->name.", ".$request->date.", ".$request->time;
                    }

                    $order_id_item = Order::create(['order_id'=>$order_id,'restaurant_id'=>'35','table_id'=>'0','user_id'=>$user_id,'payment_id'=>$payment_id,'mobile_no'=>$mobile_no,
                    'name'=>$name,'address'=>$address,'instruction'=>$instruction,'order_type'=>$order_type,'order_status'=>$order_status,'delivery_fee'=>$delivery_fee,
                    'sub_total'=>$sub_total,'total'=>$total])->id;

                    foreach ($cart_items as $cart_item){
                        OrderItem::create(['order_id'=>$order_id_item,'item_id'=>$cart_item->product_id,'quantity'=>$cart_item->quantity,
                        'price'=>$cart_item->rate,'order_status'=>'1']);
                    }

                    Cart::where('user_id',$user_id)->delete();
                    $this->response = array('order_id' => $order_id_item);
                }
                else{
                    $this->error_code = -100;
                }

            } else {
                $this->error_code = -108;
            }
        } catch (\Exception $e) {
            $this->error_code = -500;
            if ($request->debug == true) {
                $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
            }
        }
        // Store result in an array
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        // Return response
        return response()->json($result);
    }
}
