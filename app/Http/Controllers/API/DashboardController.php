<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
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
                $banners = Banner::where('enabled', '1')->orderBy('sort_order', 'ASC')->get();
                $banner1 = null;
                $banner2 = null;
                $banner3 = null;
                // if($banners){
                //     // $data = array(
                //     //     'banner1'=>'https://cdn.pixabay.com/photo/2014/10/28/22/19/supermarket-507295_960_720.jpg',
                //     //     'banner2'=>'https://cdn.pixabay.com/photo/2019/12/09/06/00/black-friday-4682673_960_720.png',
                //     //     'banner3'=>'https://cdn.pixabay.com/photo/2017/10/30/19/07/online-2903230_960_720.png',
                //     // );
                //     $banner1 = url('public/assets/images/banners', $banners[0]->banner);
                //     $banner2 = url('public/assets/images/banners', $banners[1]->banner);
                //     $banner3 = url('public/assets/images/banners', $banners[2]->banner);
                // }
                // $data = array(
                //     'banner1'=>$banner1,
                //     'banner2'=>$banner2,
                //     'banner3'=>$banner3,
                // );

                if($banners){
                    foreach($banners as $banner){
                        $banner->banner = url('public/assets/images/banners', $banner->banner);
                    }
                    $this->response = $banners;
                }
                else{
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
}
