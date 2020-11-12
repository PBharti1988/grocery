<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APICountryController extends Controller
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

            $country = Country::get();

            if ($country) {
                $this->response = $country;
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

    public function CreateCountry(Request $request)
    {
        // Receive all request
        $country_name = $request->country_name;
        $enabled = $request->enabled;
        // Add rules
        $rules = [
            "country_name" => "required",
            "country_code" => "required",
        ];
        // Set validation message
        $messages = [
            'country_name.required' => 'The country name field is required.',
            'country_code.required' => 'The country code field is required.',
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

            $Existscountry_name = Country::where('country_name', ucwords(strtolower($country_name)))->first();
            if ($Existscountry_name) {
                $this->error_code = -102;
            } else {
                $Existscountry_code = Country::where('country_code', strtoupper($request->country_code))->first();
                if ($Existscountry_code) {
                    $this->error_code = -103;
                } else {

                    $country_name = ucwords(strtolower($request->country_name));
                    $country_code = strtoupper($request->country_code);
                    $request->merge(['country_name' => $country_name, 'country_code' => $country_code]);
                    $country = Country::create($request->only('country_name', 'country_code', 'description', 'enabled'));
                    if ($country) {
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

    public function EditCountry(Request $request)
    {
        // Receive all request
        $country_id = $request->country_id;
        // Add rules
        $rules = [
            "country_id" => "required",
        ];
        // Set validation message
        $messages = [
            'country_id.required' => 'The country id field is required.',
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

            $country = Country::select('id', 'country_name', 'country_code')->where('id', $country_id)->first();
            if ($country) {
                $this->response = $country;
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

    public function UpdateCountry(Request $request)
    {
        // Receive all request
        $country_name = $request->country_name;
        $country_code = $request->country_code;
        $id = $request->country_id;
        $enabled = $request->enabled;
        // Add rules
        $rules = [
            "country_name" => "required",
            "country_code" => "required",
        ];
        // Set validation message
        $messages = [
            'country_name.required' => 'The country name field is required.',
            'country_code.required' => 'The country code field is required.',
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

            $Existscountry_name = Country::where([
                ['country_name', ucwords(strtolower($request->country_name))],
                ['id', '!=', $id],
            ])->first();
            if ($Existscountry_name) {
                $this->error_code = -102;
            } else {
                $Existscountry_code = Country::where([
                    ['country_code', strtoupper($request->country_code)],
                    ['id', '!=', $id],
                ])->first();
                if ($Existscountry_code) {
                    $this->error_code = -103;
                } else {

                    $country_name = ucwords(strtolower($request->country_name));
                    $country_code = strtoupper($request->country_code);
                    $request->merge(['country_name' => $country_name, 'country_code' => $country_code]);
                    $country = Country::find($id)->update($request->only('country_name', 'country_code', 'description', 'enabled'));
                    if ($country) {
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
