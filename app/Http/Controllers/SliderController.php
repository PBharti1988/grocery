<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\CardDetail;
use App\RestaurantSeo;
use App\CustomCardDetail;
use App\SocialCardDetail;

class SliderController extends Controller
{
  public function index($id)
  {

    $card = CardDetail::where('restaurant_id', $id)->select('card_details.*', 'cards.name as card_name')
      ->join('cards', 'cards.id', 'card_details.category_id')
      ->orderBy('card_details.serial_no', 'ASC')
      ->where('card_details.enabled', 1)
      // ->where('card_details.category_id',2)
      ->get();

      $seoDetail= RestaurantSeo::where('restaurant_id',$id)->first();
      if(!empty($seoDetail)){
        $trackingId =$seoDetail->tracking_id;
      }else{
        $trackingId ="";
      } 

    foreach ($card as $val) {
      if ($val->category_id == 3) {
        $val->offering = unserialize($val->offering);
      }

      if ($val->category_id == 8) {
        $custom_data = CustomCardDetail::where('card_detail_id', $val->id)->orderBy('serial_no', 'ASC')->get();
        $val->custom_detail = $custom_data;
      }
      if ($val->category_id == 9) {
        $social_data = SocialCardDetail::where('card_detail_id', $val->id)->get();
        $val->social_detail = $social_data;
      }
    }
     //dd($trackingId); 
    return view('user.slider.slider', compact('card','trackingId'));
  }
}
