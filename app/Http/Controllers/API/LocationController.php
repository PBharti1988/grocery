<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\Location;
use App\StoreCityArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
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
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        // Process data
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $store_locations = Location::all();
                if ($store_locations) {
                    $this->response = $store_locations;
                } else {
                    $this->error_code = -101;
                }

            } else {
                $this->error_code = -108;
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

    public function getStore(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "area" => "required",
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        // Process data
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $stores = StoreCityArea::select('restaurants.*')
                    ->leftJoin('restaurants', 'restaurants.id', 'store_city_areas.restaurant_id')
                    ->where('store_city_areas.enabled', 1)
                    ->where('store_city_areas.area_name', $request->area)
                    ->get();
                if (count($stores)) {
                    $this->response = $stores;
                } else {
                    $this->error_code = -101;
                }
            } else {
                $this->error_code = -108;
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

    public function pickupTime(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        // Add rules
        $rules = [
            "user_id" => "required",
        ];
        // Set validation message
        $messages = [];
        // Show validation error
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $this->error_code = -999;
            $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => $validator->messages()->first(), 'Response' => getErrorMessage($this->error_code));
            return response()->json($result);
        }
        // Process data
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $currTime = date("G:i", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata')));
                $today = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata')));
                $tommorow = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata') . "+1 day"));
                $day_after = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata') . "+2 day"));

                $tommorow_dd = date("m-d-Y", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata') . "+1 day"));
                $day_after_dd = date("m-d-Y", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata') . "+2 day"));

                $currTime12hrs = date("h:i:s A", strtotime(cnvt_UTC_to_usrTime(now(), 'Asia/Kolkata') . "+1 hour"));

                $range_today = '';
                $range_tomorrow = '';
                $range_day_after = '';

                // $currTime= '20:20';
                // $currTime12hrs='08:36:51 PM';
                if ($currTime > '10:00' && $currTime < '19:01') {
                    $date_1 = $today;
                    $date_2 = $tommorow;
                    $date_1_dd = 'Today';
                    $date_2_dd = 'Tommorow';

                    $range_today = create_time_range('10:00', '20:30', '30 mins');
                    $range_today = get_avaliable_slot($currTime12hrs, $range_today);
                    // print_r($range_today);
                    $range_tomorrow = create_time_range('10:00', '20:30', '30 mins');
                    $range_date_1 = $range_today;
                    $range_date_2 = $range_tomorrow;
                } else if ($currTime < '10:00') {
                    $date_1 = $today;
                    $date_2 = $tommorow;

                    $date_1_dd = 'Today';
                    $date_2_dd = 'Tommorow';

                    $range_today = create_time_range('10:00', '20:30', '30 mins');
                    $range_tomorrow = create_time_range('10:00', '20:30', '30 mins');
                    $range_date_1 = $range_today;
                    $range_date_2 = $range_tomorrow;

                } else if ($currTime > '19:00') {
                    $date_1 = $tommorow;
                    $date_2 = $day_after;

                    $date_1_dd = $tommorow_dd;
                    $date_2_dd = $day_after_dd;

                    $range_tomorrow = create_time_range('10:00', '20:30', '30 mins');
                    $range_day_after = create_time_range('10:00', '20:30', '30 mins');
                    $range_date_1 = $range_tomorrow;
                    $range_date_2 = $range_day_after;

                } else {
                    $date_1 = $today;
                    $date_2 = $tommorow;

                    $date_1_dd = 'Today';
                    $date_2_dd = 'Tommorow';

                    $range_today = create_time_range('10:00', '20:30', '30 mins');
                    $range_tomorrow = create_time_range('10:00', '20:30', '30 mins');
                    $range_date_1 = $range_today;
                    $range_date_2 = $range_tomorrow;

                }
                $stores = $today;
                $this->response = $stores;
            } else {
                $this->error_code = -108;
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
