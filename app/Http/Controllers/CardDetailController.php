<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\CardDetail;
use App\CustomCardDetail;
use App\SocialCardDetail;
use Auth;
use App\Item;

class CardDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id()){
            $id= Auth::guard('restaurant')->id();
            }
            else{
               $manager = Auth::guard('manager')->user();
               $id=$manager->restaurant_id;
            } 
        $card = CardDetail::where('restaurant_id', $id)->select('card_details.*', 'cards.name')
            ->join('cards', 'cards.id', 'card_details.category_id')
            ->paginate(10);

        return view('admin.card-detail.index', compact('card'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $id = Auth::guard('restaurant')->id();
       if(Auth::guard('restaurant')->id())
       {
        $id= Auth::guard('restaurant')->id();
       }
        else if(Auth::guard('manager')->id())
        {
         $manager = Auth::guard('manager')->user();
          $id=$manager->restaurant_id;
           }
         else{
           return redirect('admin');
        }
        $card = Card::where('enabled', 1)->get();

        $items = Item::where(['restaurant_id' => $id, 'enabled' => 1])->select('id', 'item_name')->get();

        return view('admin.card-detail.create', compact('card', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $card = $request->card;
        //$id = Auth::guard('restaurant')->id();
        if(Auth::guard('restaurant')->id())
        {
         $id= Auth::guard('restaurant')->id();
        }
         else if(Auth::guard('manager')->id())
         {
          $manager = Auth::guard('manager')->user();
           $id=$manager->restaurant_id;
            }
          else{
            return redirect('admin');
         }
        $request['category_id'] =  $card;
        $request['restaurant_id'] =  $id;

        // $check = CardDetail::where(['restaurant_id'=>$id,'category_id'=>$card])->first();
        // if($check){
        //     return redirect()->back()->withInput($request->input())->with('error', 'card details already exists');
        // }
        if ($card == 1) {
            $this->validate($request, [
                'email' => 'required|email',
                'title' => 'required',
                'phone' => 'required|integer',
                'serial_no' => 'required|integer',
                'address' => 'required',
                'gst' => 'required|max:15',
            ]);

            CardDetail::create($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'email', 'email_code', 'phone', 'phone_code', 'address', 'address_code', 'gst', 'gst_code'));
        } else if ($card == 2) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'latitude' => 'required',
                'longitude' => 'required'
            ]);

            CardDetail::create($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'longitude', 'latitude'));
        } else if ($card == 3) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'offering' => 'required',
            ]);
            //dd($request->offering);
            $decode = json_decode($request->offering);
            $request['offering'] = serialize($decode);

            CardDetail::create($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'offering'));
        } else if ($card == 4) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'famous_for' => 'required',
            ]);
            CardDetail::create($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'famous_for'));
        } else if ($card == 5) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'facilities' => 'required',
            ]);
            CardDetail::create($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'facilities'));
        } else if ($card == 6) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'story' => 'required',
            ]);
            CardDetail::create($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'story'));
        } else if ($card == 8) {
            $this->validate($request, [
                'card' => 'required',
                'title' => 'required',
                'serial_no' => 'required|integer',
            ]);

            $created = CardDetail::create($request->only('restaurant_id', 'category_id', 'title','serial_no','card_color','font_color'));

            if (isset($request->custom_title)) {
                $title = $request->custom_title;
                $serial = $request->custom_serial;
                $text = $request->custom_value;
                $code =$request->custom_code;
                $type = $request->field_type;
                $title_count = count($request->custom_title);
                for ($i = 0; $i <= $title_count - 1; $i++) {
                    $array1 = array(
                        "card_detail_id" => $created->id,
                        "serial_no" => $serial[$i],
                        "code" => $code[$i],
                        "title" => $title[$i],
                        "type" => $type[$i],
                        'text' => $text[$i]
                    );
                    CustomCardDetail::create($array1);
                }
            }
        }
        else if($card == 9){
            $this->validate($request, [
                'card' => 'required',
                'title' => 'required',
                'serial_no' => 'required|integer',
                'social_media' => 'required',
                'link' => 'required',
                'social_image' => 'required',
            ]);

            $created = CardDetail::create($request->only('restaurant_id', 'category_id', 'title','serial_no'));           
 
            if ($request->hasFile('social_image')) {
                $file = $request->file('social_image');
                $fileName1 = uniqid('social') . "" . $file->getClientOriginalName();
                $file->move('public/card-images', $fileName1);
                $request['image'] = $fileName1;
            } 
            
           $request['card_detail_id'] =$created->id;
            SocialCardDetail::create($request->only('card_detail_id','image','link', 'social_media'));     


        }

        return redirect()->back()->with('success', 'Record added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$res_id = Auth::guard('restaurant')->id();
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
        $card = CardDetail::where(['card_details.restaurant_id' => $res_id, 'card_details.id' => $id])->select('card_details.*', 'cards.name')
            ->join('cards', 'cards.id', 'card_details.category_id')
            ->first();
        if ($card->category_id == 3) {
            $card->offering = unserialize($card->offering);
        }
        $custom_card = '';
        $social_card = '';
        if ($card->category_id == 8) {
            $custom_card = CustomCardDetail::where('card_detail_id', $id)->get();
        }
        if ($card->category_id == 9) {
            $social_card = SocialCardDetail::where('card_detail_id', $id)->first();
        }
       
        return view('admin.card-detail.show', compact('card', 'custom_card','social_card'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$res_id = Auth::guard('restaurant')->id();
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
        $card = Card::where('enabled', 1)->get();
        $items = Item::where(['restaurant_id' => $res_id, 'enabled' => 1])->select('id', 'item_name')->get();
        $cardDetail = CardDetail::find($id);
        $custom_card = '';
        $social_card = '';
        if ($cardDetail->category_id == 8) {
            $custom_card = CustomCardDetail::where('card_detail_id', $id)->get();
        }
        if ($cardDetail->category_id == 9) {
            $social_card = SocialCardDetail::where('card_detail_id', $id)->first();
        }


        return view('admin.card-detail.edit', compact('card', 'items', 'cardDetail', 'social_card','custom_card'));
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
        $card = $request->card;
        //$res_id = Auth::guard('restaurant')->id();
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
        $request['category_id'] =  $card;
        $request['restaurant_id'] =  $res_id;

        // $check = CardDetail::where(['restaurant_id'=>$id,'category_id'=>$card])->first();
        // if($check){
        //     return redirect()->back()->withInput($request->input())->with('error', 'card details already exists');
        // }
        if ($card == 1) {
            $this->validate($request, [
                'email' => 'required|email',
                'title' => 'required',
                'phone' => 'required|integer',
                'serial_no' => 'required|integer',
                'address' => 'required',
                'gst' => 'required|max:15',
            ]);

            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'email', 'email_code', 'gst_code', 'phone_code', 'address_code', 'phone', 'address', 'gst'));
        } else if ($card == 2) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'latitude' => 'required',
                'longitude' => 'required'
            ]);

            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'longitude', 'latitude'));
        } else if ($card == 3) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'offering' => 'required',
            ]);
            //dd($request->offering);
            $decode = json_decode($request->offering);
            $request['offering'] = serialize($decode);

            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'offering'));
        } else if ($card == 4) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'famous_for' => 'required',
            ]);
            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'famous_for'));
        } else if ($card == 5) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'facilities' => 'required',
            ]);
            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'facilities'));
        } else if ($card == 6) {
            $this->validate($request, [
                'title' => 'required',
                'serial_no' => 'required|integer',
                'story' => 'required',
            ]);
            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'serial_no', 'title', 'story'));
        } else if ($card == 8) {
            $this->validate($request, [
                'card' => 'required',
                'serial_no' => 'required|integer',
                'title' => 'required',
            ]);

            CardDetail::where('id', $id)->update($request->only('restaurant_id', 'category_id', 'title','serial_no','card_color','font_color'));

            $update_id = $request->update_id;

            if (!empty($update_id)) {

                $len = count($update_id);
                for ($i = 0; $i <= $len - 1; $i++) {
                    $title = $request->custom_title[$i];
                    $serial = $request->custom_serial[$i];
                    $value = $request->custom_value[$i];
                    $type = $request->field_type[$i];
                    $code = $request->custom_code[$i];
                    $main_id = $request->update_id[$i];
                    $array = array(
                        "card_detail_id" => $id,
                        "title" => $title,
                        "code" => $code,
                        "serial_no" => $serial,
                        "text" => $value,
                        "type" => $type
                    );
                    CustomCardDetail::find($main_id)->update($array);
                }
                CustomCardDetail::WhereNotIn('id', $request->update_id)->where('card_detail_id', $id)->delete();
            } else {
                CustomCardDetail::where('card_detail_id', $id)->delete();
            }


            $title_desc = $request->custom_title;
            if ($title_desc != null) {
                $count_title = count($request->custom_title);
                if ($request->update_id != null) {
                    $all_count = count($request->update_id);
                } else {
                    $all_count = 0;
                }

                for ($j = $all_count; $j <= $count_title - 1; $j++) {
                    $array1 = array(
                        "card_detail_id" => $id,
                        "title" => $request->custom_title[$j],
                        "code" => $request->custom_code[$j],
                        "serial_no" => $request->custom_serial[$j],
                        "text" => $request->custom_value[$j],
                        "type" => $request->field_type[$j]
                    );
                    CustomCardDetail::create($array1);
                }
            }
        }
        else if($card ==9){
            $this->validate($request, [
                'card' => 'required',
                'title' => 'required',
                'serial_no' => 'required|integer',
                'link' => 'required',
                
            ]);

            $created = CardDetail::where('id',$id)->update($request->only('restaurant_id', 'category_id', 'title','serial_no'));           
 
            if ($request->hasFile('social_image')) {
                $file = $request->file('social_image');
                $fileName1 = uniqid('social') . "" . $file->getClientOriginalName();
                $file->move('public/card-images', $fileName1);
                $request['image'] = $fileName1;
            } 
            
          // $request['card_detail_id'] =$id;
            SocialCardDetail::where('card_detail_id',$id)->update($request->only('image','link', 'social_media'));  

        }

        return redirect()->back()->with('success', 'Record updated successfully');
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

    public function cardAction(Request $request)
    {

        $id = $request->id;
        $action = $request->action;

        $update = CardDetail::find($id)->update(['enabled' => $action]);
        if ($update) {
            $status = "success";
        } else {
            $status = "failed";
        }
        $result = array('status' => $status);
        return response()->json($result);
    }
}
