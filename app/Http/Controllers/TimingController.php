<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Day;
use App\Timing;
use Auth;
class TimingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $res_id = Auth::guard('restaurant')->id();
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

        $days=Day::get();
        foreach($days as $val){
            $check =Timing::where(['restaurant_id'=>$res_id,'day_id'=>$val->id])->first();
            if(!$check){
                Timing::insert(['day_id'=>$val->id,'restaurant_id'=>$res_id]);
            }
            
        }

        $timing =Timing::select('timings.*','days.day_name')
        ->join('days','days.id','timings.day_id')
        ->where('timings.restaurant_id',$res_id)->get();
       
        return view('admin.timing.index',compact('timing'));
    }


    public function UpdateTiming(Request $request){


      $id=$request->id;
      $open_time =$request->open_time;
      $close_time =$request->close_time;
      $break_on =$request->break_on;
      $break_off =$request->break_off;
      $week_off =$request->week_off;
        
       // $res_id = Auth::guard('restaurant')->id();
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
        $update = Timing::where(['restaurant_id'=>$res_id,'id'=>$id])->update(['closing_time'=>$close_time,'opening_time'=>$open_time,'break_time_from'=>$break_on,'break_time_to'=>$break_off,'week_off'=>$week_off]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);

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
        //
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
