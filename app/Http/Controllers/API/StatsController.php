<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Stats;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatsController extends Controller
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
            "user_id" => "required|integer",
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
            $app_user = AppUser::find($user_id);
            if ($app_user) {
                $stats = Stats::all();

                $international_total_infected = '0';
                $international_dead = '0';
                $international_countries_affected = '0';
                $international_recovered = '0';
                $national_total_infected = '0';
                $national_dead = '0';
                $national_new_cases = '0';
                $national_recovered = '0';

                foreach($stats as $value){
                    if($value->stats_key == 'international_total_infected'){
                        $international_total_infected = $value->stats_value;
                    }
                    if($value->stats_key == 'international_dead'){
                        $international_dead = $value->stats_value;
                    }
                    if($value->stats_key == 'international_countries_affected'){
                        $international_countries_affected = $value->stats_value;
                    }
                    if($value->stats_key == 'international_recovered'){
                        $international_recovered = $value->stats_value;
                    }
                    if($value->stats_key == 'national_total_infected'){
                        $national_total_infected = $value->stats_value;
                    }
                    if($value->stats_key == 'national_dead'){
                        $national_dead = $value->stats_value;
                    }
                    if($value->stats_key == 'national_new_cases'){
                        $national_new_cases = $value->stats_value;
                    }
                    if($value->stats_key == 'national_recovered'){
                        $national_recovered = $value->stats_value;
                    }
                }
                $international = array('total_infected'=>$international_total_infected,'dead'=>$international_dead,'countries_affected'=>$international_countries_affected,'recovered'=>$international_recovered);
                $national = array('total_infected'=>$national_total_infected,'dead'=>$national_dead,'new_cases'=>$national_new_cases,'recovered'=>$national_recovered);

                $this->response = array('international'=>$international,'national'=>$national);
            } else {
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
