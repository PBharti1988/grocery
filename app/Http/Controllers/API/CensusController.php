<?php

namespace App\Http\Controllers\API;

use App\Census;
use App\AppUser;
use App\CensusCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CensusController extends Controller
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
            $i = 0;
            $census_cat = CensusCategory::get();
            foreach ($census_cat as $val) {
                $census_count =0;
                $array[$i]['category_name'] = $val->category_name;
                $census = Census::select('title','value')->where('category_id', $val->id)->get();
                foreach ($census as $value) {
                    $census_count +=$value->value;               
                }
                $array[$i]['total'] = $census_count;

                foreach ($census as $val1) {
                    $array[$i]['census'][] = $val1;
                    $census_per = (100*$val1->value)/ $census_count;     
                    $val1->percentage = $census_per; 
                }
                $i++;
            }

            if ($census_cat) {
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

    public function addCensus(Request $request)
    {
        // Receive all request
        $category = $request->category;
        $title = $request->title;
        $value = $request->value;
        // Add rules
        $rules = [
            "category" => "required",
            "title" => "required",
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

            $title_name_exists = Census::where(['title' => ucwords(strtolower($title)), 'category' => ucwords(strtolower($category))])->first();
            if ($title_name_exists) {
                $this->error_code = -119;
            } else {

                $title = ucwords(strtolower($request->title));
                $category = ucwords(strtolower($request->category));
                $request->merge(['title' => $title, 'category' => $category]);
                $census = Census::create($request->only('category', 'value', 'title'));
                if ($census) {
                    $this->error_code = 0;
                } else {
                    $this->error_code = -100;
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

    public function editCensus(Request $request)
    {
        // Receive all request
        $id = $request->id;
        // Add rules
        $rules = [
            "id" => "required",
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

            $census = Census::where('id', $id)->first();
            if ($census) {
                $this->response = $census;
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

    public function updateCensus(Request $request)
    {
        // Receive all request
        $id = $request->id;
        $category = $request->category;
        $title = $request->title;
        $value = $request->value;
        // Add rules
        $rules = [
            "category" => "required",
            "title" => "required",
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

            $title_check = Census::where([
                ['title', ucwords(strtolower($request->title))],
                ['category', ucwords(strtolower($category))],
                ['id', '!=', $id],
            ])->first();
            if ($title_check) {
                $this->error_code = -119;
            } else {

                $title = ucwords(strtolower($request->title));
                $category = ucwords(strtolower($request->category));
                $request->merge(['title' => $title, 'category' => $category]);
                $census = Census::find($id)->update($request->only('category', 'title', 'total'));

                if ($census) {
                    $this->error_code = 0;

                } else {

                    $this->error_code = -100;
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
