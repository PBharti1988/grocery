<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use App\ShoppingList;
use App\Shelf;
use App\Cart;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
            "user_id" => "required",
            "category_id" => "required",
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
                if($request->type == 'category'){
                    $products = Product::select('id','item_id','item_name as product_name','image as product_image','item_price as mrp')
                    ->where('restaurant_id','35')
                    ->where('category_id',$request->category_id)
                    ->where('enabled','1')
                    ->get();
                }
                else{
                    $products = Product::select('id','item_id','item_name as product_name','image as product_image','item_price as mrp')
                    ->where('restaurant_id','35')
                    ->where('sub_category_id',$request->category_id)
                    ->where('enabled','1')
                    ->get();
                }
                if($products){
                    foreach($products as $value){
                        //$value->product_image = url('public/assets/images/item-images/'.$value->product_image);
                        $value->product_image = url('public/uploads/product-images/'.$value->item_id.'.jpg');
                        $cart = Cart::where('user_id',$user_id)->where('product_id',$value->id)->first();
                        if($cart){
                            $value->quantity = $cart->quantity;
                        }
                        else{
                            $value->quantity = 0;
                        }
                    }
                    $this->response = $products;  
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
    public function details(Request $request)
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
        // Process data
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $product = Product::where('enabled','1')
                ->select('items.id','items.item_id','items.image','items.item_type','items.item_price as mrp','items.long_description as description','items.item_name as product_name','items.manufacturer as brand')
                ->where('items.enabled','1')
                ->where('items.id',$product_id)
                ->first();
                if ($product) {
                    //$product->product_image = url('public/assets/images/item-images/'.$product->image);
                    $product->product_image = url('public/uploads/product-images/'.$product->item_id.'.jpg');
                    $product->is_wishlisted = false;
                    $product->cart_quantity = 0;

                    $shopping_list = ShoppingList::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
                    if($shopping_list){
                        $product->is_wishlisted = true;
                    }

                    $cart = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
                    if($cart){
                        $product->cart_quantity = $cart->quantity;
                    }
                    
                    $this->response = $product;
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
    public function search(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $query = $request->get('query');
        // Add rules
        $rules = [
            "user_id" => "required",
            "query" => "required|min:3"
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
                $products = Product::where('enabled','1')
                ->select('items.id','items.item_id','items.image','items.item_name as product_name','items.item_price as mrp','items.discount_price as offer_price','items.manufacturer as brand')
                ->where('enabled','1')
                ->where('item_name','LIKE',"%$query%")
                ->get();
                if($products){
                    $quantity = 0;
                    foreach($products as $value){
                        //$value->product_image = url('public/assets/images/item-images/'.$value->image);
                        $value->product_image = url('public/uploads/product-images/'.$value->item_id.'.jpg');
                        $shopping_list = ShoppingList::where('user_id',$user_id)
                        ->where('product_id',$value->id)
                        ->first();
                        if($shopping_list){
                            $quantity = $shopping_list->quantity;
                        }
                        $value->quantity = $quantity;
                    }
                    $this->response = $products;  
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
    public function searchInCategory(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $type = $request->type;
        $query = $request->get('query');
        // Add rules
        $rules = [
            "user_id" => "required",
            "category_id" => "required",
            "type" => "required",
            "query" => "required|min:3"
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
                if($type == 'subcategory'){
                    $products = Product::where('enabled','1')
                    ->select('items.id','items.item_id','items.image','items.item_name as product_name','items.item_price as mrp','items.discount_price as offer_price','items.manufacturer as brand')
                    ->where('enabled','1')
                    ->where('sub_category_id',$category_id)
                    ->where('item_name','LIKE',"%$query%")
                    ->get();
                }
                else{
                    $products = Product::where('enabled','1')
                    ->select('items.id','items.item_id','items.image','items.item_name as product_name','items.item_price as mrp','items.discount_price as offer_price','items.manufacturer as brand')
                    ->where('enabled','1')
                    ->where('category_id',$category_id)
                    ->where('item_name','LIKE',"%$query%")
                    ->get();
                }
                if($products){
                    $quantity = 0;
                    foreach($products as $value){
                        //$value->product_image = url('public/assets/images/item-images/'.$value->image);
                        $value->product_image = url('public/uploads/product-images/'.$value->item_id.'.jpg');
                        $shopping_list = ShoppingList::where('user_id',$user_id)
                        ->where('product_id',$value->id)
                        ->first();
                        if($shopping_list){
                            $quantity = $shopping_list->quantity;
                        }
                        $value->quantity = $quantity;
                    }
                    $this->response = $products;  
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
    public function locate(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $barcode = $request->barcode;
        // Add rules
        $rules = [
            "user_id" => "required",
            "barcode" => "required",
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
        // Process data
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $product = Product::where('items.enabled','1')
                ->select('items.item_name','shelves.shelf_number','shelves.shelf_image')
                ->where('barcode',$barcode)
                ->join('shelves', 'shelves.id', '=', 'items.shelf_id')
                ->first();
                if ($product) {
                    $product->shelf_image = asset('public/assets/images/shelves/'.$product->shelf_image);
                    $this->response = $product;
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
    public function bestPrice(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $barcode = $request->barcode;
        // Add rules
        $rules = [
            "user_id" => "required",
            "barcode" => "required",
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
        // Process data
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $product = Product::where('enabled','1')
                ->select('items.*','items.manufacturer as brand')
                ->where('barcode',$barcode)
                ->first();
                if ($product) {
                    //$product->image = url('public/assets/images/item-images/'.$product->image);
                    $product->image = url('public/uploads/product-images/'.$product->item_id.'.jpg');
                    $this->response = $product;
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
    public function categories(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "store_id" => "required",
            
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
                $product_categories = ProductCategory::select('id','category_name as name')
                ->where('restaurant_id',$request->store_id)
                ->where('enabled','1')
                ->where('parent_id',NULL)
                ->get();
                if($product_categories){
                    foreach($product_categories as $key=>$value){
                        $product_subcategories = ProductCategory::select('id','category_name as name','icon as image')
                        ->where('parent_id',$value->id)
                        ->get();
                        if($product_subcategories){
                            foreach($product_subcategories as $subcategory){
                                $subcategory->image = url('public/assets/images/category-icon/'.$subcategory->image);
                            }
                            $product_categories[$key]->subcategories = $product_subcategories;
                        }
                    }
                    $this->response = $product_categories;  
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
}
