<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;
use App\Trainer;
use App\Dietician;
use Illuminate\Http\Request;
use Validator;

class APIVerifyController extends Controller
{

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

    public function UserOtpVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $verifyotp = User::where(['email' => $request->email, 'otp' => $request->otp])->first();
                if ($verifyotp) {
                    $verified = User::where(['id' => $verifyotp->id])->update(['is_verified' => 1]);
                    if ($verified) {
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -109;
                    }
                  } else {
                    $this->error_code = -108;
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




    
    /* Function for verify otp for trainer registration*/

    public function TrainerOtpVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $verifyotp = Trainer::where(['email' => $request->email, 'otp' => $request->otp])->first();
                if ($verifyotp) {
                    $verified = Trainer::where(['id' => $verifyotp->id])->update(['is_verified' => 1]);
                    if ($verified) {
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -109;
                    }
                  } else {
                    $this->error_code = -108;
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





    public function DieticianOtpVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $verifyotp = Dietician::where(['email' => $request->email, 'otp' => $request->otp])->first();
                if ($verifyotp) {
                    $verified = Dietician::where(['id' => $verifyotp->id])->update(['is_verified' => 1]);
                    if ($verified) {
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -109;
                    }
                  } else {
                    $this->error_code = -108;
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
