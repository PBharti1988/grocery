<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\RoleModule;
use App\UserModuleConfig;
class PriviledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module =RoleModule::select('role_modules.*','modules.module_name')
        ->join('modules','modules.id','role_modules.module_id')
        ->get();
          
        return view('superadmin.priviledge.index',compact('module'));
    }


    public function moduleConfig(Request $request,$id)
    {
        $id=$id;
        $modules =Module::where('enabled',1)->get();
        foreach($modules as $val){
            $check_module=UserModuleConfig::where(['restaurant_id'=>$id,'module_id'=>$val->id])->first();
            if(!$check_module){
                UserModuleConfig::create(['restaurant_id'=>$id,'module_id'=>$val->id]);
            }
        }
        $module=UserModuleConfig::select('user_module_config.*','modules.module_name')
        ->join('modules','modules.id','user_module_config.module_id')
        ->where('user_module_config.restaurant_id',$id)->get();
        
        return view('superadmin.priviledge.restaurant-priviledge',compact('module','id'));
    }


    public function restaurantPriviledgeUpdate(Request $request){
       $id=$request->id;
       $action =$request->action;
        $update = UserModuleConfig::where('id',$id)->update(['status' =>$action]);
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


    public function priviledgeAction(Request $request)
    {
    
        $id = $request->id;
        $role1 = $request->role1;
        $role2 = $request->role2;
        $role3 = $request->role3;
        $role4 = $request->role4;
        $role5 = $request->role5;
    
        $update = RoleModule::where('id',$id)->update(['role_type_1' =>$role1,'role_type_2'=>$role2,'role_type_3'=>$role3,'role_type_4'=>$role4,'role_type_5'=>$role5]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }

}
