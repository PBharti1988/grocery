<?php

namespace App\Http\Controllers;
use Auth;
use App\RestaurantSeo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $restro_id = Auth::guard('restaurant')->id();
       if(Auth::guard('restaurant')->id())
        {
         $restro_id= Auth::guard('restaurant')->id();
        }
         else if(Auth::guard('manager')->id())
         {
          $manager = Auth::guard('manager')->user();
           $restro_id=$manager->restaurant_id;
            }
          else{
            return redirect('admin');
         } 
        $check=RestaurantSeo::where('restaurant_id',$restro_id)->first();
        if(!$check){
            RestaurantSeo::create(['restaurant_id'=>$restro_id]);
        }

        $seo=RestaurantSeo::where('restaurant_id',$restro_id)->first();

        return view('admin.seo.index',compact('seo'));
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
        //$restro_id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
         $restro_id= Auth::guard('restaurant')->id();
        }
         else if(Auth::guard('manager')->id())
         {
          $manager = Auth::guard('manager')->user();
           $restro_id=$manager->restaurant_id;
            }
          else{
            return redirect('admin');
         } 
       $data =array(
             "google_analytic_id"=>$request->google_analytic_id,
             "facebook_pixel_id"=>$request->facebook_pixel_id,
             "tracking_id"=>$request->tracking_id,
             "meta_title"=>$request->meta_title,
             "meta_description"=>$request->meta_description,
             "meta_keyword"=>$request->meta_keyword,
             "og_tag_facebook"=>$request->og_tag_facebook,
             "og_tag_twitter"=>$request->og_tag_twitter,
             "og_tag_linkeden"=>$request->og_tag_linkeden
       );
        RestaurantSeo::where('restaurant_id',$restro_id)->update($data);

        return redirect('restaurant-seo')->with('success', 'saved successfully');
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
