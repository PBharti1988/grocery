<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\ItemImage;
use App\Restaurant;
use App\ItemDescription;
use DB;
use App\Feedback;
use App\Question;
use App\QuestionAnswer;
use App\QuestionOption;
use Auth;

class AdminFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    


    public function index(Request $request)
    {
         //$id =Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'feedback');
  
          if(isset($perms))
          {
            if($perms->view)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }

        }
        else{
          return redirect('admin');
        }


        $feedbacks =Feedback::where('restaurant_id',$id)->paginate(10);
         return view('admin.feedback.index',compact('feedbacks'));
          
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(Auth::guard('restaurant')->id())
        {
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'feedback');
  
          if(isset($perms))
          {
            if($perms->view)
            {}
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }

        }
        else{
          return redirect('admin');
        }


        $feedback =Feedback::where('id',$id)->first();

        $questions =QuestionAnswer::select('question_answers.*','questions.question')
        ->join('questions','questions.id','question_answers.question_id')
        ->where('question_answers.feedback_id',$id)->get();
        
        foreach($questions as $val){
             $options =QuestionOption::where(['id'=>$val->option_id,'question_id'=>$val->question_id])->first();
             $val->real_answer =$options->options;
        }
        
        return view('admin.feedback.show',compact('feedback','questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
