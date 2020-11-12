<?php

namespace App\Http\Controllers\API;

use App\CrimeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrimeCategoryController extends Controller
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

            $crime_category = CrimeCategory::get();

            if ($crime_category) {
                $this->response = $crime_category;
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

    public function addCrimeCategory(Request $request)
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

            $crime_category_exists = CrimeCategory::where('category_name', ucwords(strtolower($category)))->first();
            if ($crime_category_exists) {
                $this->error_code = -112;
            } else {

                $category_name = ucwords(strtolower($request->category_name));
                $request->merge(['category_name' => $category_name]);
                $crime_category_created = CrimeCategory::create($request->only('category_name'));
                if ($crime_category_created) {
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

    public function editCrimeCategory(Request $request)
    {
        // Receive all request
        $crime_category_id = $request->crime_category_id;
        // Add rules
        $rules = [
            "crime_category_id" => "required",
        ];
        // Set validation message
        $messages = [
            'crime_category_id.required' => 'The crime category name is required.',
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

            $crimeCategory = CrimeCategory::select('id', 'category_name')->where('id', $crime_category_id)->first();
            if ($crimeCategory) {
                $this->response = $crimeCategory;
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

    public function updateCrimeCategory(Request $request)
    {
        // Receive all request
        $id = $request->crime_category_id;
        $category_name = $request->category_name;
        // Add rules
        $rules = [
            "category_name" => "required",
            "crime_category_id" => "required",
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

            $crime_category_exists = CrimeCategory::where([
                ['category_name', ucwords(strtolower($request->category_name))],
                ['id', '!=', $id],
            ])->first();
            if ($crime_category_exists) {
                $this->error_code = -112;
            } else {

                $category_name = ucwords(strtolower($request->category_name));
                $request->merge(['category_name' => $category_name]);
                $crimeCategory = CrimeCategory::find($id)->update($request->only('category_name'));
                if ($crimeCategory) {
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
