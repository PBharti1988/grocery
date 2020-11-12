<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use App\Item;
use App\ItemDescription;
use App\Variety;
use App\ItemImage;
use App\Restaurant;
use Auth;
use DB;
use Illuminate\Http\Request;

class AdminItemController extends Controller
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
          $perms=get_admin_module_permission($id,$user_type,'item');

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


        if($request->item_name){
            $items = Item::select('items.*')
            ->where('item_name', 'like', '%' .$request->item_name. '%')
            //  ->join('sub_categories', 'sub_categories.id', 'items.sub_category_id')
              ->where('items.restaurant_id', $id)->paginate(10);
         }
         else{
        $items = Item::select('items.*')
          //  ->join('sub_categories', 'sub_categories.id', 'items.sub_category_id')
            ->where('items.restaurant_id', $id)->paginate(10);
         }
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'item');
  
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
        return view('admin.items.create', compact('categories'));
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
          $id= Auth::guard('restaurant')->id();
        }
        else if(Auth::guard('manager')->id())
        {
          $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
          $user_type=$manager->user_type;
          $perms=get_admin_module_permission($id,$user_type,'item');

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


     //  dd($request->all());

        $this->validate($request, [
            'item_name' => 'required',
            'category' => 'required',
            'item_price' => 'required',
            'item_type' => 'required',
            'card_color' => 'required',
            'font_color' => 'required',
        ]);

       // $res_id = Auth::guard('restaurant')->id();

/*        if($request->sub_category){
        $check_item = Item::where([
            ['item_name', ucwords(strtolower($request->item_name))],
            ['category_id', $request->category],
            ['sub_category_id', $request->sub_category],
            ['restaurant_id', $res_id],
        ])->first();
        }else{
            $check_item = Item::where([
                ['item_name', ucwords(strtolower($request->item_name))],
                ['category_id', $request->id],
                ['restaurant_id', $res_id],
            ])->first();

        }
        if ($check_item) {
            return redirect()->back()->withInput($request->input())->with('error', 'Item already exists');
        }
*/
        DB::transaction(function () use ($request) {
            if ($request->hasFile('item_image')) {
                $file = $request->file('item_image');
                $fileName1 = uniqid('main') . "." . $file->getClientOriginalExtension();


                $file->move('public/assets/images/item-images', $fileName1);
                $request['image'] = $fileName1;
            }
           
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


            // $type = $request->item_type == 1 ? 'veg' : 'non-veg';
            $type = $request->item_type == 1 ? 'veg' : ($request->item_type == 2 ? 'non-veg' : '');

            $request['item_type'] = $type;
            // $enabled = $request->enabled == 'on' ? 1 : 0;
            // $request['enabled'] = $enabled;
            $request['sub_category_id'] = $request->sub_category;
            $request['category_id'] = $request->category;
            $request['restaurant_id'] = $res_id;
            $request['item_name'] = ucwords(strtolower($request->item_name));
            $item = Item::create($request->only('sub_category_id','category_id','restaurant_id', 'item_name', 'item_price', 'item_type','order_limit','discount_price', 'image', 'short_description', 'long_description', 'card_color','font_color'));

            if (isset($request->images)) {
                foreach ($request->images as $key => $value) {
                    $fileName = uniqid('item') . "." . $file->getClientOriginalExtension();
                    $value->move('public/assets/images/item-images', $fileName);
                    $image = $fileName;
                    $array = array(
                        "item_id" => $item->id,
                        "image" => $image,
                    );
                    ItemImage::create($array);
                }
            }

            if (isset($request->title)) {
                $title = $request->title;
                $desc = $request->description;
                if(Auth::guard('restaurant')->id()){
                $id = Auth::guard('restaurant')->id();
                }else{
                    $manager = Auth::guard('manager')->user();
                    $id=$manager->restaurant_id;
                }
                
                $resturant_id = Restaurant::find($id);
                $title_count = count($request->title);
                for ($i = 0; $i <= $title_count - 1; $i++) {
                    $array1 = array(
                        "resturant_id" => $resturant_id->resturant_id,
                        "item_id" => $item->id,
                        "title" => $title[$i],
                        "description" => $desc[$i],
                    );
                    ItemDescription::create($array1);

                }
            }


            if (isset($request->name)) {
                $name = $request->name;
                $desc = $request->variety_description;
                $price = $request->price;
                // $id = Auth::guard('restaurant')->id();
                // $resturant_id = Restaurant::find($id);
                $title_count = count($request->name);
                for ($i = 0; $i <= $title_count - 1; $i++) {
                    $array2 = array(
                        "restaurant_id" =>$res_id,
                        "item_id" => $item->id,
                        "name" => $name[$i],
                        "price" => $price[$i],
                        "description" => $desc[$i],
                    );
                    Variety::create($array2);

                }
            }



        });
        return redirect('item')->with('success', 'added successfully');

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
        $item = Item::find($id);

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
          $perms=get_admin_module_permission($res_id,$user_type,'item');

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



        $categories = Category::where(['restaurant_id'=> $res_id,'enabled'=>1])->whereNull('parent_id')->get();
        $sub_categories = Category::where(['restaurant_id'=> $res_id,'enabled'=>1])->whereNotNull('parent_id')->get();
        $images = ItemImage::where('item_id', $id)->get();
        $descriptions = ItemDescription::where('item_id', $id)->get();
        $variety = Variety::where('item_id', $id)->get();
        return view('admin.items.edit', compact('item', 'categories', 'images', 'descriptions','sub_categories','variety'));
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
        //  dd($request->all());
        $this->validate($request, [
            'item_name' => 'required',
            'category' => 'required',
            'item_price' => 'required',
            'item_type' => 'required',
            'card_color' => 'required',
            'font_color' => 'required',
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
          $perms=get_admin_module_permission($id,$user_type,'item');
  
          if(isset($perms))
          {
            if($perms->update)
            {

              $item = Item::find($id)->update($request->only('item_price', 'discount_price', 'enabled'));
              return redirect()->back()->with('success', 'Item Price is updated successfully');              
            }
            else{
              return view('admin.nopermission')->with('error', 'Permission Denied');
            }         
          }

        }
        else{
          return redirect('admin');
        }

        //$res_id = Auth::guard('restaurant')->id();

/*
        if($request->sub_category){
        $check_item = Item::where([
            ['item_name', ucwords(strtolower($request->item_name))],
            ['category_id', $request->category],
            ['sub_category_id', $request->sub_category],
            ['restaurant_id', $res_id],
            ['id', '!=', $id],
        ])->first();
        }else{
            $check_item = Item::where([
                ['item_name', ucwords(strtolower($request->item_name))],
                ['category_id', $request->category],
                ['restaurant_id', $res_id],
                ['id', '!=', $id],
            ])->first();
        }
        if ($check_item) {
            return redirect()->back()->withInput($request->input())->with('error', 'Item already exists');
        }
*/
        DB::transaction(function () use ($request, $id) {
            if ($request->hasFile('item_image')) {
                $file = $request->file('item_image');
                // $fileName1 = uniqid('main') . "" . $file->getClientOriginalName();
                $fileName1 = uniqid('main') . "." . $file->getClientOriginalExtension();
                $file->move('public/assets/images/item-images', $fileName1);
                $request['image'] = $fileName1;
            }

               
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



            $type = $request->item_type == 1 ? 'veg' : ($request->item_type == 2 ? 'non-veg' : '');
            $request['item_type'] = $type;
            $enabled = $request->enabled == 'on' ? 1 : 0;
            $request['enabled'] = $enabled;
            $request['category_id'] = $request->category;
            $request['sub_category_id'] = $request->sub_category;
            $request['restaurant_id'] = $res_id;
            $request['category_name'] = ucwords(strtolower($request->item_name));
            $item = Item::find($id)->update($request->only('category_id','sub_category_id','restaurant_id', 'item_name', 'item_price','order_limit','item_type', 'discount_price', 'image', 'short_description', 'long_description', 'card_color', 'font_color', 'enabled'));
            
           
          
            
            if($request->img_id != null){

                for($i = 0; $i <=count($request->img_id) - 1; $i++) {               
                     $img_id = $request->img_id[$i];
                      if (isset($request->images[$i])) {
                     $file = $request->images[$i];
                     // $image_name = $file->getClientOriginalName();
                     // $fileName = uniqid('gallrey')."".$image_name;
                     // $image_name = $file->getClientOriginalName();
                     $fileName = uniqid('gallery')."." . $file->getClientOriginalExtension();
                     $destinationPath = public_path().'/assets/images/item-images' ;
                     $file->move($destinationPath,$fileName);                           
                     ItemImage::where(['id'=>$request->img_id[$i]])->update(['image'=>$fileName]);
                      }                                                             
                 }
                 ItemImage::WhereNotIn('id', $request->img_id)->where('item_id', $id)->delete();
                }else{
                    ItemImage::where('item_id', $id)->delete();
                }

                    if($request->img_id != null){
                       $img_counted = count($request->img_id);
                    }else{
                        $img_counted =0;
                    }

                    for($i = $img_counted; $i <=10; $i++) {               
                       
                          if (isset($request->images[$i])) {
                         $file = $request->images[$i];
                         $image_name = $file->getClientOriginalName();
                         $fileName = uniqid('gallery').".". $file->getClientOriginalExtension();
                         $destinationPath = public_path().'/assets/images/item-images' ;
                         $file->move($destinationPath,$fileName);    
                         
                         $array=array(
                           "item_id" =>$id,
                           "image" =>$fileName
                         );
                         ItemImage::create($array);
                          }                                                             
                     }
                    


            $desc_id = $request->desc_id;

            if ($desc_id != null) {
                $len = count($desc_id);
                for ($i = 0; $i <= $len - 1; $i++) {

                    $title = $request->title[$i];
                    $description = $request->description[$i];
                    $description_id = $request->desc_id[$i];
                    $array = array(
                        "title" => $title,
                        "description" => $description,
                    );
                    $v = ItemDescription::find($description_id)->update($array);

                }

                ItemDescription::WhereNotIn('id', $request->desc_id)->where('item_id', $id)->delete();
            }else{
                ItemDescription::where('item_id', $id)->delete();
            }

            $title_desc = $request->title;
            if ($title_desc != null) {
                
                
                if(Auth::guard('restaurant')->id())
                {
                    $find_res= Auth::guard('restaurant')->id();
                }
                else if(Auth::guard('manager')->id())
                {
                  $manager = Auth::guard('manager')->user();
                  $find_res=$manager->restaurant_id;
                }
                else{
                  return redirect('admin');
                }   

                $resto_id = Restaurant::find($find_res);
                $tot = $request->desc_id;
               // $id_desc = count($tot);
                $count_title = count($request->title);
               
                if ($request->desc_id != null) {
                    $all_count = count($request->desc_id);
                } else {
                    $all_count = 0;
                }
              
                for ($j = $all_count; $j <= $count_title - 1; $j++) {
                    $array1 = array(
                        "resturant_id" => $resto_id->resturant_id,
                        "item_id" => $id,
                        "title" => $request->title[$j],
                        "description" => $request->description[$j],
                    );

                    ItemDescription::create($array1);
                }
            }




            $variety_id = $request->variety_id;
            if($variety_id != null){
                $v_count = count($variety_id);
                for($i=0; $i<=$v_count - 1; $i++){
                  $name = $request->name[$i];
                  $price = $request->price[$i];
                  $v_desc = $request->variety_description[$i];
                  $v_id = $request->variety_id[$i];
                  $array3 = array(
                     "name"=>$name,
                     "price"=>$price,
                     "description"=>$v_desc
                  );                  
                  Variety::find($v_id)->update($array3);
                  }
                  Variety::WhereNotIn('id', $request->variety_id)->where('item_id', $id)->delete();
                  }else{
                    Variety::where('item_id', $id)->delete();
                  }
               

                  $variety_name = $request->name;
                  if ($variety_name != null) {
                   
                    if(Auth::guard('restaurant')->id())
                       {
                    $find_res= Auth::guard('restaurant')->id();
                       }
                    else if(Auth::guard('manager')->id())
                        {
                  $manager = Auth::guard('manager')->user();
                  $find_res=$manager->restaurant_id;
                      }
                    else{
                  return redirect('admin');
                        }   
                      $resto_id = Restaurant::find($find_res);
                      $tot = $request->variety_id;
                   
                      $count_name = count($request->name);
                     
                      if ($request->variety_id != null) {
                          $all_count = count($request->variety_id);
                      } else {
                          $all_count = 0;
                      }                 
                      for ($j = $all_count; $j <= $count_name - 1; $j++) {
                          $array5 = array(
                              "restaurant_id" => $resto_id->id,
                              "item_id" => $id,
                              "name" => $request->name[$j],
                              "price"=>$request->price[$j],
                              "description" => $request->variety_description[$j],
                          );
                          Variety::create($array5);
                      }
                  }     
                 







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

    // public function item_status(Request $request)
    // {

    //   $item_id=$request->item_id;
    //   $status=$request->status;
    //   if($request->fn_action=='status_change')
    //   {
    //     $itemUpdated=Item::where('id',$item_id)->update(['enabled'=>$status]);
    //     $item=Item::where('id',$item_id)->first();

    //     if (!empty($itemUpdated)) 
    //     {
    //       $result['data'] = $item;
    //       $result['status']='success'; 
    //     } else {
    //       $result['data']=array();
    //       $result['status']='fail'; 
    //     }
    //     return response()->json($result);
    //   }

    // }

    public function subCategory(Request $request)
    {
        $id = $request->input('id');
        $district = DB::table('categories')
            ->select('categories.*')
            ->where([
                ['categories.parent_id', $id],
                ['categories.enabled', 1],
            ])
            ->orderBy('categories.category_name')
            ->get();

        ?>  <option value = "">Select</option> 
        <?php
            foreach ($district as $value) 
            {
        ?>
                <option value="<?php echo $value->id ?>"><?php echo $value->category_name ?></option>
        <?php
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function item_status(Request $request)
    {

      $item_id=$request->item_id;
      $status=$request->status;

      $editPermission=false;
      if(Auth::guard('restaurant')->id())
      {
        $id= Auth::guard('restaurant')->id();
      }
      else if(Auth::guard('manager')->id())
      {
        $manager = Auth::guard('manager')->user();
        $id=$manager->restaurant_id;
        $user_type=$manager->user_type;
        $perms=get_admin_module_permission($id,$user_type,'item');

        if(isset($perms))
        {
          if($perms->update)
          {                
              $editPermission=true;
          }
          else
          {
              $result['data']=array();
              $result['status']='fail'; 
              return response()->json($result);
          }
        }
      }


      if($request->fn_action=='status_change')
      {
        $itemUpdated=Item::where('id',$item_id)->update(['enabled'=>$status]);
        $item=Item::where('id',$item_id)->first();

        if (!empty($itemUpdated)) 
        {
          $result['data'] = $item;
          $result['status']='success'; 
        } else {
          $result['data']=array();
          $result['status']='fail'; 
        }
        return response()->json($result);
      }

    }




}
