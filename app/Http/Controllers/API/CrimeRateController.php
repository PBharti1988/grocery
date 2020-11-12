<?php

namespace App\Http\Controllers\API;

use App\CrimeCategory;
use App\CrimeRate;
use App\AppUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrimeRateController extends Controller
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

            $checkUser = AppUser::where('id',$user_id)->first();
            if($checkUser){
            $array = array();
            $total =array();
         
            $i = 0;
            $crime_cat = CrimeCategory::get();
            $total =0;
            foreach ($crime_cat as $val) {
                $count_crime = 0;
                $array[$i]['category_name'] = $val->category_name;
                $crime_rate = CrimeRate::select('crime_name','title','value')->where('category_id', $val->id)->get();
              
                foreach ($crime_rate as $data) {                
                    $count_crime +=   $data->value;      
                }
                $array[$i]['total_crime'] = $count_crime;  
                foreach ($crime_rate as $val1) {                
                      $array[$i]['crime_report'][] = $val1;     
                      $crime_per = (100*$val1->value)/ $count_crime;     
                      $val1->percentage = $crime_per; 
                }           
                $i++;            
            }

            if ($crime_cat) {
                $this->response = $array;
            } else {
                $this->error_code = -101;
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

    public function graphicalCrimeReport(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
          
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

    public function editCrimeRate(Request $request)
    {
        // Receive all request
        $crime_rate_id = $request->crime_rate_id;
        // Add rules
        $rules = [
            "crime_rate_id" => "required",
        ];
        // Set validation message
        $messages = [
            'crime_rate_id.required' => 'The crime name is required.',
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

            $crime = CrimeRate::select('category_id', 'crime_name', 'title', 'year', 'value')->where('id', $crime_rate_id)->first();
            if ($crime) {
                $this->response = $crime;
            } else {
                $this->error_code = -100;
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

    public function updateCrimeRate(Request $request)
    {
        // Receive all request
        $id = $request->crime_rate_id;
        $category_id = $request->category_id;
        $crime_name = $request->crime_name;
        $title = $request->title;
        $year = $request->year;
        $value = $request->value;
        // Add rules
        $rules = [
            "category_id" => "required",
            "crime_name" => "required",
            "title" => "required",
            "year" => "required",
            "value" => "required",
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

            $crime_name_exists = CrimeRate::where([
                ['crime_name', ucwords(strtolower($request->crime_name))],
                ['category_id', $category_id],
                ['id', '!=', $id],
            ])->first();
            if ($crime_name_exists) {
                $this->error_code = -110;
            } else {
                $title = CrimeRate::where([
                    ['title', ucwords(strtolower($request->title))],
                    ['category_id', $category_id],
                    ['id', '!=', $id],
                ])->first();
                if ($title) {
                    $this->error_code = -111;
                } else {

                    $crime_name = ucwords(strtolower($request->crime_name));
                    $title = ucwords(strtolower($request->title));

                    $request->merge(['crime_name' => $crime_name, 'title' => $title]);
                    $crime = CrimeRate::find($id)->update($request->only('category_id', 'crime_name', 'title', 'year', 'value'));
                    if ($crime) {
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -100;
                    }
                }

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
