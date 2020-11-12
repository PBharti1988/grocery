<?php

namespace App\Http\Controllers;

use Auth;
use App\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::where('enabled', '1')->orderBy('sort_order', 'ASC')->paginate(10);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
    
        $this->validate($request, [
            'name' => 'required',
            'sort_order' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName1 = uniqid('banner') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/banners', $fileName1);
            $request['banner'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        Banner::create($request->only('name', 'banner', 'enabled', 'sort_order'));

        return redirect('/banners')->with('success', 'Record added successfully!');

    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'sort_order' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName1 = uniqid('banner') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/banners', $fileName1);
            $request['banner'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        Banner::find($id)->update($request->only('name', 'banner', 'enabled', 'sort_order'));
        return redirect()->back()->with('success', 'Record updated successfully!');
    }
}
