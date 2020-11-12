<?php

namespace App\Http\Controllers\API;
use App\AppUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherReportController extends Controller
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
            "user_id" => "Required",
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
            $url = "http://api.openweathermap.org/data/2.5/weather?q=kuala lumpur&units=metric&appid=31c9c6aae742dff41a473652cd3e9981";
            $result = callWeatherReportAPI($url, 'GET');
            //  $this->response = $result;
            $decoded_result = json_decode($result);
            if ($result) {
                $temp = $decoded_result->main->temp;
                $temp_min  = $decoded_result->main->temp_min;
                $temp_max  = $decoded_result->main->temp_max;
                $humidity  = $decoded_result->main->humidity;
                $wind_speed = $decoded_result->wind->speed;
                $weather = $decoded_result->weather;
                $this->response = array('temperature'=>$temp,'min_temperature'=>$temp_min,'max_temperature'=>$temp_max,'humidity'=>$humidity,'wind_speed'=>$wind_speed,'weather'=>$weather);
                // $this->response = $decoded_result;
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
