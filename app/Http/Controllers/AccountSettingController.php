<?php

namespace App\Http\Controllers;
use App\Restaurant;
use Auth;
use DB;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       // $id= Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
         {
              $id= Auth::guard('restaurant')->id();
        }
        else{
            return redirect('admin');
         }
        $user=Restaurant::where('id',$id)->first();

        return view('admin.account-setting.index',compact('user'));
    }



    public function update(Request $request,$id)
    {
        //dd($request->all());
        $this->validate($request, [
            'name'=>'required',
            'email' =>'required|email',
            'contact_number' =>'required|integer|min:10',
            'manager_name' =>'required',
            
        ]);

     
        $email_exists = Restaurant::where('email',$request->email)->where('id','!=',$id)->first();
        if ($email_exists) {
            return redirect()->back()->with('error', 'Email already exists!');
        }

        $mobile_exists = Restaurant::where('contact_number',$request->contact_number)->where('id','!=',$id)->first();
        if ($mobile_exists) {
            return redirect()->back()->with('error', 'Contact number  already exists!');
        }

      

        //$request1 = new Request($request->all());

        if($file = $request->hasFile('image')){
            $file = $request->file('image');
            $fileName = uniqid('logo')."".$file->getClientOriginalName();
            $file->move(public_path('/assets/restaurant-logo'),$fileName);
            $request['logo'] = $fileName;
           }else{
            if($request->hidden_profile == '0'){
                $request->merge(['logo' => null]);
            }
        }
 
      
        $request->merge(["email" =>$request->email, "contact_number"=> $request->contact_number,"address"=>$request->address,"manager_name"=>$request->manager_name]);
       
        Restaurant::where('id',$id)->update($request->only('name','logo', 'email', 'contact_number', 'address', 'manager_name'));

        return redirect()->back()->with('success', 'successfully updated!');
        //return redirect()->back()->with('success', 'User successfully updated!');
       
       
    }

    public function changePassword(Request $request, $user_id)
    {
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $this->validate($request, [
            'password' => 'required|min:6',
            'confirm_password' => 'required',
        ]);

       
        $updated_at = Carbon::now();
        if ($password == $confirm_password) {
            $new_password = bcrypt($password);
            DB::update('update restaurants set password = ?,updated_at = ? where id = ?', [$new_password, $updated_at, $user_id]);
            return redirect()->back()->with('successChangepassword','Password has been changed successfully.');
        } else {
            return redirect()->back()->with('errorChangepassword','Password and Confirm Password does not match.');
        }
       
    }

    public function saveSetting(Request $request, $id)
    {
        $bg_color = $request->input('bg_color');
        $cb_color = $request->input('cb_color');
        $cbt_color = $request->input('cbt_color');
         $time_zone =$request->input('time_zone');
         $enabled = $request->enabled == 'on' ? 1 : 0;
        $this->validate($request, [
            'bg_color' => 'required',
            'cb_color' => 'required',
            'cbt_color' => 'required',
        ]);

       
        $updated_at = Carbon::now();
        DB::update('update restaurants set bg_color = ?,cb_color = ?,cbt_color = ?,time_zone = ?,logo_enabled=?,updated_at = ? where id = ?', [$bg_color,$cb_color,$cbt_color,$time_zone,$enabled,$updated_at, $id]);
        return redirect()->back()->with('successChangepassword','Password has been changed successfully.');

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
