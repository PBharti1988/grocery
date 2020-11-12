<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\AppUser;
use DB;

class RestaurentFindController extends Controller
{
    //

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

public function RestuarentFinder(Request $request){

     $user = $request->user_id;
     $lat = $request->lat;
     $long = $request->long;


      $rules = [
      	    "user_id" => "required",
            "lat" => "required",
            "long" => "required"
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

         try{
         
         $user_exists = AppUser::where('id', $request->user_id)->first();
         if($user_exists){

            $res = DB::table('restaurants')
                       ->select('*')   
                       ->where('latitude', 'like', '%' . $lat . '%')
                       ->where('longitude', 'like', '%' . $long . '%')
                       ->get();

        if(count($res) > 0 ){

          $this->response = $res;
        }
        else{
 

             $this->error_code = -101;

        }

         }else{

         	$this->error_code = -108;
         }
        
    }

    catch(\Exception $e){

       $this->error_code = -500;
            if ($request->debug == true) {
                $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
            }

    }

        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        // Return response
        return response()->json($result);
}



}
