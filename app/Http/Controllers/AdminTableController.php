<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use App\Item;
use App\ItemDescription;
use App\Variety;
use App\ItemImage;
use App\Restaurant;
use App\Table;
use App\Qrcode;
use Auth;
use QR;
use DB;
use Illuminate\Http\Request;

class AdminTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($id,$user_type,'table');

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

        if($request->table_name){
            $tables = DB::table('tables')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'tables.restaurant_id')
            ->LeftJoin('qrcodes', 'qrcodes.table_id', '=', 'tables.id' )
            ->select('tables.*','restaurants.name','qrcodes.qr_code','qrcodes.project_url')
            ->where('tables.table_name', 'like', '%' .$request->table_name. '%')
            ->where('tables.restaurant_id', $id)->paginate(10);
        }
        else{ 
        $tables = DB::table('tables')
            ->LeftJoin('restaurants', 'restaurants.id', '=' ,'tables.restaurant_id')
            ->LeftJoin('qrcodes', 'qrcodes.table_id', '=', 'tables.id' )
            ->select('tables.*','restaurants.name','qrcodes.qr_code','qrcodes.project_url')
            ->where('tables.restaurant_id', $id)->orderBy('tables.table_name','ASC')->paginate(10);

        }
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id()){
            $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
            $manager = Auth::guard('manager')->user();
            $id=$manager->restaurant_id;
            $user_type=$manager->user_type;
            $perms=get_admin_module_permission($id,$user_type,'table');

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

        $categories = Category::where(['restaurant_id'=>$id,'parent_id'=>null])->get();
        return view('admin.tables.create', compact('categories'));
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
            'table_name' => 'required'
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
            $perms=get_admin_module_permission($res_id,$user_type,'table');

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


        $check_item = Table::where([
            ['table_name', ucwords(strtolower($request->table_name))],
            ['restaurant_id', $res_id],
        ])->first();

        if ($check_item) {
            return redirect()->back()->withInput($request->input())->with('error', 'Table already exists');
        }

        DB::transaction(function () use ($request) {

            if(Auth::guard('restaurant')->id()){
                $request['restaurant_id']= Auth::guard('restaurant')->id();
                }
                else{
                   $manager = Auth::guard('manager')->user();
                   $request['restaurant_id']=$manager->restaurant_id;
                }

           // $request['restaurant_id'] = Auth::guard('restaurant')->id();
            $request['item_name'] = ucwords(strtolower($request->item_name));
            $restaurant = Restaurant::where(['id' =>$request['restaurant_id'],'enabled' => 1])->first();
            $table_id = Table::create($request->only('restaurant_id', 'table_name', 'short_description', 'long_description'))->id;
            $uniqueCode= $this->unique_id();
            $url = \URL::to('/').'/'.$restaurant->handle.'/'.$uniqueCode;
            $qrCode=QR::size(500)->generate($url);
            Qrcode::create([
                                'restaurant_id' => $request['restaurant_id'],
                                'table_id' => $table_id,
                                'handle' => $restaurant->handle,
                                'project_url' => $url,
                                'unique_code' => $uniqueCode,
                                'qr_code' => $qrCode,
                                'image_path' => public_path('qr-images/'.$uniqueCode.'.png'),
                                'enabled' => 1,                            
                            ]);

        });
        return redirect('table')->with('success', 'added successfully');

    }

    public function unique_id($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
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
        $table = Table::find($id);
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
            $perms=get_admin_module_permission($res_id,$user_type,'table');

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
        
        return view('admin.tables.edit', compact('table'));
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
            $perms=get_admin_module_permission($res_id,$user_type,'table');

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
            'table_name' => 'required'
        ]);
      //  $res_id = Auth::guard('restaurant')->id();

        DB::transaction(function () use ($request, $id) {
           
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

            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $request['restaurant_id'] = $res_id;
            $item = Table::find($id)->update($request->only('restaurant_id', 'table_name', 'short_description', 'long_description', 'enabled'));
/*
            $uniqueCode= $this->unique_id();
            $url = \URL::to('/').'/qrestro/'.$uniqueCode;
            $qrCode=QR::size(500)->generate($url);
            Qrcode::create([
                                'restaurant_id' => $request['restaurant_id'],
                                'table_id' => $id,
                                'project_url' => $url,
                                'unique_code' => $uniqueCode,
                                'qr_code' => $qrCode,
                                'image_path' => public_path('qr-images/'.$uniqueCode.'.png'),
                                'enabled' => 1,                            
                            ]); */

        });
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

}
