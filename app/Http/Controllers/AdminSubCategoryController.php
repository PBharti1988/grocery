<?php

namespace App\Http\Controllers;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Auth;

class AdminSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $id =Auth::gaurd('resturant')->id();
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
        }
        else{
          return redirect('admin');
        }


        $sub_categories = SubCategory::select('sub_categories.*','categories.category_name')
        ->join('categories','categories.id','sub_categories.category_id')
        ->where('sub_categories.restaurant_id',$id)->paginate(10);
        return view('admin.sub-category.index',compact('sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id()){
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
        }
        else{
          return redirect('admin');
        }

        $categories = Category::where('restaurant_id',$id)->get();
        return view('admin.sub-category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request->all());
        $this->validate($request, [
            'sub_category_name' => 'required',
            'category' => 'required',
            'logo' => 'required',
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
        }
        else{
          return redirect('admin');
        }
 
        $check_sub_category = SubCategory::where([
            ['name', ucwords(strtolower($request->sub_category_name))],
            ['category_id',$request->category],
            ['restaurant_id', $res_id],
        ])->first();
            
        if($check_sub_category){
            return redirect()->back()->withInput($request->input())->with('error', 'sub category already exists');
          }
            

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName1 = uniqid('logo') . "" . $file->getClientOriginalName();
            $file->move('public/assets/images/sub-category-icon', $fileName1);
            $request['icon'] = $fileName1;
        }
     //  $enabled = $request->enabled == 'on' ? 1 : 0;
      // $request['enabled'] = $enabled;
        $request['name'] = ucwords(strtolower($request->sub_category_name));
        $request['category_id'] = $request->category;
        if(Auth::guard('restaurant')->id()){
            $request['restaurant_id']= Auth::guard('restaurant')->id();
        }
        else
        {
           $manager = Auth::guard('manager')->user();
           $request['restaurant_id']=$manager->restaurant_id;
        } 
       //$request['restaurant_id'] = Auth::guard('restaurant')->id();
        SubCategory::create($request->only('name','category_id','icon','restaurant_id'));
    
        return redirect('/sub-category')->with('success', 'added successfully!');

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

        $categories = Category::where('restaurant_id',$res_id)->get();
        $sub_category = SubCategory::find($id);
        return view('admin.sub-category.edit',compact('sub_category','categories'));
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
            'sub_category_name' => 'required',
            'category' => 'required',
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

         $check_sub_category = SubCategory::where([
            ['name', ucwords(strtolower($request->sub_category_name))],
            ['category_id',$request->category],
            ['restaurant_id', $res_id],
            ['id', '!=', $id],
             ])->first();
                
        if($check_sub_category){
            return redirect()->back()->withInput($request->input())->with('error', 'sub category already exists');
          }
                
                
     if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName1 = uniqid('icon') . "" . $file->getClientOriginalName();
            $file->move('public/assets/images/sub-category-icon', $fileName1);
            $request['icon'] = $fileName1;
        }  
        
        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;
        if(Auth::guard('restaurant')->id()){
            $request['restaurant_id']= Auth::guard('restaurant')->id();
            }
            else{
               $manager = Auth::guard('manager')->user();
               $request['restaurant_id']=$manager->restaurant_id;
            } 
        //$request['restaurant_id'] = Auth::guard('restaurant')->id();
        $request['category_id'] = $request->category;
        $request['name'] = ucwords(strtolower($request->sub_category_name));
        SubCategory::find($id)->update($request->only('category_id','name','icon','restaurant_id','enabled'));
    
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
