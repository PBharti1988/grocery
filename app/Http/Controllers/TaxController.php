<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;
use App\Restaurant;
use Auth;
class TaxController extends Controller
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

        $tax=Tax::where('restaurant_id',$res_id)->paginate(10);
        return view('admin.taxes.index',compact('tax','res_id'));
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


        return view('admin.taxes.create');
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
            'tax_name' => 'required',
            'tax_value' => 'required',
        ]);
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
          
         $check_name = Tax::where([
            // ['tax_name', ucwords(strtolower($request->tax_name))],
            ['tax_name', $request->tax_name],
            ['restaurant_id', $res_id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Tax Name already exists');
        }

           $enabled = $request->enabled == 'on' ? 1 : 0;
           $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           Tax::insert($request->only('restaurant_id','tax_name','tax_value','enabled'));
           return redirect('tax')->with('success', 'added successfully')->with('res_id',$res_id);
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

        $tax = Tax::find($id);
        return view('admin.taxes.edit',compact('tax'));
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
            'tax_name' => 'required',
            'tax_value' => 'required',
        ]);
        // $res_id = Auth::guard('restaurant')->id();
         if(Auth::guard('restaurant')->id()){
            $res_id= Auth::guard('restaurant')->id();
            }
            else{
               $manager = Auth::guard('manager')->user();
               $res_id=$manager->restaurant_id;
            }
          
         $check_name = Tax::where([
            // ['tax_name', ucwords(strtolower($request->tax_name))],
            ['tax_name', $request->tax_name],
            ['restaurant_id', $res_id],
             ['id', '!=', $id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Tax Name already exists');
        }

           $enabled = $request->enabled == 'on' ? 1 : 0;
           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           Tax::where('id',$id)->update($request->only('tax_name','tax_value','enabled'));
           return redirect('tax')->with('success', 'updated successfully')->with('res_id',$res_id);
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

    public function taxAction(Request $request)
    {

        $id = $request->id;
        $action = $request->action;

        $update = Restaurant::where('id',$id)->update(['gst' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }
}
