<?php

namespace App\Http\Controllers\API;

use App\EnvironmentCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnvironmentCategoryController extends Controller
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

            $environment_category = EnvironmentCategory::get();

            if ($environment_category) {
                $this->response = $environment_category;
            } else {
                $this->error_code = -101;
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

    public function addEnvironmentCategory(Request $request)
    {
        // Receive all request
        $category = $request->category_name;
        // Add rules
        $rules = [
            "category_name" => "required",
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

            $environment_category_exists = EnvironmentCategory::where('category_name', ucwords(strtolower($category)))->first();
            if ($environment_category_exists) {
                $this->error_code = -115;
            } else {

                $category_name = ucwords(strtolower($request->category_name));
                $request->merge(['category_name' => $category_name]);
                $environment_category_created = EnvironmentCategory::create($request->only('category_name'));
                if ($environment_category_created) {
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

    public function editEnvironmentCategory(Request $request)
    {
        // Receive all request
        $environment_category_id = $request->environment_category_id;
        // Add rules
        $rules = [
            "environment_category_id" => "required",
        ];
        // Set validation message
        $messages = [
            'environment_category_id.required' => 'The environment category name is required.',
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

            $environmentCategory = EnvironmentCategory::select('id', 'category_name')->where('id', $environment_category_id)->first();
            if ($environmentCategory) {
                $this->response = $environmentCategory;
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

    public function updateEnvironmentCategory(Request $request)
    {
        // Receive all request
        $id = $request->environment_category_id;
        $category_name = $request->category_name;
        // Add rules
        $rules = [
            "category_name" => "required",
            "environment_category_id" => "required",
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

            $education_category_exists = EnvironmentCategory::where([
                ['category_name', ucwords(strtolower($request->category_name))],
                ['id', '!=', $id],
            ])->first();
            if ($education_category_exists) {
                $this->error_code = -115;
            } else {

                $category_name = ucwords(strtolower($request->category_name));
                $request->merge(['category_name' => $category_name]);
                $environmentCategory = EnvironmentCategory::find($id)->update($request->only('category_name'));
                if ($environmentCategory) {
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
