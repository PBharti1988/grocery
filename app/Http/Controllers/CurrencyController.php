<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency = Currency::orderBy('code', 'ASC')->paginate(10);
        return view('superadmin.currency.index', compact('currency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.currency.create');
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
            'code' => 'required|min:3',
            'symbol' => 'required'
        ]);

        $check_name = Currency::where([
            ['name', ucwords(strtolower($request->name))],
        ])->first();

        $check_code = Currency::where([
            ['code', strtoupper($request->code)],
        ])->first();

        if ($check_name) {
            return redirect()->back()->withInput($request->input())->with('error', 'name already exists');
        }
        if ($check_code) {
            return redirect()->back()->withInput($request->input())->with('error', 'code already exists');
        }

        $request['name'] = ucwords(strtolower($request->name));
        $request['code'] = strtoupper($request->code);
        Currency::insert($request->only('name', 'code', 'symbol'));
        return redirect('/currency')->with('success', 'Added Successfully');
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
        $currency = Currency::find($id);
        return view('superadmin.currency.edit', compact('currency'));
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
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|min:3',
            'symbol' => 'required'
        ]);

        $check_name = Currency::where([
            ['name', ucwords(strtolower($request->name))],
            ['id','!=',$id],
        ])->first();

        $check_code = Currency::where([
            ['code', strtoupper($request->code)],
            ['id','!=',$id],
        ])->first();

        if ($check_name) {
        
            return redirect()->back()->with('error', 'name already exists');
        }
        if ($check_code) {
     
            return redirect()->back()->with('error', 'code already exists');
        }

        $request['name'] = ucwords(strtolower($request->name));
        $request['code'] = strtoupper($request->code);
        Currency::where('id',$id)->update($request->only('name', 'code', 'symbol'));
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

    public function currencyAction(Request $request)
    {

        $id = $request->id;
        $action = $request->action;

        $update = Currency::where('id', $id)->update(['enabled' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }
}
