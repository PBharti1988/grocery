<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Item;
use App\ItemImage;
use App\Variety;
use App\Restaurant;
use App\Table;
use App\TempCart;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\ItemDescription;
use App\Question;
use App\QuestionOption;
use App\QuestionAnswer;
use App\Qrcode;
use App\Currency;
use App\Tax;
use App\OrderTax;
use App\Feedback;
use App\Coupan;
use App\Customer;
use App\CustomerAddress;
use App\RestaurantSeo;
use App\StoreCity;
use App\StoreCityArea;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function view()
    {

        return view('user.index');
    }

    public function liststores()
    {

    	$cities=StoreCity::where('enabled',1)->distinct('city_name')->select('city_name')->get();
		return view('user.storelist',compact('cities'));
    }

    public function get_city_area_list(Request $request)
    {

  //   	$cities=StoreCity::where('enabled',1)->distinct('city_name')->select('city_name')->get();
  //   	$city_areas=StoreCityArea::where('enabled',1)->where('city_name','noida')->distinct('area_name')->select('area_name')->get();
  //   	dd($cities);
  //   	dd($city_areas);
		// return view('user.storelist');

		if($request->fn_action=='city_list')
		{
	    	$cities=StoreCity::where('enabled',1)->distinct('city_name')->select('city_name')->get();
			if (!empty($cities)) 
			{
				$result['data'] = $cities;
				$result['status']='success'; 
			} else {
				$result['data']=array();
				$result['status']='fail'; 
			}
			return response()->json($result);
		}
	    
		if($request->fn_action=='area_list')
		{		
			$city_areas=StoreCityArea::where('enabled',1)->where('city_name',$request->city_name)->distinct('area_name')->select('area_name')->get();
			if (!empty($city_areas)) 
			{
				$result['data'] = $city_areas;
				$result['status']='success'; 
			} else {
				$result['data']=array();
				$result['status']='fail'; 
			}
			return response()->json($result);
		}
    }    

    public function get_store(Request $request)
    {
		if($request->fn_action=='store_list')
		{
	    	$stores= StoreCityArea::where('enabled',1)->where('area_name',$request->area_name)->distinct('restaurant_id')->select('restaurant_id')->get();

	    	$store_list=array();

	    	if(count($stores)>0)
	    	{
	    		foreach ($stores as $key => $store) {

    				$storeDetails=Restaurant::where(['id'=>$store->restaurant_id,'enabled'=>1])->select('id','name','address','address_line_2','location')->first();
    				$linkDetails=Qrcode::where(['restaurant_id'=>$store->restaurant_id,'table_id'=>'0','enabled'=>1])->select('handle','unique_code')->first();
    				if($store)
    				{
    					if(is_null($storeDetails->name))
    						$store->name='';
    					if(is_null($storeDetails->address))
    						$store->address='';
    					if(is_null($storeDetails->address_line_2))
    						$storeDetails->address_line_2='';
    						if($linkDetails)
    						{
		    					if(is_null($linkDetails->handle) || empty($linkDetails->handle))
    								$linkDetails->handle='qrestro';

    							$storeDetails->url=url('/').'/'.$linkDetails->handle.'/'.$linkDetails->unique_code;
    						}
    						else
    						{
    							$storeDetails->url=url('/');
    						}
	    				$store_list[]=$storeDetails;
    				}
    			}	
	    	}

			if (!empty($stores)) 
			{
				$result['data'] = $store_list;
				$result['status']='success'; 
			} else {
				$result['data']=array();
				$result['status']='fail'; 
			}
			return response()->json($result);
		}
		$result['data']=array();
		$result['status']='fail'; 
		return response()->json($result);
	}





    public function redirect_to_store(Request $request)
    {
    	dd($request);
		return view('user.storelist');
    }

    public function list($url)
    {
          // print_r($_COOKIE);

//       print_r($url);




       $qrDetails=Qrcode::where('unique_code',$url)->where('enabled',1)->first();
  //     print_r($qrDetails);
       if($qrDetails)
       {

            if(!isset($_COOKIE['qrc']))
            {
              $cookie_name = "qrc";
              $cookie_value = 1;
              setcookie($cookie_name, $cookie_value, time() + (86400 * 0.25), "/"); // 86400 = 1 day
              $counter=$qrDetails->counter + 1;
              Qrcode::where('unique_code',$url)->where('enabled',1)->update(['counter'=>$counter]);
            }


            $find_table='';
            $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
            $currency =Currency::where('code',$find_resto->currency)->first();
            $seoDetail= RestaurantSeo::where('restaurant_id',$qrDetails->restaurant_id)->first();
            if(!empty($seoDetail)){
              $trackingId =$seoDetail->tracking_id;
            }else{
              $trackingId ="";
            }
           
            if($qrDetails->table_id)
            {
              $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
            }
//            $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->orderBy('sort_order','ASC')->get();
            $currTime = date("h:i:s", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata')));
            $restaurant_id=$find_resto->id;
            $categories=array();
            $pCategories = Category::where(['restaurant_id'=>$restaurant_id,'enabled'=>1])->whereNull('parent_id')
->get();

            // print_r($pCategories);
            foreach ($pCategories as $key => $category) {
              // print_r($category);


              if($category->start_time=='' && $category->end_time=='')
              {
                $categories[]=$category;
              }
              else if($category->start_time <= $currTime && $category->end_time=='')
              {
                $categories[]=$category;
              }
              else if($category->start_time ==''  && $category->end_time >=  $currTime )
              {
                $categories[]=$category;
              }
              else if($category->start_time <= $currTime  && $category->end_time >=  $currTime )
              {
                $categories[]=$category;
              }
              else if($category->start_time > $category->end_time)
              {
                if( $category->start_time < $currTime)
                {                  
                  $categories[]=$category;
                }
                else if( $category->end_time > $currTime)
                {
                  $categories[]=$category;                  
                }
              }
            }
            // print_r($categories);
// die;




/*
            $categories = Category::where(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->whereNull('start_time')
              ->whereNull('end_time');
            })->orWhere(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->whereNull('start_time')
              ->where('end_time','>=', $currTime);
            })->orWhere(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->where('start_time', '<=', $currTime)
              ->whereNull('end_time');
            })->orWhere(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->where('start_time','<=', $currTime)
              ->where('end_time','>=', $currTime);
            })->orderBy('sort_order','ASC')->get();
*/



            
            $question =Question::where('restaurant_id',$find_resto->id)->get();
            foreach($question as $val){
              $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
            }

            $questions =$question->toArray(); 

            $array=array();
            $images=array();
            $desc=array();
            $i=0;
            foreach($categories as $val){

                $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->orderBy('sort_order','ASC')->get();
                foreach($sub_cat as $val1){
                    $val['sub'.$val->category_name]=$sub_cat;
                   $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->orderBy('id','ASC')->skip(0)->take(4)->get();
    
                   foreach($items as $val2){
                       $val1[$val1->category_name] =$items;
                       $images =ItemImage::where('item_id',$val2->id)->get();
                       foreach($images as $val3){
                           $val2[$val2->item_name] = $images;
                       }
                       $desc =ItemDescription::where('item_id',$val2->id)->get();
                       foreach($desc as $val4){
                        $val2['desc'.$val2->item_name] = $desc;
                       }
                       
                       $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                       if($varients)
                       {                
                        $val2['varient'.$val2->item_name] = $varients;
                       }
                   }
    
                }
    
                $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->orderBy('id','ASC')->skip(0)->take(4)->get();
                foreach($items1 as $value){
                    $val[$val->category_name]=$items1;
                 
                    $images1 =ItemImage::where('item_id',$value->id)->get();
                    foreach($images1 as $value1){
                        $value[$value->item_name] = $images1;
                    }
    
                    $desc1 =ItemDescription::where('item_id',$value->id)->get();
                    foreach($desc1 as $val4){
                     $value['desc'.$value->item_name] = $desc1;
                    }
    
                    $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                    if($varients)
                    {
                      $value['varient'.$value->item_name] = $varients;
                    }

                }    
            }
        }
        else{
            return redirect()->back()->with('error', 'No Restaurant Found');
        }
        //dd($i); 
       // dd($trackingId);
  //  die;
     
        return view('user.home',compact('categories','items','trackingId','find_resto','find_table','questions','currency','url'));
    }


    public function list_handle($handle,$url)
    {
          // print_r($_COOKIE);

//       print_r($url);

// $status =  $this->send_isd_sms('918010013798');

// echo $status;
// die;


       $qrDetails=Qrcode::where('unique_code',$url)->where('enabled',1)->first();
  //     print_r($qrDetails);
       if($qrDetails)
       {

            if(!isset($_COOKIE['qrc']))
            {
              $cookie_name = "qrc";
              $cookie_value = 1;
              setcookie($cookie_name, $cookie_value, time() + (86400 * 0.25), "/"); // 86400 = 1 day
              $counter=$qrDetails->counter + 1;
              Qrcode::where('unique_code',$url)->where('enabled',1)->update(['counter'=>$counter]);
            }


            $find_table='';
            $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
            $seoDetail= RestaurantSeo::where('restaurant_id',$qrDetails->restaurant_id)->first();
            $currency =Currency::where('code',$find_resto->currency)->first();
            $seoDetail= RestaurantSeo::where('restaurant_id',$qrDetails->restaurant_id)->first();
            if(!empty($seoDetail)){
              $trackingId =$seoDetail->tracking_id;
            }else{
              $trackingId ="";
            }

            if($qrDetails->table_id)
            {
              $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
            }
//            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();

            $currTime = date("H:i:s", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata')));
            $restaurant_id=$find_resto->id;
            $categories=array();
            $pCategories = Category::where(['restaurant_id'=>$restaurant_id,'enabled'=>1])->whereNull('parent_id')
->get();

            // print_r($pCategories);
            foreach ($pCategories as $key => $category) {
              // print_r($category);


              if($category->start_time=='' && $category->end_time=='')
              {
                $categories[]=$category;
              }
              else if($category->start_time <= $currTime && $category->end_time=='')
              {
                $categories[]=$category;
              }
              else if($category->start_time ==''  && $category->end_time >=  $currTime )
              {
                $categories[]=$category;
              }
              else if($category->start_time <= $currTime  && $currTime <= $category->end_time   )
              {
                $categories[]=$category;
              }
              else if($category->start_time > $category->end_time)
              {
                if( $category->start_time < $currTime)
                {                   
                  $categories[]=$category;
                }
                else if( $category->end_time > $currTime)
                {
                  $categories[]=$category;                  
                }
              }
            }


/*
            $categories = Category::where(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->whereNull('start_time')
              ->whereNull('end_time');
            })->orWhere(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->whereNull('start_time')
              ->where('end_time','>=', $currTime);
            })->orWhere(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->where('start_time', '<=', $currTime)
              ->whereNull('end_time');
            })->orWhere(function ($query) use($restaurant_id,$currTime) {
              $query->where('restaurant_id',$restaurant_id)
              ->whereNull('parent_id')
              ->where('enabled',1)
              ->where('start_time','<=', $currTime)
              ->where('end_time','>=', $currTime);
            })->orderBy('sort_order','ASC')->get();
*/

//echo Date('y-m-d',strtotime(now()));




// echo time();            
// print_r($categories);
// die;

            $question =Question::where('restaurant_id',$find_resto->id)->get();
            foreach($question as $val){
              $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
            }

            $questions =$question->toArray(); 

            $array=array();
            $images=array();
            $desc=array();
            $items="";
            $i=0;
            foreach($categories as $val){

                $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->orderBy('sort_order','ASC')->get();
                foreach($sub_cat as $val1){
                    $val['sub'.$val->category_name]=$sub_cat;
                   $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->orderBy('id','ASC')->skip(0)->take(4)->get();
    
                   foreach($items as $val2){
                       $val1[$val1->category_name] =$items;
                       $images =ItemImage::where('item_id',$val2->id)->get();
                       foreach($images as $val3){
                           $val2[$val2->item_name] = $images;
                       }
                       $desc =ItemDescription::where('item_id',$val2->id)->get();
                       foreach($desc as $val4){
                        $val2['desc'.$val2->item_name] = $desc;
                       }
                       
                       $varients =Variety::where('item_id',$val2->id)->orderBy('id',"DESC")->get();
                       if($varients)
                       {                
                        $val2['varient'.$val2->item_name] = $varients;
                       }
                   }
    
                }
    
                $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->orderBy('id','ASC')->skip(0)->take(4)->get();
                foreach($items1 as $value){
                    $val[$val->category_name]=$items1;
                 
                    $images1 =ItemImage::where('item_id',$value->id)->get();
                    foreach($images1 as $value1){
                        $value[$value->item_name] = $images1;
                    }
    
                    $desc1 =ItemDescription::where('item_id',$value->id)->get();
                    foreach($desc1 as $val4){
                     $value['desc'.$value->item_name] = $desc1;
                    }
    
                    $varients =Variety::where('item_id',$value->id)->orderBy('id',"DESC")->get();
                    if($varients)
                    {
                      $value['varient'.$value->item_name] = $varients;
                    }

                }    
            }
        }
        else{
            return redirect()->back()->with('error', 'No Restaurant Found');
        }
        //dd($i); 
       // dd($currency);
  //  die;
     
        return view('user.home',compact('categories','items','trackingId','find_resto','find_table','questions','currency','url'));
    }


    public function send_isd_sms($receiverMobile)
    {
        // $data=json_decode($request->mob,true);
        // return response()->json($data);
        //http://smstech.techstreet.in/sms-panel/api/http/index.php?username=outdosolution&apikey=E50D9-FFA5D&apirequest=Text&sender=TSTMSG&mobile=9716440096&message=SMSMessage&route=TRANS&format=json

        //    $five_digit_otp = mt_rand(10000, 99999);


        $template = "Thank you for Dine-In. Here is your otp 1234";
        $parameters = json_encode([
         'to'=> '+'.$receiverMobile,
         'platform'=> 'web',
         'text' => $template
        ]);

// echo $parameters;
// die;
/*
        $parameters = json_encode([
         'channel' => 'whatsapp',
         'destination'=> '919716076512',
         'source' => '917834811114',
         'src.name'=> 'qrestroapp',
          // 'message' => json_encode(array( "isHSM" =>"false", "type" => "text", "text" => $template ))
         'message' => array( 
                              "isHSM" =>"false",
                              "type" => "text",
                              "text" => $template
                            )
        ]);
*/

        $url = "https://api.checkmobi.com/v1/sms/send";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        // curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
        // curl_setopt($ch, CURLOPT_HEADER, 0);
                                                                    
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);

        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: 67D23A97-F6AE-4EC0-A8EA-63382F5D3168'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        print_r($result);
        if(curl_errno($ch))  //catch if curl error exists and show it
        {
        //      echo 'Curl error: ' . curl_error($ch); //save the response in db;
          $status = "failed";
        }
        else
        {
          $status = "success";
        }
        curl_close($ch);
        return $status;
    }




    public function cart($url)
    {
       
//       print_r($url);
       $qrDetails=Qrcode::where('unique_code',$url)->where('enabled',1)->first();
  //     print_r($qrDetails);
       if($qrDetails)
       {
            $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
//            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
            $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();
            $seoDetail= RestaurantSeo::where('restaurant_id',$qrDetails->restaurant_id)->first();
            if(!empty($seoDetail)){
              $trackingId =$seoDetail->tracking_id;
            }else{
              $trackingId ="";
            }   
            $taxes=Tax::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
            $currency =Currency::where('code',$find_resto->currency)->first();
            $find_table='';
            if($qrDetails->table_id)
            {
              $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
            }

            $question =Question::where('restaurant_id',$find_resto->id)->get();
            foreach($question as $val){
              $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
            }

            $questions =$question->toArray(); 

            $array=array();
            $images=array();
            $desc=array();
            $items="";
            $i=0;
            foreach($categories as $val){
                $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
                foreach($sub_cat as $val1){
                    $val['sub'.$val->category_name]=$sub_cat;
                   $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();
    
                   foreach($items as $val2){
                       $val1[$val1->category_name] =$items;
                       $images =ItemImage::where('item_id',$val2->id)->get();
                       foreach($images as $val3){
                           $val2[$val2->item_name] = $images;
                       }
                       $desc =ItemDescription::where('item_id',$val2->id)->get();
                       foreach($desc as $val4){
                        $val2['desc'.$val2->item_name] = $desc;
                       }
                       
                       $varients =Variety::where('item_id',$val2->id)->get();
                       if($varients)
                       {                
                        $val2['varient'.$val2->item_name] = $varients;
                       }
                   }
    
                }
    
                $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
                foreach($items1 as $value){
                    $val[$val->category_name]=$items1;
                 
                    $images1 =ItemImage::where('item_id',$value->id)->get();
                    foreach($images1 as $value1){
                        $value[$value->item_name] = $images1;
                    }
    
                    $desc1 =ItemDescription::where('item_id',$value->id)->get();
                    foreach($desc1 as $val4){
                     $value['desc'.$value->item_name] = $desc1;
                    }
    
                    $varients =Variety::where('item_id',$value->id)->get();
                    if($varients)
                    {
                      $value['varient'.$value->item_name] = $varients;
                    }

                }
    
            }
        }else{
            return redirect()->back()->with('error', 'No Restaurant Found');
        }
        //dd($i); 
   // dd($trackingId);
//    print_r($_COOKIE);
  //  die;
    
        return view('user.cart',compact('categories','items','trackingId','find_resto','taxes','currency','url','questions','find_table'));
    }



    public function cart_handle($handle,$url)
    {
       
//       print_r($url);
       $qrDetails=Qrcode::where('unique_code',$url)->where('enabled',1)->first();
  //     print_r($qrDetails);
       if($qrDetails)
       {
            $find_resto = Restaurant::where(['id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();
//            $categories = Category::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();
            $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();

            $taxes=Tax::where(['restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->get();

            $seoDetail= RestaurantSeo::where('restaurant_id',$qrDetails->restaurant_id)->first();
            if(!empty($seoDetail)){
              $trackingId =$seoDetail->tracking_id;
            }else{
              $trackingId ="";
            }

            $currency =Currency::where('code',$find_resto->currency)->first();
            $find_table='';
            if($qrDetails->table_id)
            {
              $find_table = Table::where(['id'=>$qrDetails->table_id,'restaurant_id'=>$qrDetails->restaurant_id,'enabled'=>1])->first();              
            }

            $question =Question::where('restaurant_id',$find_resto->id)->get();
            foreach($question as $val){
              $val['options']=QuestionOption::where(['question_id'=>$val->id])->get();
            }

            $questions =$question->toArray(); 

            $array=array();
            $images=array();
            $desc=array();
            $items="";
            $i=0;
            foreach($categories as $val){
                $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
                foreach($sub_cat as $val1){
                    $val['sub'.$val->category_name]=$sub_cat;
                   $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();
    
                   foreach($items as $val2){
                       $val1[$val1->category_name] =$items;
                       $images =ItemImage::where('item_id',$val2->id)->get();
                       foreach($images as $val3){
                           $val2[$val2->item_name] = $images;
                       }
                       $desc =ItemDescription::where('item_id',$val2->id)->get();
                       foreach($desc as $val4){
                        $val2['desc'.$val2->item_name] = $desc;
                       }
                       
                       $varients =Variety::where('item_id',$val2->id)->get();
                       if($varients)
                       {                
                        $val2['varient'.$val2->item_name] = $varients;
                       }
                   }
    
                }
    
                $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
                foreach($items1 as $value){
                    $val[$val->category_name]=$items1;
                 
                    $images1 =ItemImage::where('item_id',$value->id)->get();
                    foreach($images1 as $value1){
                        $value[$value->item_name] = $images1;
                    }
    
                    $desc1 =ItemDescription::where('item_id',$value->id)->get();
                    foreach($desc1 as $val4){
                     $value['desc'.$value->item_name] = $desc1;
                    }
    
                    $varients =Variety::where('item_id',$value->id)->get();
                    if($varients)
                    {
                      $value['varient'.$value->item_name] = $varients;
                    }

                }
    
            }
        }else{
            return redirect()->back()->with('error', 'No Restaurant Found');
        }
        //dd($i); 
   // dd($categories);
//    print_r($_COOKIE);
  //  die;
    
        return view('user.cart',compact('categories','items','trackingId','find_resto','taxes','currency','url','questions','find_table'));
    }




    public function index2(Request $request)
    {
       
        $this->validate($request,[
            "restaurant_id"=>'required'
        ]);

      
        $find_resto = Restaurant::where(['resturant_id'=>ucwords($request->restaurant_id),'enabled'=>1])->first();
      
        if($find_resto){
        $categories = Category::where(['restaurant_id'=>$find_resto->id,'enabled'=>1])->get();
        $array=array();
        $images=array();
        $desc=array();
        $i=0;
        foreach($categories as $val){
           $items =Item::where(['category_id'=>$val->id,'enabled'=>1])->get();
           foreach($items as $val1){
               $array[$i][]=$val1;
               $val[$val->category_name] =$items;
                $item_images = ItemImage::where('item_id',$val1->id)->get();
                $item_desc =ItemDescription::where('item_id',$val1->id)->get();
                foreach($item_images as $val2){
            //        $images[$i][]=$val2;
                    $val1[$val1->item_name] =$item_images;
                  
               }
               foreach($item_desc as $val3){
                $val1['desc'.$val1->item_name] =$item_desc;
               }
              
               //$val['items'] = $array;
             
           }
          
           $i++;
          
        } 
        return view('user.home',compact('categories','items','restaurant_name','find_resto'));
    }else{
        return redirect()->back()->with('error', 'No Restaurant Found');
    }
        //dd($i); 
   // dd($categories);
        
    }

  ////Testing with subcategory
   
  public function index1(Request $request)
  {
     
      $this->validate($request,[
          "restaurant_id"=>'required'
      ]);

    
      $find_resto = Restaurant::where(['resturant_id'=>ucwords($request->restaurant_id),'enabled'=>1])->first();
    
      if($find_resto){
      $categories = Category::where(['restaurant_id'=>$find_resto->id,'enabled'=>1])->get();
      $array=array();
      $images=array();
      $desc=array();
      $i=0;
      foreach($categories as $val){
         
         $sub_category = SubCategory::where('category_id',$val->id)->get();
          foreach($sub_category as $val1){
            $val[$val->category_name] =$sub_category;

         $items =Item::select('items.*','sub_categories.name as cat_name')
         ->join('sub_categories','sub_categories.id','items.sub_category_id')
         ->where(['items.sub_category_id'=>$val1->id,'.items.enabled'=>1])
         ->get();
     
         foreach($items as $val2){
         
             $val1[$val1->name] =$items;

              $item_images = ItemImage::where('item_id',$val2->id)->get();
               $item_desc =ItemDescription::where('item_id',$val2->id)->get();
              foreach($item_images as $val3){
     
                  $val2[$val2->item_name] =$item_images;
                
             }
             foreach($item_desc as $val4){
              $val2['desc'.$val2->item_name] =$item_desc;
             }               
         }

        }
        
         $i++;
        
      } 
     // dd($categories);
      return view('user.home1',compact('categories','items','restaurant_name','find_resto'));
  }else{
      return redirect()->back()->with('error', 'No Restaurant Found');
  }
      //dd($i); 
 // dd($categories);
      
  }


  //////
  public function index(Request $request)
  {
     
      $this->validate($request,[
          "restaurant_id"=>'required'
      ]);

    
      $find_resto = Restaurant::where(['resturant_id'=>ucwords($request->restaurant_id),'enabled'=>1])->first();
    
      if($find_resto){
          
        $categories = Category::whereNull('parent_id')->where('restaurant_id',$find_resto->id)->where('enabled',1)->get();
        foreach($categories as $val){
            $sub_cat = Category::where('parent_id',$val->id)->where('enabled',1)->get();
            foreach($sub_cat as $val1){
                $val['sub'.$val->category_name]=$sub_cat;
               $items = Item::where(['category_id'=>$val->id,'sub_category_id'=>$val1->id,'enabled'=>1])->get();

               foreach($items as $val2){
                   $val1[$val1->category_name] =$items;
                   $images =ItemImage::where('item_id',$val2->id)->get();
                   foreach($images as $val3){
                       $val2[$val2->item_name] = $images;
                   }
                   $desc =ItemDescription::where('item_id',$val2->id)->get();
                   foreach($desc as $val4){
                    $val2['desc'.$val2->item_name] = $desc;
                   }
                   $varients =Variety::where('item_id',$val2->id)->get();
                   
                   if($varients)
                   {                
                    $val2['varient'.$val2->item_name] = $varients;
                   }
               }

            }

            $items1 = Item::where(['category_id'=>$val->id,'enabled'=>1])->whereNull('sub_category_id')->get();         
            foreach($items1 as $value){
                $val[$val->category_name]=$items1;
             
                $images1 =ItemImage::where('item_id',$value->id)->get();
                foreach($images1 as $value1){
                    $value[$value->item_name] = $images1;
                }

                $desc1 =ItemDescription::where('item_id',$value->id)->get();
                foreach($desc1 as $val4){
                 $value['desc'.$value->item_name] = $desc1;
                }

                $varients =Variety::where('item_id',$value->id)->get();
                if($varients)                
                {
                  $value['varient'.$value->item_name] = $varients;
                }

            }

        }

        
   //   dd($categories);
      return view('user.home',compact('categories','items','restaurant_name','find_resto','find_table'));
  }else{
      return redirect()->back()->with('error', 'No Restaurant Found');
  }
      //dd($i); 
 // dd($categories);
      
  }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function orderDetails(Request $request)
    {

      $mobile =$request->mobile;
      $table_id =$request->table_id;
      $res_id =$request->res_id;
      $taxes=Tax::where('restaurant_id',$res_id)->get();
      $order_details =Order::where('orders.mobile_no',$mobile)->where('restaurant_id',$res_id)->where('table_id',$table_id)->orderBy('id','DESC')->get();
      foreach($order_details as $val){
        $item =OrderItem::select('order_items.quantity','order_items.price','order_items.order_status','items.item_name')
        ->join('items','items.id','order_items.item_id')
        ->where('order_id',$val->id)->get();
        $val['item']=$item;

        $orderStatus=OrderStatus::select('name')->where('id',$val->order_status)->first();
        $val->order_status= $orderStatus->name;

      }

      $order_details1 =Order::where('orders.mobile_no','!=',$mobile)->where('restaurant_id',$res_id)->where('table_id',$table_id)->where('order_status',2)->orderBy('id','DESC')->get();
      foreach($order_details1 as $val){
        $item =OrderItem::select('order_items.quantity','order_items.price','order_items.order_status','items.item_name')
        ->join('items','items.id','order_items.item_id')
        ->where('order_id',$val->id)->get();
        $val['item']=$item;

        $orderStatus=OrderStatus::select('name')->where('id',$val->order_status)->first();
        $val->order_status= $orderStatus->name;

      }
    
      if(count($order_details) > 0){
      foreach($order_details as $val)
      {
        $subtotal=0;
        $tax=0;
        $total=0
      ?>

              <div class="table-responsive">
               <table class="table order-details">
                <thead>
                  <tr>
                    <th scope="col" colspan="3" class="border-0 bg-light">
                      <div class="p-12 px-3 text-uppercase"><b>Order ID:</b>  <?php echo $val->order_id; ?></div>
                    </th>
                    <th scope="col" colspan="2" class="border-0 bg-light">
                      <div class="p-12 px-3 text-uppercase"><b>Status:</b>  <?php echo $val->order_status; ?></div>
                    </th>
                  </tr>
                  <tr>
                    <td scope="col" colspan="3" class="border-0 bg-light">
                      <div class="p-12 px-3 "><b>Customer Name:</b>  <?php echo $val->name; ?></div>
                    </td>
                    <td scope="col" colspan="2" class="border-0 bg-light">
                      <div class="p-12 px-3 "><?php if($val->order_type == 1 ) echo '<b>Address:</b> Dine-in'; else  echo '<b>Address:</b> '. $val->address; ?></div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" colspan="2" class="border-0 bg-light">
                      <div class="p-2 px-3"><b>Item</b></div>
                    </th>
                    <th scope="col" colspan="1" class="border-0 bg-light">
                      <div class="py-2"><b>Status</b></div>
                    </th>
                    <th scope="col" colspan="1" class="border-0 bg-light">
                      <div class="py-2"><b>Qty</b></div>
                    </th>
                    <th scope="col" colspan="1" class="border-0 bg-light">
                      <div class="py-2"><b>Price</b></div>
                    </th>
                  </tr>
<!--                  <tr>
                    <th scope="col"  colspan="2" class="border-0 bg-light">
                      <div class="p-2 px-3 text-uppercase">Item</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Price</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Qty.</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase"></div>
                    </th>
                  </tr> -->
                </thead>
                <tbody>
                  <?php foreach($val->item as $val1){ ?>
                  <tr>
                    <td scope="col" class="border-0 bg-light" colspan="2" >
                      <div class="p-2 px-3"><?php echo $val1->item_name; ?></div>
                    </td>
                    <td scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo OrderStatus($val1->order_status); ?></div>
                    </td>
                    <td scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo $val1->quantity; ?></div>
                    </td>
                    <td scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php  

                      if($val1->order_status=='3')
                      {
                        echo '---';
                      }
                      else
                      {
                        $subtotal+=$val1->price * $val1->quantity; 
                        echo $val1->price * $val1->quantity; 

                      }
                      ?></div>
                    </td>
                  </tr>
                 <?php } ?>


                 <tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                        <div class="p-2 px-3">Sub Total:</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo $subtotal; ?></div>
                    </th>
                 </tr>
               <?php
             
                $taxAmt=0;
                $totalTax=0;
                if(count($taxes)>0){
                  foreach($taxes as $tax)
                  {
                    $taxAmt= (($subtotal*$tax->tax_value)/100);
                    $totalTax+=$taxAmt;
                    echo '<tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                      <div class="p-2 px-3">'.$tax->tax_name.'</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2">'.$taxAmt.'</div>
                    </th>
                   </tr>';

                  }
                }
                else{
                  $totalTax=0;
                  echo '<tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                      <div class="p-2 px-3">Tax (Already Inclusive in Price)</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2">'.$taxAmt.'</div>
                    </th>
                   </tr>';
                }
                 ?>

                 <tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                      <div class="p-2 px-3">Total:</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo $subtotal+$totalTax; ?></div>
                    </th>
                 </tr>

                </tbody>
                
              </table>
                  <div class="d-flex justify-content-around  p-3">                    
                    <button data-orderId="<?php echo $val->id; ?>" href="#" class="right btn btn-dark btn-sm feedback_order"> feedback</button> 
                  </div>
              </div>
              <br>  
      <?php
      } 
      } 
      ?>
             
            
      <?php
      if(count($order_details1) > 0){  
      foreach($order_details1 as $val)
      {
        $subtotal=0;
        $tax=0;
        $total=0

      ?>       
              <div class="table-responsive">
               <table class="table order-details">
                <thead>
                  <tr>
                    <th colspan="4" style="font-size:14px;">Partner Order Details</th>
                  </tr>
                  <tr>
                    
                    <th scope="col" colspan="3" class="border-0 bg-light">
                      <div class="p-12 px-3 text-uppercase"><b>Order ID:</b>  <?php echo $val->order_id; ?></div>
                    </th>
                    <th scope="col" colspan="2" class="border-0 bg-light">
                      <div class="p-12 px-3 text-uppercase"><b>Status:</b>  <?php echo $val->order_status; ?></div>
                    </th>
                  </tr>
                  <tr>
                    <td scope="col" colspan="3" class="border-0 bg-light">
                      <div class="p-12 px-3 "><b>Customer Name:</b>  <?php echo $val->name; ?></div>
                    </td>
                    <td scope="col" colspan="2" class="border-0 bg-light">
                      <div class="p-12 px-3 "><?php if($val->order_type == 1 ) echo '<b>Address:</b> Dine-in'; else  echo '<b>Address:</b> '. $val->address; ?></div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="col" colspan="2" class="border-0 bg-light">
                      <div class="p-2 px-3"><b>Item</b></div>
                    </th>
                    <th scope="col" colspan="1" class="border-0 bg-light">
                      <div class="py-2"><b>Status</b></div>
                    </th>
                    <th scope="col" colspan="1" class="border-0 bg-light">
                      <div class="py-2"><b>Qty</b></div>
                    </th>
                    <th scope="col" colspan="1" class="border-0 bg-light">
                      <div class="py-2"><b>Price</b></div>
                    </th>
                  </tr>

<!--                  <tr>
                    <th scope="col"  colspan="2" class="border-0 bg-light">
                      <div class="p-2 px-3 text-uppercase">Item</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Price</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Qty.</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase"></div>
                    </th>
                  </tr> -->
                </thead>
                <tbody>
                  <?php foreach($val->item as $val1){ ?>
                  <tr>
                    <td scope="col" class="border-0 bg-light" colspan="2" >
                      <div class="p-2 px-3"><?php echo $val1->item_name; ?></div>
                    </td>
                    <td scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo OrderStatus($val1->order_status); ?></div>
                    </td>
                    <td scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo $val1->quantity; ?></div>
                    </td>
                    <td scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php  

                      if($val1->order_status=='3')
                      {
                        echo '---';
                      }
                      else
                      {
                        $subtotal+=$val1->price * $val1->quantity; 
                        echo $val1->price * $val1->quantity; 

                      }
                      ?></div>
                    </td>
                  </tr>
                 <?php } ?>


                 <tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                        <div class="p-2 px-3">Sub Total:</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo $subtotal; ?></div>
                    </th>
                 </tr>
               <?php
             
                $taxAmt=0;
                $totalTax=0;
                if(count($taxes)>0){
                  foreach($taxes as $tax)
                  {
                    $taxAmt= (($subtotal*$tax->tax_value)/100);
                    $totalTax+=$taxAmt;
                    echo '<tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                      <div class="p-2 px-3">'.$tax->tax_name.'</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2">'.$taxAmt.'</div>
                    </th>
                   </tr>';

                  }
                }
                else{
                  $totalTax=0;
                  echo '<tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                      <div class="p-2 px-3">Tax (Already Inclusive in Price)</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2">'.$taxAmt.'</div>
                    </th>
                   </tr>';
                }
                 ?>

                 <tr>
                    <th scope="col" class="border-0 bg-light" colspan="4">
                      <div class="p-2 px-3">Total:</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2"><?php echo $subtotal+$totalTax; ?></div>
                    </th>
                 </tr>                 
                </tbody>
              </table>
                <div class="d-flex justify-content-around  p-3">                    
                    <button data-orderId="<?php echo $val->id; ?>" href="#" class="right btn btn-dark btn-sm feedback_order"> feedback</button> 
                </div>
              </div>
              <br>
              
<?php
      }       }
      
         if(count($order_details) > 0 || count($order_details1) > 0){
      ?>
            <div class="form-group form_buttons">                           
             <button id="" class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
           </div>
     
   <?php 
         }





   
      
      




    }


    public function coupanApply(Request $request){
        $data=array();
        $res_id =$request->res_id;
        $coupan =$request->coupan_code;
        $check_coupan_code =Coupan::where(['restaurant_id'=>$res_id,'coupan_code'=>$coupan])->first();
        if($check_coupan_code){
            if($check_coupan_code->count <= 100){
              if($check_coupan_code->coupan_type == 'fixed'){
                $status = "success";
                $msg = "coupon applied";
                $data['value'] =$check_coupan_code->coupan_value;
                $data['type'] =$check_coupan_code->coupan_type;
              }else{
                $status = "success";
                $msg = "coupon applied";
                $data['value'] =$check_coupan_code->coupan_value;
                $data['type'] =$check_coupan_code->coupan_type;
              }
            }else{
              $msg = "coupon expired";
              $status = "failed";
            }    
        }else{
            $msg = "invalid coupon";
            $status = "failed";
        }
       
      $result = array('status' => $status,'data'=>$data,'msg'=>$msg);
      return response()->json($result);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

    
   public function feedback(Request $request){
   $resto =$request->restaurant_name;
   $name = $request->name;
   $email = $request->email;
   $mobile = $request->mobile;
   $feed = $request->feedback;
   $id = $request->res_id;
   $rating =$request->stars;
   $order_id =$request->orderid;
   $all=$request->all();
   
    $img="";
    if($request->hasFile('file_img')){
    $file = $request->file('file_img');
    $fileName1 = uniqid('icon') . "" . $file->getClientOriginalName();
    $file->move('public/assets/feedback_file', $fileName1);
    $img = $fileName1;
    }
    $array =array('restaurant_id'=>$all['restaurant_id'],'restaurant_name'=>$all['restaurant_id'],'order_id'=>$order_id,'name'=>$name,'email'=>$email,'mobile'=>$mobile,'feedback'=>$feed,'rating'=>$rating,'file'=>$img);
    $feedback_id = Feedback::create($array)->id;

    if($feedback_id)
    {

      $all = $request->all();
      // $data['student_id'] = getUser()->id;
      //  $data['test_id'] = $test_id;
      $count = count($all);
      $count_correct_ans = 0;
      $skip_ques=0;

      foreach($all as $key => $val)
      {
        $data = array();
        $data['feedback_id'] = $feedback_id;      
        $data['restaurant_id']=$all['restaurant_id'];
        $customKey='question_id-'.$val;
      
        if($key == $customKey)
        {
          $data['question_id'] = $val;
          $data['answer'] = 'ans_'.$val;
          $data['question_type_id'] =$all['question_type_id-'.$val];
          $data['option_id'] =$all['answer_id-'.$val];
          QuestionAnswer::create($data);
        }
      }
    }
//$feedback_id=true;
   if ($feedback_id){
        $status = "success";
    } else {
        $status = "failed";
    }
    $result = array('status' => $status);
    return response()->json($result);
      
  }  

  public function createOrder(Request $request){
    $data=json_decode($request->cartdata,true);

    TempCart::create([
                    'restaurant_id' => $data['details']['restaurant_id'],
                    'table_id' => $data['details']['table_id'],
                    'mobile_no' => $data['details']['mobile'],
                    'cart_details' => serialize($data),
                ]);

    $order_uid= $this->unique_id(12);
    //DB::table('orders')->orderBy('id', 'DESC')->first();
    $order_id = Order::create([
                    'order_id' => $order_uid,
                    'restaurant_id' => $data['details']['restaurant_id'],
                    'table_id' => $data['details']['table_id'],
                    'mobile_no' => $data['details']['mobile'],
                    'daily_display_number' => '001',
                    'order_status' => '1',
                    'sub_total' => '1',
                    'tax' => '0',
                    'total' => '1',
                ])->id;

    // print_r($request->input('data'));
//    $status = "success";
  //  $result = array('status' => $status);
    //return response()->json($result);
    
    return response()->json($data);
    return response()->json($request->cartdata);
    return response()->json($_COOKIE);
    die;
    $resto =$request->restaurant_name;
    $name = $request->name;
    $email = $request->email;
    $mobile = $request->mobile;
    $feed = $request->feedback;
    $id = $request->res_id;
    $rating =$request->rating;

    $img="";
    if($request->hasFile('file_img')){
      $file = $request->file('file_img');
      $fileName1 = uniqid('icon') . "" . $file->getClientOriginalName();
      $file->move('public/assets/feedback_file', $fileName1);
      $img = $fileName1;
    }
    $array =array('restaurant_id'=>$id,'restaurant_name'=>$resto,'name'=>$name,'email'=>$email,'mobile'=>$mobile,'feedback'=>$feed,'rating'=>$rating,'file'=>$img);
    $created = DB::table('feedbacks')->insert($array);

    if ($created){
      $status = "success";
    } else {
      $status = "failed";
    }
    $result = array('status' => $status);
    return response()->json($result);
      
  }  

  public function cartupdate(Request $request){
    $result=array();
    $subtotal=0;
    $data=json_decode($request->cartdata,true);
    date_default_timezone_set('Asia/Kolkata');
    TempCart::create([
                    'restaurant_id' => $data['details']['restaurant_id'],
                    'table_id' => $data['details']['table_id'],
                    'mobile_no' => $data['details']['mobile'],
                    'cart_details' => serialize($data),
                ]);
    $orderD = Order::select('daily_display_number')->where('restaurant_id',$data['details']['restaurant_id'])->orderBy('id','DESC')->first();
    $gstDetails = Restaurant::select('gst')->where('id',$data['details']['restaurant_id'])->orderBy('id','DESC')->first();    
    $taxes=Tax::where(['restaurant_id'=>$data['details']['restaurant_id'],'enabled'=>1])->get();


    if($orderD){
      $daily_display_number = $orderD->daily_display_number+1;
    }
    else{
      $daily_display_number = 1;
    }

    $customer=Customer::where(['mobile_no'=>$data['details']['mobile']])->first();
    $order_uid= $this->unique_id(8);
    //DB::table('orders')->orderBy('id', 'DESC')->first();
    $order_id = Order::create([
                    'order_id' => $order_uid,
                    'restaurant_id' => $data['details']['restaurant_id'],
                    'table_id' => $data['details']['table_id'],
                    'mobile_no' => $data['details']['mobile'],
                    'name' => $data['details']['fullname'],
                    'address' => $data['details']['delivery_address'],
                    'instruction' => $data['details']['instructions'],
                    'order_type' => 1,
                    'daily_display_number' => $daily_display_number,
                    'order_status' => '1',
                    'sub_total' => '1',
                    'tax' => '0',
                    'total' => '1',
                ])->id;
    $result['id']=$order_id;
    $result['order_id']=$order_uid;
    $result['daily_display_number']=$daily_display_number;

    $close_time = date('h:i:s A',strtotime("8 PM"));
    //$open_time= date('h:i:s',strtotime("6 AM"));
     $current_time=date("h:i:s A");
   // $current_time=date('h:i:s A',strtotime("10 PM"));
     
      $start = '09:00:00';
      $end = '20:00:00';
     $now = Carbon::now('UTC');
      $nowTime = $now->hour.':'.$now->minute.':'.$now->second;
      if(strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) ) {
          
      } else {
        $template="Your order will be processed in next working session";
        if($customer->isd_code=='91')
        {
            $mobile_no=$customer->mobile_no;
            $status=send_local_sms_new($mobile_no ,$template);
        }
        else
        {   
            $mobile_no = $customer->isd_code.$customer->mobile_no;
            $status=send_isd_sms($mobile_no ,$template);
        }
  
        $mobile_no=$customer->isd_code.$customer->mobile_no;
        $status=send_whatsapp_message_new($mobile_no,$template);
          
      }

    if ($current_time >= $close_time){
      // $template="Your order will proceed  in working session";
      // if($customer->isd_code=='91')
      // {
      //     $mobile_no=$customer->mobile_no;
      //     $status=send_local_sms_new($mobile_no ,$template);
      // }
      // else
      // {   
      //     $mobile_no = $customer->isd_code.$customer->mobile_no;
      //     $status=send_isd_sms($mobile_no ,$template);
      // }

      // $mobile_no=$customer->isd_code.$customer->mobile_no;
      // $status=send_whatsapp_message_new($mobile_no,$template);
    }else{
     
     }
  
   
    $result['status']="success";
    // $result['detail']['restaurant_id']=$data['details']['restaurant_id'];
    // $result['detail']['table_id']=$data['details']['table_id'];
    if($order_id)
    {
      foreach ($data as $itemId => $item) {
        if($itemId!=='details')
        {                    
          if(isset($item['varientId']))
          {
            foreach ($item['varientId'] as  $varientId => $varient)
            {
              OrderItem::create([
                'order_id'=>$order_id,
                'item_id'=>$itemId,
                'order_status'=>1,
                'varient_id'=>$varientId,
                // 'price'=>($item['price']+$varient['varientPrice']),
                'price'=>$varient['varientPrice'],
                'quantity'=>$varient['varientQuantity']
              ]);
              // $subtotal+=($item['price']+$varient['varientPrice'])*$varient['varientQuantity'];
              $subtotal+=($varient['varientPrice'])*$varient['varientQuantity'];
            }
          }
          else{
            OrderItem::create([
              'order_id'=>$order_id,
              'item_id'=>$itemId,
              'order_status'=>1,
              'price'=>($item['price']),
              'quantity'=>$item['qty']
            ]);
            $subtotal+=$item['price']*$item['qty'];
          }
        }      
      }
    }
    $taxAmt=0;
    $totalTax=0;
    if(count($taxes)>0){                      
      foreach($taxes as $tax)
      {
        $taxAmt= (($subtotal*$tax->tax_value)/100);
        $totalTax+=$taxAmt;
        OrderTax::create([
          'order_id'=>$order_id,
          'tax_id'=>$tax->id,
          'tax_value'=>$tax->tax_value,
          'tax_amount'=>$taxAmt
        ]);
      }
    }
    else{
      $totalTax=0;
    }

    // if($gstDetails->gst)
    // {
    //   $tax=(($subtotal*5)/100);
    // }
    // else{
    //   $tax=0;
    // }

    $total=$subtotal+$totalTax;
    Order::where('id',$order_id)->update(['sub_total'=>$subtotal,'tax'=>$totalTax,'total'=>$total]);

    // print_r($request->input('data'));
//    $status = "success";
  //  $result = array('status' => $status);
    //return response()->json($result);
    
    return response()->json($result);
    return response()->json($data);
    return response()->json($request->cartdata);
    return response()->json($_COOKIE);
    die;
    $resto =$request->restaurant_name;
    $name = $request->name;
    $email = $request->email;
    $mobile = $request->mobile;
    $feed = $request->feedback;
    $id = $request->res_id;
    $rating =$request->rating;

    $img="";
    if($request->hasFile('file_img')){
      $file = $request->file('file_img');
      $fileName1 = uniqid('icon') . "" . $file->getClientOriginalName();
      $file->move('public/assets/feedback_file', $fileName1);
      $img = $fileName1;
    }
    $array =array('restaurant_id'=>$id,'restaurant_name'=>$resto,'name'=>$name,'email'=>$email,'mobile'=>$mobile,'feedback'=>$feed,'rating'=>$rating,'file'=>$img);
    $created = DB::table('feedbacks')->insert($array);

    if ($created){
      $status = "success";
    } else {
      $status = "failed";
    }
    $result = array('status' => $status);
    return response()->json($result);
      
  }  

  public function generateotp(Request $request){
    $receiverMobile = $request->mob;
    $receiverMobile = str_replace('+', '', $receiverMobile);
    $mobDetails = explode(' ', $receiverMobile);
    $receiverMobile = str_replace(' ', '', $receiverMobile);

    Customer::updateOrCreate(['mobile_no'=>$mobDetails[1],'isd_code'=>$mobDetails[0]],[]);
    // $data=json_decode($request->mob,true);
    // return response()->json($data);

    // $result = array('status' => 'success','otp'=>$mobDetails[1]);
    // return response()->json($result);



    $five_digit_otp = mt_rand(10000, 99999);
  
    $template = "QRestro Otp: ".$five_digit_otp;
    if($mobDetails[0]=='91')
    {
      $mobile_no=$mobDetails[1];
    $status=send_local_sms($mobile_no ,$template);
    }
    else
    {
      $mobile_no=$mobDetails[0].$mobDetails[1]; 
      send_isd_sms($mobile_no ,$template);
    }

    $mobile_no=$mobDetails[0].$mobDetails[1]; 
    $status=send_whatsapp_message($mobile_no ,$template);

    $result = array('status' => $status,'otp'=>$five_digit_otp,'isd'=>$mobDetails[0],'mobile_no'=>$mobDetails[1]);
    return response()->json($result);
      
  }

  public function unique_id($l = 8) {
      return substr(md5(uniqid(mt_rand(), true)), 0, $l);
  }


  public function feedbackQuestion(Request $request){
    $resto =$request->all();
     
    
    $all = $request->all();
      $data = array();
     // $data['student_id'] = getUser()->id;
    //  $data['test_id'] = $test_id;
      $count = $all['count'];

      $count_correct_ans = 0;
      $skip_ques=0;
      for($i=1; $i<=$count; $i++){
          $data['question_id'] = $all['question'.$i];
          $data['answer'] = $all['answer'.$i];
          $opt = $all['answer'.$i];
          $data['question_type_id'] =$all['question_type_id'.$i];
          $q_type =$all['question_type_id'.$i];
          if($q_type == 3){
            $data['option_id'] = 0;
          }else{
             $ex=explode('_',$opt);
             $data['option_id'] = $ex[1];
          }
         
          $data['restaurant_id']=$all['restaurant_id'];
               $created=QuestionAnswer::create($data);
      }


 
 
     if ($created){
         $status = "success";
      } else {
          $status = "failed";
      }
     $result = array('status' => $status,'msg'=>"submit successfully");
     return response()->json($result);
       
   }  

   public function getDetails(Request $request)
   {
      $mobile =$request->mobile;
      $order_details =Order::where('orders.mobile_no',$mobile)->where('orders.name','<>','')->orderBy('id','DESC')->first();
      if ($order_details){
        $result = $order_details->toArray();
        $result['status']='success'; 
      } else {
        $result=array('name' => '','address'=>'' );
        $result['status']='fail'; 
      }

      return response()->json($result);

   }

   public function addAddresses(Request $request)
   {

      $data=$request->all();

      CustomerAddress::create([
        'mobile_no' => $data['mobile_no'],
        'full_name' => $data['full_name'],
        'street_address_1' => $data['street_address_1'],
        'street_address_2' => $data['street_address_2'],
        'city' => $data['city'],
        'state' => $data['state'],
        'zip' => $data['zip'],
        'country' => 'IN',
      ]);


      $addresses =CustomerAddress::where('mobile_no',$data['mobile_no'])->orderBy('id','DESC')->get();
      if ($addresses){
        $result['data'] = $addresses->toArray();
        $result['status']='success'; 
      } else {
        $result['data']=array();
        $result['status']='fail'; 
      }

      return response()->json($result);

   }

   public function getAddresses(Request $request)
   {

      $data=$request->all();

      $addresses =CustomerAddress::where('mobile_no',$data['mobile_no'])->orderBy('id','DESC')->get();
      if (count($addresses) > 0) 
      {
        $result['data'] = $addresses->toArray();
        $result['status']='success'; 
      } else {
        $result['data']=array();
        $result['status']='fail'; 
      }

      return response()->json($result);

   }

   public function trackingId(Request $request)
   {
      $restro_id=$request->restaurant_id;
      $data =RestaurantSeo::where('restaurant_id',$restro_id)->first();
      if (!empty($data)) 
      {
        $result['data'] = $data;
        $result['status']='success'; 
      } else {
        $result['data']=array();
        $result['status']='fail'; 
      }

      return response()->json($result);

   }



  //  public function send_isd_sms($receiverMobile, $bill_id)
  //  {
  //      $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
  //      $parameters = json_encode([
  //       'to'=> '+'.$receiverMobile,
  //       'platform'=> 'web',
  //       'text' => $template
  //      ]);

  //      $url = "https://api.checkmobi.com/v1/sms/send";
  //      $ch = curl_init();
  //      curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
  //      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
                                                                   
  //      curl_setopt($ch, CURLOPT_POST, 1);
  //      curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);

  //      $headers = array(
  //          'Content-Type: application/json',
  //          'Authorization: 67D23A97-F6AE-4EC0-A8EA-63382F5D3168'
  //      );
  //      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  //      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  //      $result = curl_exec($ch);
  //      // print_r($result);
  //      if(curl_errno($ch))  //catch if curl error exists and show it
  //      {
  //        $status = "failed";
  //      }
  //      else
  //      {
  //        $status = "success";
  //      }
  //      curl_close($ch);
  //      return $status;
  //  }



   public function send_whatsapp($receiverMobile, $bill_id)
   {
       // $data=json_decode($request->mob,true);
       // return response()->json($data);
       //http://smstech.techstreet.in/sms-panel/api/http/index.php?username=outdosolution&apikey=E50D9-FFA5D&apirequest=Text&sender=TSTMSG&mobile=9716440096&message=SMSMessage&route=TRANS&format=json

       //    $five_digit_otp = mt_rand(10000, 99999);


       $template = "We hope you enjoyed your meal. The payment link is available at: ".url('/').'/billpayments/'.$bill_id;
       $parameters = http_build_query([
        'channel' => 'whatsapp',
        // 'destination'=> '91'.$receiverMobile,
        'destination'=> $receiverMobile,
        'source' => '917834811114',
        'src.name'=> 'qrestroapi2',
        'message' => $template
       ]);

/*
       $parameters = json_encode([
        'channel' => 'whatsapp',
        'destination'=> '919716076512',
        'source' => '917834811114',
        'src.name'=> 'qrestroapp',
         // 'message' => json_encode(array( "isHSM" =>"false", "type" => "text", "text" => $template ))
        'message' => array( 
                             "isHSM" =>"false",
                             "type" => "text",
                             "text" => $template
                           )
       ]);
*/

       $url = "https://api.gupshup.io/sm/api/v1/msg";

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
       // curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
       // curl_setopt($ch, CURLOPT_HEADER, 0);
                                                                   
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);

       // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
       // curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

       $headers = array(
           'Content-Type: application/x-www-form-urlencoded',
           'apikey: d0fb0073a14c46a4c67f2dc7f34e2a5f'
       );
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



       curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
       $result = curl_exec($ch);
       
       if(curl_errno($ch))  //catch if curl error exists and show it
       {
       //      echo 'Curl error: ' . curl_error($ch); //save the response in db;
         $status = "failed";
       }
       else
       {
         $status = "success";
       }
       curl_close($ch);
       return $status;
   }

}
