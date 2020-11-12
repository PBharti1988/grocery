<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\ShelfOffer;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShelfController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function offers(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $shelf_id = $request->shelf_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "shelf_id" => "required",
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
                $offers = ShelfOffer::where('enabled','1')
                ->where('shelf_id',$shelf_id)
                ->where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->get();
                if ($offers) {
                    foreach($offers as $offer){
                        $offer->offer_image = url('/public/assets/images/shelf-offers/'.$offer->offer_image);
                    }
                    $this->response = $offers;
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
}
