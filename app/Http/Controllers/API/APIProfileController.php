<?php

namespace App\Http\Controllers\api;

use App\Dietician;
use App\Http\Controllers\Controller;
use App\Trainer;
use App\User;
use Illuminate\Http\Request;
use Validator;

class APIProfileController extends Controller
{

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }



     /* For User Profile*/

    public function UserProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $user = User::where('id', $request->user_id)->select('id', 'name', 'email', 'profile_image', 'mobile')->first();
                if ($user) {
                    $this->response = $user;
                } else {
                    $this->error_code = -100;
                }

            } catch (\Exception $e) {
                $this->error_code = 500;
                if ($request->debug == true) {
                    $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
                }
            }
        }
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        return response()->json($result);

    }
    


     /* For Trainer Profile*/

    public function TrainerProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $user = Trainer::where('id', $request->user_id)->select('id', 'name', 'email', 'profile_image', 'mobile')->first();
                if ($user) {
                    $this->response = $user;
                } else {
                    $this->error_code = -100;
                }

            } catch (\Exception $e) {
                $this->error_code = 500;
                if ($request->debug == true) {
                    $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
                }
            }
        }
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        return response()->json($result);

    }



    
    /*For Dietician Profile*/

    public function DieticianProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $user = Dietician::where('id', $request->user_id)->select('id', 'name', 'email', 'profile_image', 'mobile')->first();
                if ($user) {
                    $this->response = $user;
                } else {
                    $this->error_code = -100;
                }

            } catch (\Exception $e) {
                $this->error_code = 500;
                if ($request->debug == true) {
                    $this->response = $e->getMessage() . ' on line number ' . $e->getLine() . ' in ' . $e->getFile();
                }
            }
        }
        $result = array('ErrorCode' => $this->error_code, 'ErrorMessage' => getErrorMessage($this->error_code), 'Response' => $this->response);
        return response()->json($result);

    }

}
