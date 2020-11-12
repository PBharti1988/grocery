<?php

namespace App\Http\Controllers;

use Auth;
use App\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index(Request $request)
    {
        $floors = Floor::orderBy('floor_name', 'ASC')->paginate(10);
        return view('admin.floor.index', compact('floors'));
    }

    public function create()
    {
        return view('admin.floor.create');
    }

    public function store(Request $request)
    {
    
        $this->validate($request, [
            'floor_name' => 'required'
        ]);

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        Floor::create($request->only('floor_name', 'enabled'));

        return redirect('/floors')->with('success', 'Record added successfully!');

    }

    public function edit($id)
    {
        $floor = Floor::find($id);
        return view('admin.floor.edit', compact('floor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'floor_name' => 'required',
        ]);

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        Floor::find($id)->update($request->only('floor_name', 'enabled'));
        return redirect()->back()->with('success', 'Record updated successfully!');
    }
}
