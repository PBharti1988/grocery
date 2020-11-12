<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\StoreCity;
use App\StoreCityArea;
use DB;
use Auth;

class SliderOptionController extends Controller
{
    //

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

     
        $areas=Slider::where('restaurant_id',$res_id)->paginate(10);
        return view('admin.slider.index',compact('areas','res_id'));
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

        // $city=StoreCity::where('restaurant_id',$res_id)->first();

        return view('admin.slider.create');
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
            'slider_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
         //$res_id = Auth::guard('restaurant')->id();
          
         $check_name = Slider::where([
         
            ['slider_name', $request->slider_name],
            ['restaurant_id', $res_id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Slider Name is already exists');
        }

           $enabled = $request->enabled == 'on' ? 1 : 0;
           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;

           $request['status'] = 2;
          
           $request['restaurant_id']=$res_id;

           if ($request->hasFile('slider_img')) {
            $file = $request->file('slider_img');
            $fileName = uniqid('icon')  . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/slider', $fileName);
            $request['icon'] = $fileName;
        }

        // print_r($request['icon']);exit();

           Slider::insert($request->only('restaurant_id','slider_name','start_date','end_date','icon','section_order','status','enabled'));
           return redirect('slider')->with('success', 'added successfully')->with('res_id',$res_id);
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

        $area = Slider::find($id);
        return view('admin.slider.edit',compact('area'));
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
            'slider_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        // $res_id = Auth::guard('restaurant')->id();
          
         $check_name = Slider::where([
            // ['tax_name', ucwords(strtolower($request->tax_name))],
            ['slider_name', $request->slider_name],
            ['restaurant_id', $res_id],
	        ['id', '!=', $id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Slider is already exists');
        }

           $enabled = $request->enabled == 'on' ? 1 : 0;
           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;

        if ($request->hasFile('slider_img')) {
            $file = $request->file('slider_img');
            $fileName = uniqid('icon') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/slider', $fileName);
            $request['icon'] = $fileName;
        }else{

        	$fileName = $request->input('tempfile_img');
        	$request['icon'] = $fileName;
          
        }

           Slider::where('id',$id)->update($request->only('restaurant_id','slider_name','start_date','end_date','icon','section_order','enabled'));
           return redirect('slider')->with('success', 'updated successfully')->with('res_id',$res_id);
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

}
