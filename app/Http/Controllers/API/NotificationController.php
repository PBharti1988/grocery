<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class NotificationController extends Controller
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
            $data = array();

            $user_exists = AppUser::where('id', $user_id)->first();
            if ($user_exists) {
                $user_created_at = $user_exists->created_at;
                $notifications = Notification::where('user_id',NULL)->where('created_at', '>=', $user_created_at)->orderBy('created_at', 'DESC')->get();
                if($notifications){
                    foreach($notifications as $key=>$val){
                        array_push($data,$val);
                    }
                }

                $notifications_user = Notification::where('user_id',$user_id)->orderBy('created_at', 'DESC')->get();
                if($notifications_user){
                    foreach($notifications_user as $key=>$val){
                        array_push($data,$val);
                    }
                }

                foreach($data as $key=>$val){
                    $data[$key]['image'] = url('/uploads').'/'.$val->image;
                }
                
                if ($data) {
                    $this->response = $data;
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

}