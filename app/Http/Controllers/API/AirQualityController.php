<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirQualityController extends Controller
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
        ];
        // Set validation message
        $messages = [

        ];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        // Process data
        try {
            $checkUser = AppUser::where('id', $user_id)->first();
            if ($checkUser) {
            $url = "http://api.waqi.info/feed/kuala%20lumpur/?token=299129c04e8e1240beb9ac2e0bdd064a5b1a1504";
            $result = callAirQualityAPI($url, 'GET');
          
            $decoded_result = json_decode($result);
            $status = $decoded_result->status;
            if ($status == 'ok') {
                $aqi = $decoded_result->data->aqi;
                $date = $decoded_result->data->debug->sync;
                
                $this->response = array('aqi'=>$aqi,'date_time'=>$date);
            } else {
                $this->error_code = -100;
            }
        }else{
              $this->error_code = -105;
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
