<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Restaurant;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Role::paginate(10);
        return view('superadmin.role.index',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.role.create');
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
            'role_name' => 'required',
        ]);


        $check_name =Role::where([
            ['role_name',ucwords(strtolower($request->role_name))]
           ])->first();

           if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'Role already exists');
           }
           $request['role_name']=ucwords(strtolower($request->role_name));
           Role::insert($request->only('role_name','description'));
           return redirect('/role')->with('success', 'Added Successfully'); 
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
        $role=Role::find($id);
        return view('superadmin.role.edit',compact('role'));
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
            'role_name' => 'required',
        ]);


        $check_name =Role::where([
            ['role_name',ucwords(strtolower($request->role_name))],
            ['id','!=',$id],
           ])->first();

           if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'role already exists');
           }
           $request['role_name']=ucwords(strtolower($request->role_name));
           Role::where('id',$id)->update($request->only('role_name','description'));
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

    public function roleConfig(Request $request,$id){
      $restaurant =Restaurant::where('id',$id)->first();
      $role=Role::where('enabled',1)->get();
      
      return view('superadmin.role.restaurant-role',compact('restaurant','role'));
    }

    public function RestaurantRoleUpdate(Request $request,$id){
        $this->validate($request, [
            'role_name' => 'required',
        ]);

        $request['role_id']=$request->role_name;
        Restaurant::where('id',$id)->update($request->only('role_id'));
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function roleAction(Request $request)
    {

        $id = $request->id;
        $action = $request->action;

        $update = Role::where('id',$id)->update(['enabled' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }
}
