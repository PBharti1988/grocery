<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreCity;
use App\StoreCityArea;
use DB;
use Auth;

class StoreLocationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //$res_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'tax');

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

        $city=StoreCity::where('restaurant_id',$res_id)->first();
        if(!$city)
        {
        	$city['city_name']='';
        	$city['enabled']='';
        	$city = (object)$city;
        }
        $areas=StoreCityArea::where('restaurant_id',$res_id)->paginate(10);
        return view('admin.store-location.index',compact('city','areas','res_id'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'tax');

            if(isset($perms))
            {
                if($perms->create)
                {}
                else{
                  return view('admin.nopermission')->with('error', 'Permission Denied');
                }         
            }
        }
        else{
            return redirect('admin');
        }

        $city=StoreCity::where('restaurant_id',$res_id)->first();

        return view('admin.store-location.create',compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'tax');

            if(isset($perms))
            {
                if($perms->create)
                {}
                else{
                  return view('admin.nopermission')->with('error', 'Permission Denied');
                }         
            }
        }
        else{
            return redirect('admin');
        }

        $this->validate($request, [
            'area_name' => 'required',
            'city_name' => 'required',
        ]);
         //$res_id = Auth::guard('restaurant')->id();
          
         $check_name = StoreCityArea::where([
            // ['tax_name', ucwords(strtolower($request->tax_name))],
            ['area_name', $request->area_name],
            ['city_name', $request->city_name],
            ['restaurant_id', $res_id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Area is already exists');
        }

           $enabled = $request->enabled == 'on' ? 1 : 0;
           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           StoreCityArea::insert($request->only('restaurant_id','area_name','city_name','enabled'));
           return redirect('storelocation')->with('success', 'added successfully')->with('res_id',$res_id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'tax');

            if(isset($perms))
            {
                if($perms->update)
                {}
                else{
                  return view('admin.nopermission')->with('error', 'Permission Denied');
                }         
            }
        }
        else{
            return redirect('admin');
        }

        $area = StoreCityArea::find($id);
        return view('admin.store-location.edit',compact('area'));
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
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'tax');

            if(isset($perms))
            {
                if($perms->update)
                {}
                else{
                  return view('admin.nopermission')->with('error', 'Permission Denied');
                }         
            }
        }
        else{
            return redirect('admin');
        }

        $this->validate($request, [
            'area_name' => 'required',
            'city_name' => 'required',
        ]);
        // $res_id = Auth::guard('restaurant')->id();
          
         $check_name = StoreCityArea::where([
            // ['tax_name', ucwords(strtolower($request->tax_name))],
            ['area_name', $request->area_name],
            ['city_name', $request->city_name],
            ['restaurant_id', $res_id],
	        ['id', '!=', $id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Area is already exists');
        }

           $enabled = $request->enabled == 'on' ? 1 : 0;
           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           StoreCityArea::where('id',$id)->update($request->only('area_name','city_name','enabled'));
           return redirect('storelocation')->with('success', 'updated successfully')->with('res_id',$res_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cityupdate(Request $request)
    {
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'tax');

            if(isset($perms))
            {
                if($perms->create)
                {}
                else{
                  return view('admin.nopermission')->with('error', 'Permission Denied');
                }         
            }
        }
        else{
            return redirect('admin');
        }

        $this->validate($request, [
            'city_name' => 'required',
        ]);
         //$res_id = Auth::guard('restaurant')->id();
          
   		 $enabled = $request->enabled == 'on' ? 1 : 0;
         $check_name = StoreCity::where([
            // ['tax_name', ucwords(strtolower($request->tax_name))],
            ['city_name', $request->city_name],
            ['restaurant_id', $res_id],
            ['enabled', $enabled],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'City is already exists');
        }

           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           StoreCity::updateOrCreate(['restaurant_id'=>$res_id],['city_name'=>$request->city_name,'enabled'=>$enabled]);
           return redirect('storelocation')->with('success', 'Updated successfully')->with('res_id',$res_id);
    }



}
