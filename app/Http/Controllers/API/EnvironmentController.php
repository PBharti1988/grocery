<?php

namespace App\Http\Controllers\API;

use App\Environment;
use App\EnvironmentCategory;
use App\Http\Controllers\Controller;
use DB;
use App\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnvironmentController extends Controller
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
            $environment_cat = EnvironmentCategory::get();
            foreach ($environment_cat as $val) {
                $env_count = 0;
                $array[$i]['category_name'] = $val->category_name;
                $environment = Environment::select('title','total')->where('category_id', $val->id)->get();
               
                foreach ($environment as $value) {
                    $env_count +=$value->total;   
                }
                $array[$i]['total'] = $env_count;

                foreach ($environment as $val1) {
                    $array[$i]['environment'][] = $val1;
                    $env_per = (100*$val1->total)/ $env_count;     
                    $val1->percentage = $env_per; 
                }

                $i++;
            }
           
            if ($environment_cat) {
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

    public function addEnvironment(Request $request)
    {
        // Receive all request
        $category = $request->category_id;
        $title = $request->title;
        $total = $request->total;
        // Add rules
        $rules = [
            "category_id" => "required",
            "title" => "required",
            "total" => "required",
        ];
        // Set validation message
        $messages = [
            'category_id.required' => 'The education category is required.',
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

            $title_name_exists = DB::table('environments')->where(['title' => ucwords(strtolower($title)), 'category_id' => $category])->first();
            if ($title_name_exists) {
                $this->error_code = -116;
            } else {

                $title = ucwords(strtolower($request->title));
                $request->merge(['title' => $title]);
                $environment = DB::table('environments')->insert($request->only('category_id', 'total', 'title'));
                if ($environment) {
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

    public function editEnvironment(Request $request)
    {
        // Receive all request
        $environment_id = $request->environment_id;
        // Add rules
        $rules = [
            "environment_id" => "required",
        ];
        // Set validation message
        $messages = [
            'environment_id.required' => 'The environment title is required.',
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

            $environment = DB::table('environments')->where('id', $environment_id)->first();
            if ($environment) {
                $this->response = $environment;
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

    public function updateEnvironment(Request $request)
    {
        // Receive all request
        $id = $request->environment_id;
        $category_id = $request->category_id;
        $title = $request->title;
        $total = $request->total;
        // Add rules
        $rules = [
            "category_id" => "required",
            "title" => "required",
            "total" => "required",
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

            $title_check = DB::table('environments')->where([
                ['title', ucwords(strtolower($request->title))],
                ['category_id', $category_id],
                ['id', '!=', $id],
            ])->first();
            if ($title_check) {
                $this->error_code = -116;
            } else {

                $title = ucwords(strtolower($request->title));

                $request->merge(['title' => $title]);
                $environment = Environment::find($id)->update($request->only('category_id', 'title', 'total'));

                if ($environment) {
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
