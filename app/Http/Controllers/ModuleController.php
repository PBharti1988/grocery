<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\RoleModule;
class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module=Module::paginate(10);
        return view('superadmin.module.index',compact('module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.module.create');
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
            'module_name' => 'required',
        ]);


        $check_name =Module::where([
            ['module_name',ucwords(strtolower($request->module_name))]
           ])->first();

           if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'module already exists');
           }
           $request['module_name']=ucwords(strtolower($request->module_name));
          $created= Module::create($request->only('module_name','description'));
          RoleModule::insert(['module_id'=>$created->id]);
           return redirect('/module')->with('success', 'Added Successfully');   
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
        $module=Module::find($id);
        return view('superadmin.module.edit',compact('module'));
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
            'module_name' => 'required',
        ]);


        $check_name =Module::where([
            ['module_name',ucwords(strtolower($request->module_name))],
            ['id','!=',$id],
           ])->first();

           if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'module already exists');
           }
           $request['module_name']=ucwords(strtolower($request->module_name));
           Module::where('id',$id)->update($request->only('module_name','description'));
           return redirect()->back()->with('success', 'Updated Successfully'); 
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



  



    public function moduleAction(Request $request)
    {

        $id = $request->id;
        $action = $request->action;

        $update = Module::where('id',$id)->update(['enabled' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }
}
