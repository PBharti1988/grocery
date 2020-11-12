<?php

namespace App\Http\Controllers;
use App\Restaurant;
use App\Category;
use App\Item;
use App\ItemImage;
use App\ItemDescription;
use Illuminate\Http\Request;

class MenuCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       $restaurant =Restaurant::where('id','!=',$id)->get();
       $restro_id =$id;
       return view('superadmin.copy-menu.index', compact('restaurant','restro_id'));
    }


    public function copyMenu(Request $request){
        $restro =$request->restro_id;
        $this->validate($request, [
            'restaurant' => 'required',
        ]);

        $category = Category::where('restaurant_id',$request->restaurant)->get();
        if(count($category)>0)
          {    
            
          foreach($category as $val){
              $cat= Category::create(['restaurant_id'=>$restro,'parent_id'=>null,'category_name'=>$val->category_name,'icon'=>$val->icon,'description'=>$val->description,'enabled'=>$val->enabled]); 
              $item = Item::where(['restaurant_id'=>$request->restaurant,'category_id'=>$val->id])->get(); 
              foreach($item as $val){
               $item_id= Item::create(['restaurant_id'=>$restro,'item_name'=>$val->item_name,'category_id'=>$cat->id,'sub_category_id'=>$val->sub_category_id,'item_price'=>$val->item_price,'discount_price'=>$val->discount_price,'short_description'=>$val->short_description,'order_limit'=>$val->order_limit,'item_type'=>$val->item_type,'image'=>$val->image,'long_description'=>$val->long_description,'card_color'=>$val->card_color,'enabled'=>$val->enabled]); 
                $itemImg=ItemImage::where('item_id',$val->id)->get(); 
                foreach($itemImg as $val){
                  ItemImage::insert(['item_id'=>$item_id->id,'image'=>$val->image]);
                }

                $itemDesc =ItemDescription::where('item_id',$val->id)->get();
                foreach($itemDesc as $val){
                    ItemDescription::insert(['item_id'=>$item_id->id,'title'=>$val->title,'description'=>$val->description]);
                }
            }

            }
           
          
        // $item = Item::where('restaurant_id',$request->restaurant)->get();
        // foreach($item as $val){
        //     $check_item =item::where(['restaurant_id'=>$restro,'item_name'=>$val->item_name,'category_id'=>$val->category_id])->first();
        //     if(!$check_item){
        //     Item::create(['restaurant_id'=>$restro,'item_name'=>$val->item_name,'category_id'=>$cat->id,'sub_category_id'=>$val->sub_category_id,'item_price'=>$val->item_price,'discount_price'=>$val->discount_price,'short_description'=>$val->short_description,'order_limit'=>$val->order_limit,'item_type'=>$val->item_type,'image'=>$val->image,'long_description'=>$val->long_description,'card_color'=>$val->card_color,'enabled'=>$val->enabled]); 
        //     }
        // }
    }
        return redirect('/restaurant')->with('success', 'menu copy successfully');


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
    public function update(Request $request, $id)
    {
        //
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
