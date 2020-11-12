<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\Poll;
use App\PollOption;
use App\PollVote;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

    public function create(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $title = $request->title;
        $options = $request->options;
        // Add rules
        $rules = [
            "user_id" => "required",
            "title" => "required",
            "options" => "required",
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
                $poll = Poll::create($request->only('user_id', 'title'));
                if ($poll) {
                    $options = $request->options;
                    foreach ($options as $key=>$value) {
                        $options[$key]['question_id'] = $poll->id;
                    }
                    $poll_options = PollOption::insert($options);
                    if ($poll_options) {
                        $this->error_code = 0;
                    } else {
                        $this->error_code = -100;
                    }
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
                $polls = Poll::where('enabled','1')->get();
                if ($polls) {
                    $this->response = $polls;
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
        $question_id = $request->question_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "question_id" => "required",
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
                $poll = Poll::find($question_id);
                if ($poll) {
                    $poll_options = PollOption::where('question_id', $question_id)->orderBy('option_number', 'ASC')->get(['id', 'option_name']);
                    $poll->options = $poll_options;
                    $this->response = $poll;
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

    public function result(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $question_id = $request->question_id;
        // Add rules
        $rules = [
            "user_id" => "required",
            "question_id" => "required",
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
                $polls = Poll::find($question_id);
                if ($polls) {
                    $participants = PollVote::where('question_id', $question_id)->distinct('voter_id')->count('voter_id');

                    $poll_options = PollOption::where('question_id', $question_id)->orderBy('option_number', 'ASC')->get(['id', 'option_name']);

                    $polls->participants = $participants;

                    foreach ($poll_options as $key => $value) {
                        $votes = PollVote::where('question_id', $question_id)->where('option_id', $value->id)->distinct('voter_id')->count('voter_id');
                        $poll_options[$key]['votes'] = $votes;
                    }

                    $polls->options = $poll_options;
                    $this->response = $polls;
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

    public function vote(Request $request)
    {
        // Receive all request
        $question_id = $request->question_id;
        $voter_id = $request->voter_id;
        $option_id = $request->option_id;
        // Add rules
        $rules = [
            "question_id" => "required",
            "voter_id" => "required",
            "option_id" => "required",
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
            $user_exists = AppUser::where('id', $request->voter_id)->first();
            if ($user_exists) {
                $poll_vote = PollVote::create($request->only('question_id', 'voter_id', 'option_id'));
                if ($poll_vote) {
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
