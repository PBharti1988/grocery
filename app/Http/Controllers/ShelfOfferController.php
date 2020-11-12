<?php

namespace App\Http\Controllers;

use Auth;
use App\Shelf;
use App\ShelfOffer;
use Illuminate\Http\Request;

class ShelfOfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = ShelfOffer::select('shelf_offers.*','shelves.shelf_number')
        ->leftJoin('shelves','shelves.id','shelf_offers.shelf_id')
        ->orderBy('shelf_number', 'ASC')
        ->paginate(10);
        return view('admin.shelf-offers.index', compact('offers'));
    }

    public function create()
    {
        $shelves = Shelf::where('enabled','1')->get();
        return view('admin.shelf-offers.create', compact('shelves'));
    }

    public function store(Request $request)
    {
    
        $this->validate($request, [
            'shelf_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName1 = uniqid('shelfoffer') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/shelf-offers', $fileName1);
            $request['offer_image'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        ShelfOffer::create($request->only('shelf_id', 'offer_image', 'start_date', 'end_date', 'enabled'));

        return redirect('/shelf-offers')->with('success', 'Record added successfully!');

    }

    public function edit($id)
    {
        $offer = ShelfOffer::find($id);
        $shelves = Shelf::where('enabled','1')->get();
        return view('admin.shelf-offers.edit', compact('offer','shelves'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'shelf_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName1 = uniqid('shelfoffer') . "." . $file->getClientOriginalExtension();
            $file->move('public/assets/images/shelf-offers', $fileName1);
            $request['offer_image'] = $fileName1;
        }

        $enabled = $request->enabled == 'on' ? 1 : 0;
        $request['enabled'] = $enabled;

        ShelfOffer::find($id)->update($request->only('shelf_id', 'offer_image', 'start_date', 'end_date', 'enabled'));
        return redirect()->back()->with('success', 'Record updated successfully!');
    }
}
