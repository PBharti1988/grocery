<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\NationalStatistic;
use App\StatisticCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NationalStatisticController extends Controller
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
            $checkUser = AppUser::where('id', $user_id)->first();
            if ($checkUser) {
                $array = array();
                $i = 0;
                $stats_cat = StatisticCategory::get();
                foreach ($stats_cat as $val) {
                    $stat_count = 0;
                    $array[$i]['category_name'] = $val->category_name;
                    $stats = NationalStatistic::select('title','value')->where('category_id', $val->id)->get();
                  
                    foreach ($stats as $value) {
                       $stat_count +=$value->value;
                    }
                    $array[$i]['total'] =$stat_count;
                    foreach ($stats as $val1) {
                        $array[$i]['national_statistic'][] = $val1;
                        $stat_per = (100*$val1->value)/ $stat_count;     
                        $val1->percentage = $stat_per;
                    }
                    $i++;
                }

                if ($stats_cat) {
                    $this->response = $array;
                } else {
                    $this->error_code = -101;
                }
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

    public function addNationalStatistic(Request $request)
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

            $title_name_exists = NationalStatistic::where(['title' => ucwords(strtolower($title)), 'category' => ucwords(strtolower($category))])->first();
            if ($title_name_exists) {
                $this->error_code = -118;
            } else {

                $title = ucwords(strtolower($request->title));
                $category = ucwords(strtolower($request->category));
                $request->merge(['title' => $title, 'category' => $category]);
                $health = NationalStatistic::create($request->only('category', 'value', 'title'));
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

    public function editNationalStatistic(Request $request)
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

            $stats = NationalStatistic::where('id', $id)->first();
            if ($stats) {
                $this->response = $stats;
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

    public function updateNationalStatistic(Request $request)
    {
        // Receive all request
        $id = $request->id;
        $category = $request->category;
        $title = $request->title;
        $total = $request->total;
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

            $title_check = NationalStatistic::where([
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
                $stats = NationalStatistic::find($id)->update($request->only('category', 'title', 'value'));

                if ($stats) {
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
