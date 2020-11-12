<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Cart;
use App\Address;
use App\Item;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function index(Request $request)
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
                $cart = Cart::where('user_id',$user_id)
                ->select('items.id','items.item_id','items.image','items.item_name as product_name','carts.id as cart_id','carts.quantity','carts.rate','carts.amount')
                ->join('items', 'carts.product_id', '=', 'items.id')
                ->get();
                $cart2 = Cart::where('user_id',$user_id)
                ->select('items.item_id','items.item_name')
                ->join('items', 'carts.product_id', '=', 'items.id')
                ->get();
                if($cart->count() > 0){
                    $total_price = 0;
                    foreach($cart as $value){
                        //$value->product_image = url('public/assets/images/item-images/'.$value->image);
                        $value->product_image = url('public/uploads/product-images/'.$value->item_id.'.jpg');
                        $total_price = $total_price+$value->amount;
                    }
                    $this->response['total_price'] = $total_price; 
                    $this->response['items'] = $cart;
                    $this->response['cart'] = $cart2;  
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
    public function badge(Request $request)
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
                $cart = Cart::where('user_id',$user_id)->groupBy('product_id')->get();
                if($cart){
                    $this->response = $cart->count();  
                } else {
                    $this->response = 0;
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
    public function add(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "product_id" => "required",
            "quantity" => "required|integer",
            "rate" => "required",
            "amount" => "required",
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
                if($request->quantity > 0){
                    $res = Cart::updateOrCreate(
                        ['user_id' => $request->user_id,'product_id' => $request->product_id],
                        ['quantity' => $request->quantity,'rate'=>$request->rate,'amount'=>$request->quantity*$request->rate]
                    );
                    $cart = Cart::where('user_id',$request->user_id)->groupBy('product_id')->get();
                    $count = $cart->count();
                    $this->response = array('count'=>$count);
                }
                else{
                    $res = Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->delete();
                    $cart = Cart::where('user_id',$request->user_id)->groupBy('product_id')->get();
                    $count = $cart->count();
                    $this->response = array('count'=>$count);
                }
                
                if ($res) {
                    $this->error_code = 0;
                } else {
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
    public function destroy(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $cart_id = $request->cart_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "cart_id" => "required",
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
                $cart = Cart::where('id',$cart_id)->delete();
                if ($cart) {
                    $this->error_code = 0;
                } else {
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
    public function empty(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
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
                $cart = Cart::where('user_id',$user_id)->get();
                if($cart->count() > 0){
                    $res = Cart::where('user_id',$user_id)->delete();
                    if ($res) {
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -100;
                    }
                }
                else{
                    $this->error_code = 0;
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
    public function checkout(Request $request)
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
                $subtotal = 0;
                $address = Address::where('user_id', $user_id)->where('is_default', '1')->first();
                $cart = Cart::where('user_id',$user_id)->get();
                if($cart->count() > 0){
                    foreach($cart as $value){
                        $subtotal = $subtotal+$value->amount;
                    }
                    $product_id = $cart[0]->product_id;
                    $item = Item::where('id',$product_id)->select('id','restaurant_id')->first();
                    $this->response['restaurant_id'] = $item->restaurant_id;
                }
                $this->response['subtotal'] = $subtotal;
                $this->response['delivery_fee'] = getDeliveryFee($subtotal);
                $this->response['total'] = $subtotal+getDeliveryFee($subtotal);
                $this->response['address'] = null;
                if($address){
                    if($address->landmark){
                        $this->response['address'] = $address->address. ', '.$address->landmark.', '.$address->city.', '.$address->state.', PIN Code: '.$address->pincode;
                    }
                    else{
                        $this->response['address'] = $address->address. ', '.$address->city.', '.$address->state.', PIN Code: '.$address->pincode;
                    }
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
