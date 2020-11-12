<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\User;
use App\ErrorCode;

if (! function_exists('getDeliveryFee')) {
    function getDeliveryFee($subtotal){
		$data = DB::table('delivery_fees')
			->select('delivery_charge')
			->where('amount_limit','>',$subtotal)
			->first();
		if($data){
			return $data->delivery_charge;
		}
		else{
			return 0;
		}
	}
}

if (! function_exists('date_dfy')) {
    function date_dfy($date){
		if($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00'){
			return '';
		}
		else{
			return date_format(date_create($date),"d-F-Y");
		}
	}
}

if (! function_exists('date_dmy')) {
    function date_dmy($date){
		if($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00'){
			return '';
		}
		else{
			return date_format(date_create($date),"d-M-Y");
		}
	}
}

if (! function_exists('date_ymd')) {
    function date_ymd($date){
		if($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00'){
			return '';
		}
		else{
			return date_format(date_create($date),"Y-m-d");
		}
	}
}

if (! function_exists('am_pm')) {
    function am_pm($time){
		if($time == ''){
			return '';
		}
		else{
			$new_time = new DateTime($time);
			return $new_time->format('h:i A');
		}
	}
}

if (! function_exists('getMonthName')) {
    function getMonthName($number){
		$months = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
		$date = getdate();
		return $months[$number];
	}
}

if (! function_exists('noneIfEmpty')) {
    function noneIfEmpty($data){
		if(empty($data)){
			return 'N/A';
		}
		else{
			return $data;
		}
	}
}

if (! function_exists('zeroIfEmpty')) {
    function zeroIfEmpty($data){
		if(empty($data)){
			return '0';
		}
		else{
			return $data;
		}
	}
}


if (! function_exists('getErrorMessage')) {
    function getErrorMessage($code){
			$data = DB::table('error_codes')
				->select('error_message')
				->where([
					['error_code',$code]
				])
				->first();
			if($data){
				return $data->error_message;
			}
			else{
				return null;
			}
			
	}
}

if (! function_exists('getCategoryName')) {
    function getCategoryName($code){
			$data = DB::table('categories')
				->select('category_name')
				->where([
					['id',$code]
				])
				->first();
			if($data){
				return $data->category_name;
			}
			else{
				return null;
			}
			
	}
}

if (! function_exists('getProductName')) {
    function getProductName($code){
			$data = DB::table('items')
				->select('item_name')
				->where([
					['id',$code]
				])
				->first();
			if($data){
				return $data->item_name;
			}
			else{
				return null;
			}
			
	}
}

