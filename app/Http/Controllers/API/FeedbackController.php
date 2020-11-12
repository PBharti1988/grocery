<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\FeedbackApp;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }
    public function add(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $emoji_rating = $request->emoji_rating;
        $comments = $request->comments;
        // Add rules
        $rules = [
            "user_id" => "required",
            "emoji_rating" => "required",
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
        try {
            $user_exists = AppUser::where('id', $request->user_id)->first();
            if ($user_exists) {
                $feedback = FeedbackApp::updateOrCreate(
                    ['user_id' => $request->user_id],
                    ['emoji_rating' => $request->emoji_rating,'comments'=>$request->comments]
                );
                if ($feedback) {
                    $this->error_code = 0;
                } else {
                    $this->error_code = -100;
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
