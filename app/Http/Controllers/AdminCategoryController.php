<?php

namespace App\Http\Controllers;

use App\Category;
use Auth;
use App\Manager;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $id =Auth::gaurd('resturant')->id();
        if(Auth::guard('restaurant')->id())
        {
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
    			$manager = Auth::guard('manager')->user();
    			$id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'category');

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
      //  $id = Auth::guard('restaurant')->id();
         if($request->category_name){
            $categories = Category::where('restaurant_id', $id)->where('category_name', 'like', '%' .$request->category_name. '%')->paginate(10);
         }
         else{
        $categories = Category::where('restaurant_id', $id)->orderBy('sort_order','ASC')->paginate(10);
         }
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
          $perms=get_admin_module_permission($res_id,$user_type,'category');

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

        $category = Category::whereNull('parent_id')->where('restaurant_id',$res_id)->get();
        return view('admin.category.create', compact('category'));
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
            'category_name' => 'required',
            'sort_order'=>'required'
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
          $perms=get_admin_module_permission($res_id,$user_type,'category');

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
        
        if ($request->parent_id != "") {
            $check_category = Category::where([
                ['category_name',$request->category_name],
                ['restaurant_id', $res_id],
                ['parent_id', $request->parent_id],
            ])->first();
        } else {
            $check_category = Category::where([
                ['category_name',$request->category_name],
                ['restaurant_id', $res_id],
            ])->first();
        }
        if ($check_category) {
            return redirect()->back()->withInput($request->input())->with('error', 'category already exists');
        }

        if ($request->hasFile('category_logo')) {
            $file = $request->file('category_logo');
            // $fileName1 = uniqid('icon') . "" . $file->getClientOriginalName();
            $fileName1 = uniqid('icon') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/category-icon', $fileName1);
            $request['icon'] = $fileName1;
        }
        // $enabled = $request->enabled == 'on' ? 1 : 0;
        // $request['enabled'] = $enabled;
        $request['category_name'] = $request->category_name;
        if(Auth::guard('restaurant')->id()){
              $request['restaurant_id'] = Auth::guard('restaurant')->id();
        }else{
            $manager = Auth::guard('manager')->user();
            $request['restaurant_id']=$manager->restaurant_id;
        }

        Category::create($request->only('category_name', 'icon', 'restaurant_id', 'parent_id','start_time','end_time','description','sort_order'));

        return redirect('/category')->with('success', 'added successfully!');

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
          $perms=get_admin_module_permission($res_id,$user_type,'category');

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

        $parent_category = Category::where(['restaurant_id'=>$res_id,'parent_id'=>null])->get();
        $category = Category::find($id);
        return view('admin.category.edit', compact('category','parent_category'));
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
        
     //   dd($request->all());
        $this->validate($request, [
            'category_name' => 'required',
            'sort_order' =>'required'

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
          $perms=get_admin_module_permission($res_id,$user_type,'category');

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

        if ($request->parent_id != "") {
            $check_category = Category::where([
                ['category_name', $request->category_name],
                ['restaurant_id', $res_id],
                ['parent_id', $request->parent_id],
                ['id', '!=', $id],
            ])->first();
        } else {
            $check_category = Category::where([
                ['category_name',$request->category_name],
                ['restaurant_id', $res_id],
                ['id', '!=', $id],
            ])->first();
        }

        if ($check_category) {
            return redirect()->back()->withInput($request->input())->with('error', 'category already exists');
        }

        if ($request->hasFile('category_logo')) {
            $file = $request->file('category_logo');
            // $fileName1 = uniqid('icon') . "" . $file->getClientOriginalName();
            $fileName1 = uniqid('icon') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/category-icon', $fileName1);
            $request['icon'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;
        if(Auth::guard('restaurant')->id())
        {
	        $request['restaurant_id'] = Auth::guard('restaurant')->id();
        }else{
            $manager = Auth::guard('manager')->user();
            $request['restaurant_id']=$manager->restaurant_id;
        }
        $request['category_name'] = $request->category_name;
        Category::find($id)->update($request->only('category_name', 'icon', 'restaurant_id', 'parent_id','start_time','end_time','description', 'enabled','sort_order'));

        return redirect()->back()->with('success', 'updated successfully!');

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
