<?php

namespace App\Http\Controllers\API;

use App\AppUser;
use App\ForumDiscussion;
use App\ForumPost;
use App\ForumView;
use App\ForumLike;
use App\ForumReportSpam;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForumDiscussionController extends Controller
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
        $mode = $request->mode;
        // Add rules
        $rules = [
            "user_id" => "required",
            "mode" => "required",
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
                $month = Carbon::now()->subDays(30)->toDateTimeString();
                if($mode == 'popular'){
                $form_discussions = ForumDiscussion::where('enabled','1')->orderBy('likes','DESC')->get();
                }elseif($mode == 'archive'){
                    
                $form_discussions = ForumDiscussion::where('enabled','1')->where('created_at','<',$month)->get();
                }else{
                    $form_discussions = ForumDiscussion::where('enabled','1')->get();
                }

                if ($form_discussions) {
                    $this->response = $form_discussions;
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

    public function create(Request $request)
    {
        // Receive all request
        $user_id = $request->user_id;
        //$category_id = $request->category_id;
        $title = $request->title;
        //$tags = $request->tags;
        $body = $request->body;
        // Add rules
        $rules = [
            "user_id" => "required",
            //"category_id" => "required",
            "title" => "required",
            //"tags" => "required",
            "body" => "required",
        ];
        // Set validation message
        $messages = [
            //'category_id.required' => 'The category is required.',
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
                $user_exists = AppUser::where('id', $request->user_id)->first();
                if ($user_exists) {
                    $request['slug'] = str::slug($request->title);
                    $forum_discussion = ForumDiscussion::create($request->only('user_id', 'title', 'slug'));
                    if ($forum_discussion) {
                        $forum_post = ForumPost::create(['user_id' => $request->user_id, 'discussion_id' => $forum_discussion->id, 'body' => $request->body]);
                        if ($forum_post) {
                            $this->error_code = 0;
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

    public function like(Request $request)
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
            DB::transaction(function () use ($request) {
                $user_exists = AppUser::where('id', $request->user_id)->first();
                if ($user_exists) {
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

    public function view(Request $request)
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
                $user_exists = AppUser::where('id', $request->user_id)->first();
                if ($user_exists) {
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
                             ->join('forum_post','forum_post.discussion_id','forum_discussion.id')                           
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

    public function comment(Request $request)
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
            DB::transaction(function () use ($request) {
                $user_exists = AppUser::where('id', $request->user_id)->first();
                if ($user_exists) {
                    $discussion = ForumDiscussion::find($request->discussion_id);
                    if ($discussion) {
                        $comments = $discussion->comments + 1;
                        $comment_updated = ForumDiscussion::find($discussion->id)->update(['comments' => $comments]);
                        if ($comment_updated) {
                            ForumPost::create(['discussion_id'=>$request->discussion_id,'user_id'=>$request->user_id,'body'=>$request->comment]);
                           // ForumComment::create(['user_id' => $request->user_id, 'discussion_id' => $request->discussion_id, 'comment' => $request->comment]);
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
                $user_exists = AppUser::where('id', $request->user_id)->first();
                if ($user_exists) {
                    $discussion = ForumDiscussion::find($request->discussion_id);
                    if ($discussion) {
                      $checkSpam =ForumReportSpam::where(['user_id'=>$request->user_id,'discussion_id'=>$request->discussion_id])->first();
                      if($checkSpam){
                        $this->error_code = -121;
                      }else{
                          $spam = $discussion->report_spam + 1;
                          $update_spam = ForumDiscussion::where('id', $request->discussion_id)->update(['report_spam' => $spam]);
                          if($update_spam){
                            ForumReportSpam::create(['discussion_id' => $request->discussion_id, 'user_id' => $request->user_id]);
                            $this->error_code = 0;
                          }else{
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
}
