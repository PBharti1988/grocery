<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminModule;
use App\AdminModulePrivilege;
use App\UserModuleConfig;
use Auth;
use DB;

class AdminModulePrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

	    if(Auth::guard('restaurant')->id())
	    {
	        $rest_id= Auth::guard('restaurant')->id();
	    }
        else
        {
            return redirect('admin');
        }

  //       $module =AdminModule::select('admin_modules.module_name','admin_module_privileges.*')
  //       ->LeftJoin('admin_module_privileges','admin_modules.module_slug','admin_module_privileges.module_slug')
  //       ->where('admin_modules.enabled',1)
  //       ->where('admin_module_privileges.restaurant_id',$rest_id)
  //       ->get();
   

		$module =AdminModule::where('enabled',1)->get();
		$modulePrivileges =AdminModulePrivilege::where('restaurant_id',$rest_id)->get();

		$modulePrivileges1 = array();

		$modulePrivileges = $modulePrivileges->toArray();		
		foreach ($modulePrivileges as $key => $modulePrivilege) {

			$modulePrivileges['ut_'.$modulePrivilege['user_type']]=$modulePrivilege;
			// unset($modulePrivileges[$key]);
			
			if($modulePrivilege['user_type']==1)
			{
				$modulePrivileges1[$modulePrivilege['user_type']][$modulePrivilege['module_slug']]=$modulePrivilege;			
			}
			if($modulePrivilege['user_type']==2)
			{
				$modulePrivileges1[$modulePrivilege['user_type']][$modulePrivilege['module_slug']]=$modulePrivilege;			
			}
		}
		// print_r($modulePrivileges1);
		$modulePrivileges=$modulePrivileges1;
        return view('admin.admin-module-priviledge.index',compact('module','no_records','modulePrivileges'));

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


    public function adminPriviledgeUpdate(Request $request){
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
    
	    if(Auth::guard('restaurant')->id())
	    {
	        $rest_id= Auth::guard('restaurant')->id();
	    }
	    // else if(Auth::guard('manager')->id())
	    // {
	    //    $manager = Auth::guard('manager')->user();
	    //    $rest_id=$manager->restaurant_id;
	    // }
        else
        {
            return redirect('admin');
        }

        $rest_id = $rest_id;
        $id = $request->id;
        $module_slug = $request->slug;
        $user_type = $request->type;
        $role1 = $request->role1;
        $role2 = $request->role2;
        $role3 = $request->role3;
    
        $update = AdminModulePrivilege::updateOrCreate(
				    ['module_slug' => $module_slug,'restaurant_id'=>$rest_id,'user_type'=>$user_type],
				    ['view' =>$role1,'create'=>$role2,'update'=>$role3]
				);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }

}
