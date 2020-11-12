<?php

namespace App\Http\Controllers;
use App\Coupon;
use Auth;
use carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
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
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($id,$user_type,'coupon');

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

        $coupon =Coupon::where('restaurant_id',$id)->paginate(10);
        return view('admin.coupon.index',compact('coupon'));
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
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($id,$user_type,'coupon');

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

        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $this->validate($request, [
            'title' => 'required',
            'coupon_type' => 'required',
            'coupon_code' => 'required|between:4,20|alpha_num',
            'coupon_value' => 'required',
            'coupon_count' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // $res_id = Auth::guard('restaurant')->id();
        
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'coupon');

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

         $request['restaurant_id']=$res_id;
         $check_title = Coupon::where([
            ['title', ucwords(strtolower($request->title))],
            ['restaurant_id', $res_id],
         ])->first();
         
         $check_code = Coupon::where([
            ['coupon_code',$request->coupon_code],
            ['restaurant_id', $res_id],
         ])->first();

         if ($check_title) {
            return redirect()->back()->withInput($request->input())->with('error', 'Title already exists');
        }

        if ($check_code) {
            return redirect()->back()->withInput($request->input())->with('error', 'Coupon Code already exists');
        }
           
        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['title']=ucwords(strtolower($request->title));
        $request['enabled'] = $enabled;
        $request['count'] = $request->coupon_count;
       Coupon::insert($request->only('restaurant_id','title','description','coupon_code','coupon_value','coupon_type','count','max_discount','start_date','end_date','enabled'));

           return redirect('/coupon')->withInput($request->input())->with('success', 'Added Successfully');
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
            $perms=get_admin_module_permission($res_id,$user_type,'coupon');

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

        $coupon=Coupon::find($id);
        return view('admin.coupon.edit',compact('coupon'));
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
        $this->validate($request, [
            'title' => 'required',
            'coupon_type' => 'required',
            'coupon_code' => 'required|between:4,20|alpha_num',
            'coupon_value' => 'required',
            'coupon_count' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        if(Auth::guard('restaurant')->id())
        {
            $res_id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $res_id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($res_id,$user_type,'coupon');

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


       //  $res_id = Auth::guard('restaurant')->id();
         $request['restaurant_id']=$res_id;
         $check_title = Coupon::where([
            ['title', ucwords(strtolower($request->title))],
            ['restaurant_id', $res_id],
            ['id','!=',$id]
         ])->first();
         
         $check_code = Coupon::where([
            ['coupon_code',$request->coupon_code],
            ['restaurant_id', $res_id],
            ['id','!=',$id]
         ])->first();

         if ($check_title) {
            return redirect()->back()->withInput($request->input())->with('error', 'Title already exists');
        }

        if ($check_code) {
            return redirect()->back()->withInput($request->input())->with('error', 'Coupon Code already exists');
        }
           
        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['title']=ucwords(strtolower($request->title));
        $request['enabled'] = $enabled;
        $request['count'] = $request->coupon_count;
        Coupon::where('id',$id)->update($request->only('restaurant_id','title','description','coupon_code','coupon_value','coupon_type','count','max_discount','start_date','end_date','enabled'));

           return redirect()->back()->with('success', 'Updated Successfully');
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
