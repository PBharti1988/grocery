<?php

namespace App\Http\Controllers\api;

use App\Dietician;
use App\Http\Controllers\Controller;
use App\Trainer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class APIUpdateProfileController extends Controller
{

    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

    /* For update User Profile*/

    public function UserUpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',

        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {
                $user_id = $request->user_id;
                $attachment = $request->profile_image;

                $checkuser = User::where('id', $user_id)->first();
                if ($checkuser) {

                    if (filter_var($attachment, FILTER_VALIDATE_URL) === false) {
                        if ($attachment) {
                            $file_name = 'profile_' . $user_id . '_' . time() . '.jpg';
                            @list($type, $attachment) = explode(';', $attachment);
                            @list(, $attachment) = explode(',', $attachment);
                            $image = base64_decode($attachment);
                            Storage::disk('profile_uploads')->put($file_name, $image);
                            $request['profile_image'] = $file_name;
                        }
                    }

                    $update = User::where('id', $user_id)->update($request->only('name', 'profile_image'));

                    if ($update) {
                        $this->error_code = 0;
                    } else {
                        $this->response = "not uploaded";
                    }

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

    /* For update Trainer Profile*/

    public function TrainerUpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $user_id = $request->user_id;
                $attachment = $request->profile_image;

                $checkuser = Trainer::where('id', $user_id)->first();
                if ($checkuser) {

                    if (filter_var($attachment, FILTER_VALIDATE_URL) === false) {
                        if ($attachment) {
                            $file_name = 'profile_' . $user_id . '_' . time() . '.jpg';
                            @list($type, $attachment) = explode(';', $attachment);
                            @list(, $attachment) = explode(',', $attachment);
                            $image = base64_decode($attachment);
                            Storage::disk('profile_uploads')->put($file_name, $image);
                            $request['profile_image'] = $file_name;
                        }
                    }

                    $update = Trainer::where('id', $user_id)->update($request->only('name', 'profile_image'));

                    if ($update) {
                        $this->error_code = 0;
                    } else {
                        $this->response = "not uploaded";
                    }

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

    /*For update Dietician Profile*/

    public function DieticianUpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->error_code = -999;
            $this->response = $validator->messages()->first();
        } else {
            try {

                $user_id = $request->user_id;
                $attachment = $request->profile_image;

                $checkuser = Dietician::where('id', $user_id)->first();
                if ($checkuser) {

                    if (filter_var($attachment, FILTER_VALIDATE_URL) === false) {
                        if ($attachment) {
                            $file_name = 'profile_' . $user_id . '_' . time() . '.jpg';
                            @list($type, $attachment) = explode(';', $attachment);
                            @list(, $attachment) = explode(',', $attachment);
                            $image = base64_decode($attachment);
                            Storage::disk('profile_uploads')->put($file_name, $image);
                            $request['profile_image'] = $file_name;
                        }
                    }

                    $update = Dietician::where('id', $user_id)->update($request->only('name', 'profile_image'));
                    if ($update) {
                        $this->error_code = 0;
                    } else {
                        $this->response = "not uploaded";
                    }

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
