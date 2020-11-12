<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SmsTemplate;
use Auth;

class SmsTemplateController extends Controller
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
         
         $template =SmsTemplate::where('restaurant_id',$res_id)->paginate(10);
         return view('admin.sms-template.index',compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sms-template.create');
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
            'message' => 'required',
        ]);

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

        SmsTemplate::create($request->only('restaurant_id','message','enabled'));
        return redirect('/sms-template')->with('success', 'added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $template = SmsTemplate::find($id);
        return view('admin.sms-template.show', compact('template'));
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
        }
        else{
          return redirect('admin');
        }

        $template = SmsTemplate::find($id);
        return view('admin.sms-template.edit', compact('template'));
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
            'message' => 'required',
        ]);

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

        SmsTemplate::where('id',$id)->update($request->only('restaurant_id','message','enabled'));
        return redirect('/sms-template')->with('success', 'updated successfully!');
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
