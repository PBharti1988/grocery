<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use App;
use App\Restaurant;
use Auth;
class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang=Language::get();
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
        
        return view('admin.lang.index', compact('lang'));
    }

    public function setlocale(Request $request){
      
        $locale = $request->input('locale');
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
        Restaurant::where('id',$res_id)->update(['language'=>$locale]);
		session(['locale'=>$locale]);
        return redirect()->back()->with('success', 'Language update successfully');
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
