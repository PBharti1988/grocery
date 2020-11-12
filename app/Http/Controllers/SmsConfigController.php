<?php

namespace App\Http\Controllers;
use Auth;
use App\SmsConfig;
use App\SmsType;
use Illuminate\Http\Request;

class SmsConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $sms=SmsType::get();
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
        foreach($sms as $val){
            $check = SmsConfig::where(['restaurant_id'=>$res_id,'sms_type'=>$val->id])->first();
            if(!$check){
               SmsConfig::create(['restaurant_id'=>$res_id,'sms_type'=>$val->id]);
            }
        }

        $sms1 =SmsConfig::where(['restaurant_id'=>$res_id,'sms_type'=>1])->first();
        $sms2 =SmsConfig::where(['restaurant_id'=>$res_id,'sms_type'=>2])->first();
      

        $config = SmsConfig::select('sms_config.*','sms_types.type')
         ->join('sms_types','sms_types.id','sms_config.sms_type')
         ->where(['sms_config.restaurant_id'=>$res_id])->get();
        
        return view('admin.sms-config.index',compact('sms1','sms2','res_id','config'));
    }


    public function SmsDetailStore(Request $request){
        $sms_type = $request->sms_type;
        $key1 = $request->key_1;
        $key2 = $request->key_2;
        $res_id =$request->restaurant_id;
        $active = $request->active == 'on' ? 1 : 0;
       // $live_mode =$request->live_mode == 'on' ? 1 : 0;

      
         if($active == 1){
        $check_active = SmsConfig::where([
           ['active',1],
           ['restaurant_id', $res_id],
           ['sms_type', '!=', $sms_type],
          ])->first();

          if ($check_active) {
           return redirect()->back()->withInput($request->input())->with('error', 'Cannot activate two sms at same time');
       }
   }

        $array=array(
            'key_1'=> $key1,
            'key_2'=> $key2,
            'active'=>$active,
        );
       
        SmsConfig::where(['restaurant_id'=>$res_id,'sms_type'=>$sms_type])->update($array);
      

       return redirect()->back()->withInput($request->input())->with('success', 'updated successfully');
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
