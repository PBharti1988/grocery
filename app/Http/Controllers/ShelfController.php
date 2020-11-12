<?php

namespace App\Http\Controllers;

use Auth;
use App\Shelf;
use App\Floor;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index(Request $request)
    {
        $shelves = Shelf::select('shelves.*','floors.floor_name')
        ->leftJoin('floors','floors.id','shelves.floor_id')
        ->orderBy('shelf_number', 'ASC')
        ->paginate(10);
        return view('admin.shelf.index', compact('shelves'));
    }

    public function create()
    {
        $floors = Floor::where('enabled','1')->get();
        return view('admin.shelf.create', compact('floors'));
    }

    public function store(Request $request)
    {
    
        $this->validate($request, [
            'floor_id' => 'required',
            'shelf_number' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName1 = uniqid('shelf') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/shelves', $fileName1);
            $request['shelf_image'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        Shelf::create($request->only('floor_id','shelf_number', 'shelf_image', 'enabled'));

        return redirect('/shelves')->with('success', 'Record added successfully!');

    }

    public function edit($id)
    {
        $shelf = Shelf::find($id);
        $floors = Floor::where('enabled','1')->get();
        return view('admin.shelf.edit', compact('shelf','floors'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'floor_id' => 'required',
            'shelf_number' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName1 = uniqid('shelf') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/shelves', $fileName1);
            $request['shelf_image'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        Shelf::find($id)->update($request->only('floor_id','shelf_number', 'shelf_image', 'enabled'));
        return redirect()->back()->with('success', 'Record updated successfully!');
    }
}
