<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Qrcode;
use Illuminate\Http\Request;
use QR;
use App\Currency;
use DB;
class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$resturant = Restaurant::paginate(10);

        $resturant = DB::table('restaurants')
            ->leftJoin('qrcodes', 'restaurants.id', '=', 'qrcodes.restaurant_id')
            ->select('restaurants.*','qrcodes.qr_code','qrcodes.project_url')
            ->paginate(10);

   

        return view('superadmin.resturants.index', compact('resturant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currency =Currency::where('enabled',1)->orderBy('code','ASC')->get();  
        return view('superadmin.resturants.create',compact('currency'));
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
            'handle' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email',
            'currency'=>'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'manager_name' => 'required',
            'resturant-logo' => 'required',

        ]);

        $ExistsMobileNo = Restaurant::where(['contact_number' => $request->contact_number])->first();
        if ($ExistsMobileNo) {
            return redirect()->back()->withInput($request->input())->with('error', 'contact number already exists!');
          
        } 
        $ExistsHandle = Restaurant::where(['handle' => $request->handle])->first();
        if ($ExistsHandle) {
            return redirect()->back()->withInput($request->input())->with('error', 'Handle is already exists!');
          
        } 
        $ExistsEmail = Restaurant::where(['email' => $request->email])->first();
        if ($ExistsEmail) {
            return redirect()->back()->withInput($request->input())->with('error', 'email already exists!');
          
        }

        if ($request->hasFile('resturant-logo')) {
            $file = $request->file('resturant-logo');
            $fileName1 = uniqid('resturant') . "" . $file->getClientOriginalName();
            $file->move('public/assets/restaurant-logo/', $fileName1);
            $request['logo'] = $fileName1;
        }

        $count = Restaurant::count();
     
        $count > 0 ? $c = $count + 1 : $c = 1;
        $request['resturant_id'] = "R-" . str_pad($c, 3, '0', STR_PAD_LEFT);
        $request['password'] =bcrypt($request->contact_number);
      

        $restaurantId=Restaurant::create($request->only('name', 'handle', 'email', 'address','password','contact_number','currency','latitude', 'longitude', 'manager_name', 'logo', 'resturant_id','text_title','text_detail'))->id;


        $uniqueCode= $this->unique_id();
        $url = \URL::to('/').'/'.$request->handle.'/'.$uniqueCode;
        $qrCode=QR::size(500)->generate($url);

        //echo $qrcode;
        QR::size(500)
            ->format('png')
            ->generate($url, public_path('qr-images/'.$uniqueCode.'.png')); 

        Qrcode::create([
                            'restaurant_id' => $restaurantId,
                            'handle' => $request->handle,
                            'table_id' => 0,
                            'project_url' => $url,
                            'unique_code' => $uniqueCode,
                            'qr_code' => $qrCode,
                            'image_path' => public_path('qr-images/'.$uniqueCode.'.png'),
                            'enabled' => 1,                            
                        ]);

        return redirect()->back()->with('success', 'added successfully!');

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

    public function unique_id($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::find($id);
        $currency =Currency::where('enabled',1)->orderBy('code','ASC')->get(); 
        //dd($restaurant);
        return view('superadmin.resturants.edit', compact('restaurant','currency'));
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
            'name' => 'required',
            'handle' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email',
            'currency'=>'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'manager_name' => 'required',

        ]);

        $check_mobile = Restaurant::where([
            ['contact_number', $request->contact_number],
            ['id', '!=', $id],
          ])->first();

        if ($check_mobile) {
            return redirect()->back()->withInput($request->input())->with('error', 'contact number already exists');
        }

        if ($request->hasFile('resturant-logo')) {
            $file = $request->file('resturant-logo');
            $fileName1 = uniqid('resturant') . "" . $file->getClientOriginalName();
            $file->move('public/assets/restaurant-logo/', $fileName1);
            $request['logo'] = $fileName1;
        }

        Restaurant::find($id)->update($request->only('name','handle','address','contact_number','currency','latitude', 'longitude', 'manager_name', 'logo','text_title','text_detail'));

        return redirect('/restaurant')->with('success', 'updated successfully!');



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


    public function restaurantAction(Request $request){
        $id = $request->id;
        $action = $request->action;
       
        $update = Restaurant::find($id)->update(['enabled' => $action ]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);

    }
}
