<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Cart;

class TestController extends Controller
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
            //"user_id" => "required",
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
            $data = array('id'=>$user_id,'name'=>'Danish','email'=>'danish1023@gmail.com');
            $this->response = $request->all();
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

    public function stock(Request $request)
    {
        $data = [];
        $x = array("item_id" => 29546,"item_name" => "ABC", "status" => "Out of Stock");
        $y = array("item_id" => 29547,"item_name" => "XYZ", "status" => "In Stock");
        array_push($data,$x);
        array_push($data,$y);
        $this->response = $data;
        // Store result in an array
        $result = array('ErrorCode' => -111, 'ErrorMessage' => "Some of cart items are out of stock", 'Response' => $this->response);
        // Return response
        return response()->json($result);
    }
}
