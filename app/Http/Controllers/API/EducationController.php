<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DB;
use App\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
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
            $education = DB::table('education_categories')->whereNull('deleted_at')->get();
            foreach ($education as $val) {
                $count_edu = 0;
                $array[$i]['category_name'] = $val->category_name;
                $education_child = DB::table('educations')->select('title','total')->where('category_id', $val->id)->get();
                
                foreach ($education_child as $data) {                
                    $count_edu +=   $data->total;      
                }
               $array[$i]['total_education'] = $count_edu;

                foreach ($education_child as $val1) {
                    $array[$i]['education'][] = $val1;
                    $education_per = (100*$val1->total)/ $count_edu;     
                    $val1->percentage = $education_per; 
                }
                $i++;
            }
            if ($education) {
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

    public function addEducation(Request $request)
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

            $title_name_exists = DB::table('educations')->where(['title' => ucwords(strtolower($title)), 'category_id' => $category])->first();
            if ($title_name_exists) {
                $this->error_code = -114;
            } else {

                $title = ucwords(strtolower($request->title));
                $request->merge(['title' => $title]);
                $education = DB::table('educations')->insert($request->only('category_id', 'total', 'title'));
                if ($education) {
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

    public function editEducation(Request $request)
    {
        // Receive all request
        $education_id = $request->education_id;
        // Add rules
        $rules = [
            "education_id" => "required",
        ];
        // Set validation message
        $messages = [
            'education_id.required' => 'The education name is required.',
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

            $education = DB::table('educations')->where('id', $education_id)->first();
            if ($education) {
                $this->response = $education;
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

    public function updateEducation(Request $request)
    {
        // Receive all request
        $id = $request->education_id;
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

            $title_check = DB::table('educations')->where([
                ['title', ucwords(strtolower($request->title))],
                ['category_id', $category_id],
                ['id', '!=', $id],
            ])->first();
            if ($title_check) {
                $this->error_code = -111;
            } else {

                $title = ucwords(strtolower($request->title));

                $request->merge(['title' => $title]);
                $education = DB::table('educations')->where('id', $id)->update($request->only('category_id', 'title', 'total'));
                if ($education) {
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
