<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Manager;
use App\Restaurant;
use Carbon\Carbon;
use DB;

class RestaurantManagerController extends Controller
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
          else{
            return redirect('admin');
         }
        $managers =Manager::where('restaurant_id',$res_id)->get();
        return view('admin.managers.index',compact('managers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.managers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'user_type'=>'required',
            'mobile_no' => 'required|integer',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        if($request->password != $request->confirm_password){
            return redirect()->back()->withInput($request->input())->with('error', 'password and confirm password does not match');
         }

        $check_email1=Manager::where('email',$request->email)->first(); 
        $check_email2=Restaurant::where('email',$request->email)->first(); 

        $check_mobile1=Manager::where('mobile_no',$request->mobile_no)->first(); 
        $check_mobile2=Restaurant::where('contact_number',$request->mobile_no)->first(); 
        
        if ($check_email1) {
            return redirect()->back()->withInput($request->input())->with('error', 'email already exists');
        }

        if ($check_email2) {
            return redirect()->back()->withInput($request->input())->with('error', 'email already exists');
        }

        if ($check_mobile1) {
            return redirect()->back()->withInput($request->input())->with('error', 'mobile no. already exists');
        }

        if ($check_mobile2) {
            return redirect()->back()->withInput($request->input())->with('error', 'mobile no. already exists');
        }

        $request['password']= bcrypt($request->password);
       // $request['restaurant_id'] = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
         $request['restaurant_id'] = Auth::guard('restaurant')->id();
        }
          else{
            return redirect('admin');
         }
        Manager::create($request->only('name','restaurant_id','user_type','email','mobile_no','password'));
        return redirect('restaurant-manager')->with('success', 'manager added successfully');
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
        $manager=Manager::find($id);
        return view('admin.managers.edit',compact('manager'));
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
            'name' => 'required',
            'email' => 'required|email',
            'mobile_no' => 'required|integer',
            'user_type'=>'required'
        ]);

       

        $check_email1=Manager::where([
            ['email',$request->email],
            ['id','!=',$id]
            ])->first(); 
        $check_email2=Restaurant::where('email',$request->email)->first(); 

        $check_mobile1=Manager::where([
            ['mobile_no',$request->mobile_no],
            ['id','!=',$id]
        ])->first(); 
        $check_mobile2=Restaurant::where('contact_number',$request->mobile_no)->first(); 
        
        if ($check_email1) {
            return redirect()->back()->withInput($request->input())->with('error', 'email already exists');
        }

        if ($check_email2) {
            return redirect()->back()->withInput($request->input())->with('error', 'email already exists');
        }

        if ($check_mobile1) {
            return redirect()->back()->withInput($request->input())->with('error', 'mobile no. already exists');
        }

        if ($check_mobile2) {
            return redirect()->back()->withInput($request->input())->with('error', 'mobile no. already exists');
        }
        
        $request['active']=$request->active;
        $request['user_type']=$request->user_type;
        $request['password']= bcrypt($request->password);
        //$request['restaurant_id'] = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
         $request['restaurant_id'] = Auth::guard('restaurant')->id();
        }
          else{
            return redirect('admin');
         }
        Manager::where('id',$id)->update($request->only('name','user_type','restaurant_id','email','mobile_no','active'));
        return redirect()->back()->with('success', 'updated successfully');
    }




    public function changePassword(Request $request, $user_id)
    {
       
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $this->validate($request, [
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

       
        $updated_at = Carbon::now();
        if ($password == $confirm_password) {
            $new_password = bcrypt($password);
            DB::update('update restaurant_users set password = ?,updated_at = ? where id = ?', [$new_password, $updated_at, $user_id]);
            return redirect()->back()->with('successChangepassword','Password has been changed successfully.');
        } else {
            return redirect()->back()->with('errorChangepassword','Password and Confirm Password does not match.');
        }
       
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
