<?php

namespace App\Http\Controllers\API;

use App\EducationCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationCategoryController extends Controller
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

            $education_category = EducationCategory::get();

            if ($education_category) {
                $this->response = $education_category;
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

    public function addEducationCategory(Request $request)
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

            $education_category_exists = EducationCategory::where('category_name', ucwords(strtolower($category)))->first();
            if ($education_category_exists) {
                $this->error_code = -113;
            } else {

                $category_name = ucwords(strtolower($request->category_name));
                $request->merge(['category_name' => $category_name]);
                $education_category_created = EducationCategory::create($request->only('category_name'));
                if ($education_category_created) {
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

    public function editEducationCategory(Request $request)
    {
        // Receive all request
        $education_category_id = $request->education_category_id;
        // Add rules
        $rules = [
            "education_category_id" => "required",
        ];
        // Set validation message
        $messages = [
            'education_category_id.required' => 'The education category name is required.',
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

            $educationCategory = EducationCategory::select('id', 'category_name')->where('id', $education_category_id)->first();
            if ($educationCategory) {
                $this->response = $educationCategory;
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

    public function updateEducationCategory(Request $request)
    {
        // Receive all request
        $id = $request->education_category_id;
        $category_name = $request->category_name;
        // Add rules
        $rules = [
            "category_name" => "required",
            "education_category_id" => "required",
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

            $education_category_exists = EducationCategory::where([
                ['category_name', ucwords(strtolower($request->category_name))],
                ['id', '!=', $id],
            ])->first();
            if ($education_category_exists) {
                $this->error_code = -113;
            } else {

                $category_name = ucwords(strtolower($request->category_name));
                $request->merge(['category_name' => $category_name]);
                $educationCategory = EducationCategory::find($id)->update($request->only('category_name'));
                if ($educationCategory) {
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