if (! function_exists('send_local_sms_new')) {
	function send_local_sms_new($mobile_no ,$template){

        $parameters = http_build_query([
         'username' => 'outdosolution',
         'apikey' => 'E50D9-FFA5D',
         'apirequest' => 'Text',
         'sender' => 'QRESTR',
         'route' => 'TRANS',
         'format' => 'json',
         'mobile'=> $mobile_no,
         'message' => $template
        ]);

        $url = "http://smstech.techstreet.in/sms-panel/api/http/index.php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'?'.$parameters); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
      
        if(curl_errno($ch))  //catch if curl error exists and show it
        {
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

if (! function_exists('send_whatsapp_message_new')) {
	function send_whatsapp_message_new($mobile_no ,$template){

		$parameters = http_build_query([
			'channel' => 'whatsapp',
			'source' => '917834811114',
			'destination'=> $mobile_no,
			'src.name'=> 'qrestroapi2',
			'message' => $template
		]);
		$url = "https://api.gupshup.io/sm/api/v1/msg";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
		$headers = array(
		'Content-Type: application/x-www-form-urlencoded',
		'apikey: d0fb0073a14c46a4c67f2dc7f34e2a5f'
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$result = curl_exec($ch);
		// echo $mobile_no;
		// echo $template;
		// print_r($result);
		if(curl_errno($ch))  //catch if curl error exists and show it
		{
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


if (! function_exists('checkForCopy')) {
    function checkForCopy($id){
			$data = DB::table('categories')
				->select('id')
				->where([
					['restaurant_id',$id]
				])
				->first();
			if($data){
				return $data->id;
			}
			else{
				return null;
			}
			
	}
}

if (! function_exists('getParent')) {
    function getParent($id){
			$data = DB::table('categories')
				->select('category_name')
				->where([
					['id',$id]
				])
				->first();
			if($data){
				return $data->category_name;
			}
			else{
				return "null";
			}
			
	}
}

if (! function_exists('taxEnabled')) {
    function taxEnabled($id){
			$data = DB::table('restaurants')
				->select('gst')
				->where([
					['id',$id]
				])
				->first();
			if($data){
				return $data->gst;
			}
			else{
				return "null";
			}
			
	}
}

if (! function_exists('getLogo')) {
    function getLogo($id){
			$data = DB::table('restaurants')
				->select('logo')
				->where([
					['id',$id]
				])
				->first();
			if($data){
				if($data->logo){	
				return $data->logo;
				}else{
					return null;
				}
			}
			else{
				return null;
			}
			
	}
}

if (! function_exists('getLogo2')) {
    function getLogo2($id){
	  $res_id = DB::table('restaurant_users')->select('restaurant_id')->where('id',$id)->first();
	
			$data = DB::table('restaurants')
				->select('logo')
				->where([
					['id',$res_id->restaurant_id]
				])
				->first();
			if($data){
				if($data->logo){	
				return $data->logo;
				}else{
					return null;
				}
			}
			else{
				return null;
			}
			
	}
}




if (! function_exists('varient')) {
    function varient($id){
			$data = DB::table('varieties')
				->select('name')
				->where([
					['id',$id]
				])
				->first();
			if($data){
				return $data->name;
			}
			else{
				return 0;
			}
			
	}
}


if (! function_exists('QuestionType')) {
    function QuestionType($id){
	
		$data = DB::table('question_types')
			->select('type')
			->where('id',$id)
			->first();
			
			if($data){
				return $data->type;
			}
			else{
				return "";
			}
			
		}			
}



if (! function_exists('OrderStatus')) {
    function OrderStatus($id){
	
		$data = DB::table('order_statuses')
			->select('name')
			->where('id',$id)
			->first();
			
			if($data){
				return $data->name;
			}
			else{
				return "";
			}
			
		}			
}


if (! function_exists('get_admin_module_permission')) {
    function get_admin_module_permission($restaurant_id,$user_type,$slug){
	
		$data = DB::table('admin_module_privileges')
				->select('view','create','update')
				->where('restaurant_id',$restaurant_id)
				->where('user_type',$user_type)
				->where('module_slug',$slug)
				->first();
				
		if($data){
			return $data;
		}
		else{
			return "";
		}
	}			
}


if (! function_exists('convertYoutube')) {
    function convertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
			$string
		);
	}
}


if (! function_exists('cnvt_UTC_to_usrTime')) {
	function cnvt_UTC_to_usrTime($Date_Time,$User_time_Zone){

	    date_default_timezone_set('UTC');

	    $LocalTime_start_time = new DateTime( $Date_Time );
	    $tz_start = new DateTimeZone( $User_time_Zone );
	    $LocalTime_start_time->setTimezone( $tz_start );
	    $start_date_time = (array) $LocalTime_start_time;

	    return $StartDateTime = $start_date_time['date'];

	// echo      $tommorow = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(),'America/Los_Angeles') . "+1 day"));

	}
}

if (! function_exists('is_fileurl_exist')) {
	function is_fileurl_exist($imageUrl){

		$headers=get_headers($imageUrl);
		return stripos($headers[0],"200 OK")?true:false;
	}
}

if (! function_exists('send_isd_sms')) {
	function send_isd_sms($mobile_no ,$template){

        $parameters = json_encode([
         'to'=> '+'.$mobile_no,
         'platform'=> 'web',
         'text' => $template
        ]);

        $url = "https://api.checkmobi.com/v1/sms/send";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
                                                                    
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: 67D23A97-F6AE-4EC0-A8EA-63382F5D3168'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        if(curl_errno($ch))  //catch if curl error exists and show it
        {
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


if (! function_exists('send_local_sms')) {
	function send_local_sms($mobile_no ,$template){

        $parameters = http_build_query([
         'username' => 'outdosolution',
         'apikey' => 'E50D9-FFA5D',
         'apirequest' => 'Text',
         'sender' => 'QRESTR',
         'route' => 'TRANS',
         'format' => 'json',
         'mobile'=> $mobile_no,
         'message' => $template
        ]);

        $url = "http://smstech.techstreet.in/sms-panel/api/http/index.php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'?'.$parameters); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0)");
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
      
        if(curl_errno($ch))  //catch if curl error exists and show it
        {
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

if (! function_exists('send_whatsapp_message')) {
	function send_whatsapp_message($mobile_no ,$template){

		$parameters = http_build_query([
			'channel' => 'whatsapp',
			'destination'=> $mobile_no,
			'source' => '917834811114',
			'src.name'=> 'qrestroap12',
			'message' => $template
		]);
		$url = "https://api.gupshup.io/sm/api/v1/msg";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30); //Timeout after 7 seconds
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
		$headers = array(
		'Content-Type: application/x-www-form-urlencoded',
		'apikey: d0fb0073a14c46a4c67f2dc7f34e2a5f'
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$result = curl_exec($ch);
		// echo $mobile_no;
		// echo $template;
		// print_r($result);
		if(curl_errno($ch))  //catch if curl error exists and show it
		{
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




if (! function_exists('create_time_range')) { 
	function create_time_range($start, $end, $interval = '30 mins', $format = '12') {
	    $startTime = strtotime($start); 
	    $endTime   = strtotime($end);
	    $returnTimeFormat = ($format == '12')?'g:i:s A':'G:i:s';

	    $current   = time(); 
	    $addTime   = strtotime('+'.$interval, $current); 
	    $diff      = $addTime - $current;

	    $times = array(); 
	    while ($startTime < $endTime) { 
	        $times[] = date($returnTimeFormat, $startTime); 
	        $startTime += $diff; 
	    } 
	    $times[] = date($returnTimeFormat, $startTime); 
	    return $times; 
	}

}


if (! function_exists('get_avaliable_slot')) { 
	function get_avaliable_slot($start,$range) {

		foreach ($range as $key=>$value) {
			if(strtotime($start) > strtotime($value))
			{
				unset($range[$key]);
			}
		}
		return $range;
	}
}




?>