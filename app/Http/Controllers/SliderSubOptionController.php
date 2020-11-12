<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Category;
use App\Product;
use App\SliderOptions;
use App\StoreCity;
use App\StoreCityArea;
use DB;
use Auth;

class SliderSubOptionController extends Controller
{
    //

    public function index($id)
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

        $categories = Category::where('restaurant_id', $res_id)->orderBy('category_name','ASC')->get();
        $products = Product::where('restaurant_id', $res_id)->orderBy('item_name','ASC')->get();

        $areas = DB::table('slider_options')
                 
                
                 ->where('slider_options.restaurant_id',$res_id)
                 ->where('slider_options.status','=','2')
                 ->where('slider_id',$id)
                 ->paginate(10);

         // $areas = DB::select('select slider_options.*,slider_options.sort_order as sorder,slider_options.id as sid,slider_options.enabled as senabled from slider_options left join  categories on slider_options.category=categories.id left join items on slider_options.product=items.id where slider_options.restaurant_id = 35 and slider_options.status=2 and slider_id=1')->paginate(10);        

          // print_r($areas);exit();
        // $areas=SliderOptions::where('restaurant_id',$res_id)->where('status','=','2')->with('findCategory')->paginate(10);
        return view('admin.slideroptions.index',compact('areas','res_id','categories','products','id'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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

         $categories = Category::where('restaurant_id', $res_id)->orderBy('category_name','ASC')->get();
         $products = Product::where('restaurant_id', $res_id)->orderBy('item_name','ASC')->get();

         return view('admin.slideroptions.create',compact('id','categories','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sid = $request->input('slider_id');
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
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
         //$res_id = Auth::guard('restaurant')->id();
          
         

           $enabled = $request->enabled == 'on' ? 1 : 0;
           // $request['tax_name']=ucwords(strtolower($request->tax_name));
           $request['enabled'] = $enabled;

           $request['status'] = 2;
          
           $request['restaurant_id']=$res_id;

           if ($request->hasFile('slider_img')) {
            $file = $request->file('slider_img');
            $fileName = uniqid('icon') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/slideroptions', $fileName);
            $request['icon'] = $fileName;
        }else{

        	$fileName = $request->input('tempfile_img');
        	$request['icon'] = $fileName;
        }

           SliderOptions::updateOrCreate(['id' => $request->input('id')],$request->only('slider_id','restaurant_id','icon','date_from','date_to','sort_order','type','category','product','status','enabled'));

           return redirect('slideroption/'.$sid)->with('success', 'added successfully')->with('res_id',$res_id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	  // echo $id;exit();
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

        $categories = Category::where('restaurant_id', $res_id)->orderBy('category_name','ASC')->get();
        $products = Product::where('restaurant_id', $res_id)->orderBy('item_name','ASC')->get();
        // $areas = DB::table('slider_options')->leftJoin('categories', 'slider_options.category', '=', 'categories.id')->leftJoin('items', 'slider_options.product', '=', 'items.id')->where('slider_options.restaurant_id',$res_id)->where('slider_options.status','=','2')->paginate(10);

        $area = SliderOptions::find($id);
        return view('admin.slideroptions.edit',compact('area','categories','products'));
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
