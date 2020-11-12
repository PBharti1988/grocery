<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\ForumDiscussion;
use App\ForumLike;
use App\ForumReportSpam;
use App\ForumView;
use App\ForumPost;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscussionActionController extends Controller
{
    public function __construct()
    {
        $this->error_code = 0;
        $this->response = null;
    }

    public function likes(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $discussion_id = $request->discussion_id;

        // Add rules
        $rules = [
            "user_id" => "required",
            "discussion_id" => "required",

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
        // Process data
        try {
            DB::transaction(function () use ($request) {
                $checkUser = AppUser::where('id', $request->user_id)->first();
                if ($checkUser) {
                    $discussion = ForumDiscussion::find($request->discussion_id);
                    if ($discussion) {
                        $check_liked = ForumLike::where(['user_id' => $request->user_id, 'discussion_id' => $request->discussion_id])->first();
                        if ($check_liked) {
                            $this->error_code = -120;
                        } else {
                            $likes = $discussion->likes + 1;
                            $updated_like = ForumDiscussion::where('id', $request->discussion_id)->update(['likes' => $likes]);
                            if ($updated_like) {
                                ForumLike::create(['discussion_id' => $request->discussion_id, 'user_id' => $request->user_id]);
                                $this->error_code = 0;
                            } else {
                                $this->error_code = -100;
                            }
                        }
                    } else {
                        $this->error_code = -100;
                    }
                } else {
                    $this->error_code = -105;
                }
            });
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

    public function views(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $discussion_id = $request->discussion_id;

        // Add rules
        $rules = [
            "user_id" => "required",
            "discussion_id" => "required",

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
        // Process data
        try {
            DB::transaction(function () use ($request) {
                $checkUser = AppUser::where('id', $request->user_id)->first();
                if ($checkUser) {
                    $discussion = ForumDiscussion::find($request->discussion_id);
                    if ($discussion) {
                        $check_view = ForumView::where(['user_id' => $request->user_id, 'discussion_id' => $request->discussion_id])->first();
                        if (!$check_view) {
                            $views = $discussion->views + 1;
                            $updated_view = ForumDiscussion::where('id', $request->discussion_id)->update(['views' => $views]);
                            if ($updated_view) {
                                ForumView::create(['discussion_id' => $request->discussion_id, 'user_id' => $request->user_id]);
                            }
                        }

                        $discussion_details = ForumDiscussion::select(
                            'forum_discussion.id',
                            'forum_discussion.title',
                            'forum_discussion.likes',
                            'forum_discussion.views',
                            'forum_discussion.comments',
                            'forum_post.body'
                        )
                            ->join('forum_post', 'forum_post.discussion_id', 'forum_discussion.id')
                            ->first();
                        $this->response = $discussion_details;
                    } else {
                        $this->error_code = -100;
                    }
                } else {
                    $this->error_code = -105;
                }
            });
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

    public function reportSpam(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $discussion_id = $request->discussion_id;

        // Add rules
        $rules = [
            "user_id" => "required",
            "discussion_id" => "required",

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
        // Process data
        try {
            DB::transaction(function () use ($request) {
                $checkUser = AppUser::where('id', $request->user_id)->first();
                if ($checkUser) {
                    $discussion = ForumDiscussion::find($request->discussion_id);
                    if ($discussion) {
                        $checkSpam = ForumReportSpam::where(['user_id' => $request->user_id, 'discussion_id' => $request->discussion_id])->first();
                        if ($checkSpam) {
                            $this->error_code = -121;
                        } else {
                            $spam = $discussion->report_spam + 1;
                            $update_spam = ForumDiscussion::where('id', $request->discussion_id)->update(['report_spam' => $spam]);
                            if ($update_spam) {
                                ForumReportSpam::create(['discussion_id' => $request->discussion_id, 'user_id' => $request->user_id]);
                                $this->error_code = 0;
                            } else {
                                $this->error_code = -100;
                            }
                        }

                    } else {
                        $this->error_code = -100;
                    }
                } else {
                    $this->error_code = -105;
                }
            });
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

    //Discussion Comments
    public function commentDiscussion(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        $discussion_id = $request->discussion_id;
        $comment = $request->comment;

        // Add rules
        $rules = [
            "user_id" => "required",
            "discussion_id" => "required",
            "comment" => "required",

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
        // Process data
        try {
            DB::transaction(function () use ($request) {
                $checkUser = AppUser::where('id', $request->user_id)->first();
                if ($checkUser) {
                    $discussion = ForumDiscussion::find($request->discussion_id);
                    if ($discussion) {
                        $comments = $discussion->comments + 1;
                        $comment_updated = ForumDiscussion::find($discussion->id)->update(['comments' => $comments]);
                        if ($comment_updated) {
                            FormPost::create(['discussion_id'=>$request->discussion_id,'user_id'=>$request->user_id,'body'=>$request->comment]);
                       
                             $this->error_code =0;
                        } else {
                            $this->error_code = -100;
                        }
                    } else {
                        $this->error_code = -100;
                    }
                } else {
                    $this->error_code = -105;
                }
            });
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
