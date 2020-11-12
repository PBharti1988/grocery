<?php

namespace App\Http\Controllers\API;

use App\Health;
use App\AppUser;
use App\HealthCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HealthController extends Controller
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
            $health_cat = HealthCategory::get();
            foreach ($health_cat as $val) {
                $health_count = 0;
                $array[$i]['category_name'] = $val->category_name;
                $health = Health::select('title','total')->where('category_id', $val->id)->get();

                foreach ($health as $value) {
                   $health_count += $value->total;
                }
                $array[$i]['total'] = $health_count;
                foreach ($health as $val1) {
                    $array[$i]['health'][] = $val1;
                    $health_per = (100*$val1->total)/ $health_count;     
                    $val1->percentage = $health_per; 
                }
                $i++;
            }

            if ($health_cat) {
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

    public function addHealth(Request $request)
    {
        // Receive all request
        $category = $request->category;
        $title = $request->title;
        $total = $request->total;
        // Add rules
        $rules = [
            "category" => "required",
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

            $title_name_exists = Health::where(['title' => ucwords(strtolower($title)), 'category' => ucwords(strtolower($category))])->first();
            if ($title_name_exists) {
                $this->error_code = -117;
            } else {

                $title = ucwords(strtolower($request->title));
                $category = ucwords(strtolower($request->category));
                $request->merge(['title' => $title, 'category' => $category]);
                $health = Health::create($request->only('category', 'total', 'title'));
                if ($health) {
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

    public function editHealth(Request $request)
    {
        // Receive all request
        $health_id = $request->health_id;
        // Add rules
        $rules = [
            "health_id" => "required",
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

            $health = Health::where('id', $health_id)->first();
            if ($health) {
                $this->response = $health;
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

    public function updateHealth(Request $request)
    {
        // Receive all request
        $id = $request->health_id;
        $category = $request->category;
        $title = $request->title;
        $total = $request->total;
        // Add rules
        $rules = [
            "category" => "required",
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

            $title_check = Health::where([
                ['title', ucwords(strtolower($request->title))],
                ['category', ucwords(strtolower($category))],
                ['id', '!=', $id],
            ])->first();
            if ($title_check) {
                $this->error_code = -117;
            } else {

                $title = ucwords(strtolower($request->title));
                $category = ucwords(strtolower($request->category));
                $request->merge(['title' => $title, 'category' => $category]);
                $health = Health::find($id)->update($request->only('category', 'title', 'total'));

                if ($health) {
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
