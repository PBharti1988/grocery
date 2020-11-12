<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\Survey;
use App\SurveyAnswer;
use App\SurveyOption;
use App\SurveyQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
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
                $current_date = Carbon::today()->startOfDay();
                $surveys = Survey::where('enabled', '1')
                ->where('start_date', '<=', $current_date)
                ->where('end_date', '>=', $current_date)
                ->get();
                if ($surveys->count() > 0) {
                    $this->response = $surveys;
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

    public function view(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $survey_id = $request->survey_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "survey_id" => "required",
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
                $survey = Survey::find($survey_id);
                if ($survey) {
                    $survey_questions = SurveyQuestion::where('survey_id', $survey_id)->orderBy('question_number', 'ASC')->get(['id', 'question_name', 'question_type']);
                    if ($survey_questions) {
                        foreach ($survey_questions as $key => $value) {
                            $question_id = $value->id;
                            $question_type = $value->question_type;
                            if ($question_type == 'objective' || $question_type == 'mcq') {
                                $survey_options = SurveyOption::where('survey_id', $survey_id)->where('question_id', $question_id)->orderBy('option_number', 'ASC')->get(['id', 'option_name']);
                                $survey_questions[$key]['options'] = $survey_options;
                            }
                        }
                    }
                    $survey->questions = $survey_questions;
                    $this->response = $survey;
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

    public function answer(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $survey_id = $request->survey_id;
        $answers = $request->answers;
        // Add rules
        $rules = [
            "user_id" => "required",
            "survey_id" => "required",
            "answers" => "required",
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
                $answers = $request->answers;
                foreach ($answers as $key => $value) {
                    $answers[$key]['survey_id'] = $survey_id;
                    $answers[$key]['user_id'] = $user_id;
                    $answers[$key]['created_at'] = Carbon::now();
                }
                $survey_answers = SurveyAnswer::insert($answers);
                if ($survey_answers) {
                    $this->error_code = 0;
                } else {
                    $this->error_code = -100;
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
