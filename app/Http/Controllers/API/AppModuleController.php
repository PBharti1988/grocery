<?php

namespace App\Http\Controllers\API;

use App\AppModule;
use App\AppUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppModuleController extends Controller
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

        try {
            $checkUser = AppUser::where('id',$user_id)->first();
            if($checkUser){        
            $data = AppModule::whereNull('parent_id')->select('id', 'parent_id', 'module_name', 'module_icon', 'display_name', 'serial_no')->get();
            foreach ($data as $module) {
                $data1 = AppModule::where('parent_id', $module->id)->select('id', 'parent_id', 'module_name', 'module_icon', 'display_name', 'serial_no')->get();
                foreach ($data1 as $module1) {
                    $module[$module->module_name] = $data1;
                    $data2 = AppModule::where('parent_id', $module1->id)->select('id', 'parent_id', 'module_name', 'module_icon', 'display_name', 'serial_no')->get();
                    foreach ($data2 as $module2) {
                        $module1[$module1->module_name] = $data2;
                    }
                }
            }

            if ($data) {
                $this->response = $data;
            } else {
                $this->error_code = -101;
            }
            }else{
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
