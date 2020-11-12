<?php

namespace App\Http\Controllers;
use App\TopUp;
use App\ItemVarientAddon;
use App\Variety;
use Auth;
use Illuminate\Http\Request;

class TopUpController extends Controller
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
           }
         else{
           return redirect('admin');
        }
        $topup=TopUp::where('restaurant_id',$res_id)->paginate(10);
        return view('admin.top-up.index',compact('topup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.top-up.create');
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
            'price' => 'required',
            'topup_image'=>'required'
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
          
         $check_name = TopUp::where([
            ['name', ucwords(strtolower($request->name))],
            ['restaurant_id', $res_id],
         ])->first();

         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Top Up Name already exists');
        } 

         if ($request->hasFile('topup_image')) {
            $file = $request->file('topup_image');
            $fileName1 = uniqid('topup') . "" . $file->getClientOriginalName();
            $file->move('public/assets/topup-images', $fileName1);
            $request['image'] = $fileName1;
        }

        

           $enabled = $request->enabled == 'on' ? 1 : 0;
           $request['name']=ucwords(strtolower($request->name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           TopUp::insert($request->only('restaurant_id','name','price','enabled','image','description'));
           return redirect('addon')->with('success', 'added successfully');
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
        $topup=TopUp::find($id);
        return view('admin.top-up.edit',compact('topup'));
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
            'price' => 'required',
          
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
          
         $check_name = TopUp::where([
            ['name', ucwords(strtolower($request->name))],
            ['restaurant_id', $res_id],
            ['id','!=',$id]
         ])->first();
        
         
         if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Top Up Name already exists');
        }

         if ($request->hasFile('topup_image')) {
            $file = $request->file('topup_image');
            $fileName1 = uniqid('topup') . "" . $file->getClientOriginalName();
            $file->move('public/assets/topup-images', $fileName1);
            $request['image'] = $fileName1;
        }


           $enabled = $request->enabled == 'on' ? 1 : 0;
           $request['name']=ucwords(strtolower($request->name));
           $request['enabled'] = $enabled;
          
           $request['restaurant_id']=$res_id;
           ToPUp::where('id',$id)->update($request->only('name','price','enabled','image','description'));
           return redirect('addon')->with('success', 'Updated successfully');
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


    public function addTopUp(Request $request,$id)
    {

        if($request->addon){
            

            if($request->varient){
                $check =ItemVarientAddon::where([
                    ['item_id',$request->item_id],
                    ['addon_id',$request->addon],
                    ['varient_id',$request->varient]
                ])->first();
            }else{
            $check =ItemVarientAddon::where([
                ['item_id',$request->item_id],
                ['addon_id',$request->addon]
            ])->first();
            }
            if($check){
                return redirect()->back()->withInput($request->input())->with('error', 'Addon already exists');
            }

            if($request->varient){
                $varient =$request->varient;
            }else{
                $varient =0;
            }

            $item_id =$request->item_id;
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
            ItemVarientAddon::create(['item_id'=>$request->item_id,'addon_id'=>$request->addon,'varient_id'=>$varient]);
            $topup =TopUp::where(['restaurant_id'=>$res_id,'enabled'=>1])->get();

            $itemAddon =ItemVarientAddon::select('item_varient_addons.*','top_ups.name','top_ups.image','top_ups.price')
            ->join('top_ups','top_ups.id','item_varient_addons.addon_id')
            ->where('item_varient_addons.item_id',$item_id)
            ->where('top_ups.enabled',1)
            ->get();
            $varient=Variety::where('item_id',$item_id)->get();
            return view('admin.items.topup',compact('topup','item_id','itemAddon','varient'));
        }
       else{
        $item_id =$id;
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
        $topup =TopUp::where(['restaurant_id'=>$res_id,'enabled'=>1])->get();
       // $itemAddon =ItemVarientAddon::where(['item_id'=>$item_id,'enabled'=>1])->get();
       $itemAddon =ItemVarientAddon::select('item_varient_addons.*','top_ups.name','top_ups.image','top_ups.price')
       ->join('top_ups','top_ups.id','item_varient_addons.addon_id')
       ->where('item_varient_addons.item_id',$item_id)
       ->where('top_ups.enabled',1)
       ->get();

       $varient=Variety::where('item_id',$item_id)->get();
     
        return view('admin.items.topup',compact('topup','item_id','itemAddon','varient'));
       }
}




public function addCustomPrice(Request $request)
{

    $id = $request->id;
    $price= $request->price;

    $update = ItemVarientAddon::where('id',$id)->update(['custom_price' =>$price]);
    if ($update) {
        $status = "success";
    } else {
        $status = "failed";
    }
    $result = array('status' => 'success');
    return response()->json($result);
}



public function enabledAction(Request $request)
{

    $id = $request->id;
    $action = $request->action;

    $update = ItemVarientAddon::where('id',$id)->update(['enabled' => $action]);
    if ($update) {
        $status = "success";
    } else {
        $status = "failed";
    }
    $result = array('status' => $status);
    return response()->json($result);
}




public function deleteAction(Request $request)
{

    $id = $request->id;
    $update = ItemVarientAddon::where('id',$id)->delete();
    if ($update) {
        $status = "success";
    } else {
        $status = "failed";
    }
    $result = array('status' => $status);
    return response()->json($result);
}


}
