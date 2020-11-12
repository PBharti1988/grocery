<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\ShoppingList;
use App\Product;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ShoppingListController extends Controller
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
                // $shopping_lists = ShoppingList::join('products', 'products.id', '=', 'shopping_lists.product_id')
                //         ->select('shopping_lists.id', 'shopping_lists.user_id', 'shopping_lists.product_id', 'products.product_name', 'products.product_image', 'shopping_lists.quantity', 'shopping_lists.created_at')
                //         ->get();
                $shopping_lists = ShoppingList::where('user_id',$user_id)->where('quantity','>',0)->get();
                foreach($shopping_lists as $key => $value){
                    $product_id = $value->product_id;
                    if($product_id){;
                        $product = Product::select('items.*','shelves.shelf_number','shelves.shelf_image')
                        ->where('items.id',$product_id)
                        ->join('shelves', 'shelves.id', '=', 'items.shelf_id')
                        ->first();
                        $value->product_name = $product->item_name;
                        //$value->product_image = url('public/assets/images/item-images/'.$product->image);
                        $value->product_image = url('public/uploads/product-images/'.$product->item_id.'.jpg');
                        $value->shelf_number = $product->shelf_number;
                        $value->shelf_image = url('/assets/images/item-images/'.$product->shelf_image);
                    }
                    else{
                        $value->product_name = $value->product_name;
                        $value->product_image = null;
                        $value->shelf_number = null;
                        $value->shelf_image = null;
                    }
                }
                if ($shopping_lists) {
                    $this->response = $shopping_lists;
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
    public function add(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $product_name = $request->product_name;
        $quantity = $request->quantity;
        // Add rules
        $rules = [
            "user_id" => "required",
            "quantity" => "required",
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
                if($product_id){
                    $product = Product::where('id',$product_id)->first();
                    if($product){
                        $shopping_list = ShoppingList::updateOrCreate(
                            ['user_id' => $request->user_id, 'product_id' => $product_id],
                            ['user_id' => $request->user_id,'product_id' => $request->product_id,'product_name' => $product->item_name,'quantity'=>$request->quantity]
                        );
                    }
                }
                else{
                    $shopping_list = ShoppingList::create(
                        ['user_id' => $request->user_id,'product_name' => $request->product_name,'quantity'=>$request->quantity]
                    );
                }
                if ($shopping_list) {
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
    public function delete(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $list_id = $request->list_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "list_id" => "required",
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
                $shopping_list = ShoppingList::where('id',$list_id)->delete();
                if ($shopping_list) {
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
    public function remove(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "product_id" => "required",
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
                $shopping_list = ShoppingList::where('user_id',$user_id)->where('product_id',$product_id)->delete();
                if ($shopping_list) {
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
}
