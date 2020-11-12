<?php

namespace App\Http\Controllers;
use App\Promotion;
use App\Restaurant;
use App\RestaurantSeo;
use App\Qrcode;
use Auth;
use DB;

use Illuminate\Http\Request;

class PromotionController extends Controller
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
         $res_id= Auth::guard('restaurant')->id();
        }
         else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $res_id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($res_id,$user_type,'promotion');
  
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
        $promo =Promotion::where('restaurant_id',$res_id)->paginate(10);
        return view('admin.promotion.index',compact('promo'));
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
          $perms=get_admin_module_permission($res_id,$user_type,'promotion');
  
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

        return view('admin.promotion.create');
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
          $perms=get_admin_module_permission($res_id,$user_type,'promotion');
  
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
            'title' => 'required',
            'file' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        
        //$res_id = Auth::guard('restaurant')->id();
        $request['restaurant_id']=$res_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName1 = uniqid('promotion') . "" . $file->getClientOriginalName();
            $file->move('public/promotion', $fileName1);
            $request['image'] = $fileName1;
        }

         $enabled = $request->enabled == 'on' ? 1 : 0;
         $request['enabled'] = $enabled;

         Promotion::insert($request->only('restaurant_id','title','image','start_date','end_date','enabled'));
         return redirect('/promotion')->with('success', 'added successfully');

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
          $perms=get_admin_module_permission($res_id,$user_type,'promotion');
  
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

        $promo =Promotion::find($id);
        return view('admin.promotion.edit',compact('promo'));
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
            'start_date' => 'required',
            'end_date' => 'required',
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
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($res_id,$user_type,'promotion');
  
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

        $request['restaurant_id']=$res_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName1 = uniqid('promotion') . "" . $file->getClientOriginalName();
            $file->move('public/promotion', $fileName1);
            $request['image'] = $fileName1;
        }

         $enabled = $request->enabled == 'on' ? 1 : 0;
         $request['enabled'] = $enabled;

         Promotion::where('id',$id)->update($request->only('restaurant_id','title','image','start_date','end_date','enabled'));
         return redirect()->back()->with('success', 'updated successfully');
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



    public function promotion($id){
        $res_id=$id;
        $find_resto=Restaurant::find($id);
        $promo =Promotion::where(['restaurant_id'=>$res_id,'enabled'=>1])->get();
        $url =Qrcode::where(['restaurant_id'=>$find_resto->id])->first('project_url');
        $seoDetail= RestaurantSeo::where('restaurant_id',$find_resto->id)->first();
        if(!empty($seoDetail)){
          $trackingId =$seoDetail->tracking_id;
        }else{
          $trackingId ="";
        } 
        return view('user.promotion',compact('promo','trackingId','find_resto','url'));
    }
}
