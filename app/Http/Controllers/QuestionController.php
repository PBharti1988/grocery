<?php

namespace App\Http\Controllers;
use App\Question;
use App\QuestionOption;
use App\QuestionType;
use Auth; 
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $question=Question::paginate(10);
        //$res_id = Auth::guard('restaurant')->id();   
        if(Auth::guard('restaurant')->id())
            {
             $res_id= Auth::guard('restaurant')->id();
            }
             else if(Auth::guard('manager')->id())
             {
              $manager = Auth::guard('manager')->user();
               $res_id=$manager->restaurant_id;
                }
              else{
                return redirect('admin');
             }    
        $question=Question::where('restaurant_id',$res_id)->paginate();
        return view('admin.questions.index',compact('question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type=QuestionType::get();
        return view('admin.questions.create',compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $type =$request->question_type;
        if($type == 1){
            $this->validate($request, [
                'question_type' => 'required',
                'question' => 'required',           
            ]);
            
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $request['question_type_id'] = $request->question_type;
                
                if(Auth::guard('restaurant')->id())
                {
                    $request['restaurant_id'] = Auth::guard('restaurant')->id();
                }
                 else if(Auth::guard('manager')->id())
                 {
                  $manager = Auth::guard('manager')->user();
                  $request['restaurant_id']=$manager->restaurant_id;
                    }
                  else{
                    return redirect('admin');
                 }
          //  $request['restaurant_id'] = Auth::guard('restaurant')->id();
            $question= Question::create($request->only('restaurant_id','question_type_id','question','enabled'));
           
               $option =$request->option_name;

               $count =count($option);
               for($i=0;$i<=$count -1;$i++){
                   $array=array(
                       'question_id'=>$question->id,
                       'options'=>$option[$i]
                   );
                   QuestionOption::insert($array);
               }

        }else if($type == 2){
            $this->validate($request, [
                'question_type' => 'required',
                'question' => 'required',           
            ]);
            
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $request['question_type_id'] = $request->question_type;
           // $request['restaurant_id'] = Auth::guard('restaurant')->id();
           if(Auth::guard('restaurant')->id())
           {
               $request['restaurant_id'] = Auth::guard('restaurant')->id();
           }
            else if(Auth::guard('manager')->id())
            {
             $manager = Auth::guard('manager')->user();
             $request['restaurant_id']=$manager->restaurant_id;
               }
             else{
               return redirect('admin');
            } 
            $question= Question::create($request->only('restaurant_id','question_type_id','question','enabled'));
           
               $option =$request->option_name;

               $count =count($option);
               for($i=0;$i<=$count -1;$i++){
                   $array=array(
                       'question_id'=>$question->id,
                       'options'=>$option[$i]
                   );
                   QuestionOption::insert($array);
               }

        }else{
            $this->validate($request, [
                'question_type' => 'required',
                'question' => 'required',           
            ]);
            
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $request['question_type_id'] = $request->question_type;
           // $request['restaurant_id'] = Auth::guard('restaurant')->id();
           if(Auth::guard('restaurant')->id())
           {
               $request['restaurant_id'] = Auth::guard('restaurant')->id();
           }
            else if(Auth::guard('manager')->id())
            {
             $manager = Auth::guard('manager')->user();
             $request['restaurant_id']=$manager->restaurant_id;
               }
             else{
               return redirect('admin');
            }
             Question::create($request->only('restaurant_id','question_type_id','question','enabled'));
        }

        return redirect('question')->with('success', 'Record added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        $options = QuestionOption::where('question_id', $id)->orderBy('id', 'ASC')->get();
        return view('admin.questions.show', compact('question', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type=QuestionType::get();
        $question =Question::find($id);
        $options =QuestionOption::where('question_id',$id)->get();
        return view('admin.questions.edit',compact('type','question','options'));
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
        // dd($request->all());
        $type =$request->type;
        if($type == 1){
            $this->validate($request, [
                'question' => 'required',           
            ]);
            
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $question= Question::where('id',$id)->update($request->only('question','enabled'));
           
             

            $update_id = $request->option_id;

            if (!empty($update_id)) {

                $len = count($request->option_id);
                for ($i = 0; $i <= $len - 1; $i++) {
                  if(isset($request->option_name[$i])){
                    $title = $request->option_name[$i];
                    $main_id = $request->option_id[$i];
                    $array = array(
                        "options" => $title,

                    );
                    QuestionOption::find($main_id)->update($array);
                }
                }
             
              
              QuestionOption::WhereNotIn('id', $update_id)->where('question_id',(int)$id)->delete();
               
            }


            //    $option_id=$request->option_id;

            //    if(!empty($option_id)){
            //    $count =count($option_id);
            //    for($i=0;$i<=$count-1;$i++){
                  
            //     $op_name =$request->option_name[$i];
            //        $array=array(
            //            'options'=>$op_name,
            //        );
            //        QuestionOption::where('id',$option_id[$i])->update($array);
            //    }
            //    QuestionOption::WhereNotIn('id', $option_id)->where('question_id', $id)->delete();
            // }


           // $name_option =$request->option_name;

            $title_desc = $request->option_name;
            if ($title_desc != null) {
                $count_title = count($request->option_name);
                if ($request->option_id != null) {
                    $all_count = count($request->option_id);
                } else {
                    $all_count = 0;
                }

                for ($j = $all_count; $j <= $count_title - 1; $j++) {
                    $array1 = array(
                        "question_id" => $id,
                        "options" => $request->option_name[$j],
                    );
                    QuestionOption::create($array1);
                }
            }

        }else if($type == 2){
            $this->validate($request, [
                'question' => 'required',           
            ]);
            
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $question= Question::where('id',$id)->update($request->only('question','enabled'));
           
             

            $update_id = $request->option_id;

            if (!empty($update_id)) {

                $len = count($request->option_id);
                for ($i = 0; $i <= $len - 1; $i++) {
                  if(isset($request->option_name[$i])){
                    $title = $request->option_name[$i];
                    $main_id = $request->option_id[$i];
                    $array = array(
                        "options" => $title,

                    );
                    QuestionOption::find($main_id)->update($array);
                }
                }
             
              
              QuestionOption::WhereNotIn('id', $update_id)->where('question_id',(int)$id)->delete();
               
            }
        

            $title_desc = $request->option_name;
            if ($title_desc != null) {
                $count_title = count($request->option_name);
                if ($request->option_id != null) {
                    $all_count = count($request->option_id);
                } else {
                    $all_count = 0;
                }

                for ($j = $all_count; $j <= $count_title - 1; $j++) {
                    $array1 = array(
                        "question_id" => $id,
                        "options" => $request->option_name[$j],
                    );
                    QuestionOption::create($array1);
                }
            }



        }else{
            $this->validate($request, [
                'question' => 'required',           
            ]);
            
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
          //  $request['question_type_id'] = $request->question_type;
             Question::where('id',$id)->update($request->only('question','enabled'));
        }

        return redirect('question')->with('success', 'Record added successfully');

        
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

    public function questionAction(Request $request)
    {

        $id = $request->id;
        $action = $request->action;

        $update = Question::find($id)->update(['enabled' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }
}
