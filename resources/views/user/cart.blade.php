<?php 

  $currTime = date("G:i", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata')));
  $today = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata')));
  $tommorow = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata') . "+1 day"));
  $day_after = date("mdY", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata')  . "+2 day"));
  
  $tommorow_dd = date("m-d-Y", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata') . "+1 day"));
  $day_after_dd = date("m-d-Y", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata')  . "+2 day"));

  $currTime12hrs = date("h:i:s A", strtotime(cnvt_UTC_to_usrTime(now(),'Asia/Kolkata') . "+1 hour"));

  $range_today='';
  $range_tomorrow='';
  $range_day_after='';

// $currTime= '20:20';
// $currTime12hrs='08:36:51 PM';
if($currTime > '10:00' && $currTime < '19:01')
{
  $date_1 = $today;
  $date_2 = $tommorow;
  $date_1_dd = 'Today';
  $date_2_dd = 'Tommorow';

  $range_today=create_time_range('10:00','20:30','30 mins');  
  $range_today=get_avaliable_slot($currTime12hrs,$range_today);
  // print_r($range_today);
  $range_tomorrow=create_time_range('10:00','20:30','30 mins');  
  $range_date_1 = $range_today;
  $range_date_2 = $range_tomorrow;
}
else if($currTime < '10:00')
{
  $date_1 = $today;
  $date_2 = $tommorow;

  $date_1_dd = 'Today';
  $date_2_dd = 'Tommorow';

  $range_today=create_time_range('10:00','20:30','30 mins');  
  $range_tomorrow=create_time_range('10:00','20:30','30 mins');  
  $range_date_1 = $range_today;
  $range_date_2 = $range_tomorrow;

}
else if($currTime > '19:00')
{
  $date_1 = $tommorow;
  $date_2 = $day_after;

  $date_1_dd = $tommorow_dd;
  $date_2_dd = $day_after_dd;

  $range_tomorrow=create_time_range('10:00','20:30','30 mins');    
  $range_day_after=create_time_range('10:00','20:30','30 mins');  
  $range_date_1 = $range_tomorrow;
  $range_date_2 = $range_day_after;

}
else{
  $date_1 = $today;
  $date_2 = $tommorow;

  $date_1_dd = 'Today';
  $date_2_dd = 'Tommorow';

  $range_today=create_time_range('10:00','20:30','30 mins');  
  $range_tomorrow=create_time_range('10:00','20:30','30 mins');  
  $range_date_1 = $range_today;
  $range_date_2 = $range_tomorrow;

}

// $range=create_time_range('10:00','20:30','30 mins');
// print_r($range);

// print_r($range);


// echo '<pre>';
// echo $date_1;
// print_r($range_today);
// print_r($range_tomorrow);
// print_r($range_day_after);
// echo $date_2;
// die;


?>

<?php $cartCookie; 
$ruppeeSign='&#8377;';
$ruppeeSign=$currency->symbol;
// setcookie($url, '', time() + (86400 * 30), "/"); // 86400 = 1 day
if(isset($_COOKIE[$url])) 
    $cartCookie=json_decode($_COOKIE[$url],true);  // print_r($cartCookie); 
$totalcartCount=0;
$subTotal = 0;
//print_r($taxes);
// print_r($questions);

// print_r($cartCookie);
//  die;
//dd($currency->code);
$currency_code=strtolower($currency->code);

if($url=='e772f6bf')
{
    header('Location: https://techstreet.in/restaurant/moglicafe/');
    exit;
}


if(isset($_COOKIE['qcart1'])) 
    $detailsCookie=json_decode($_COOKIE['qcart1'],true);  // print_r($cartCookie); 
?>
<?php // print_r($find_resto); ?>

<?php 
// print_r($find_resto->home_delivery);
// print_r($find_resto->take_away);
// die;
?>

<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $trackingId; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $trackingId; ?>');
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Qrestro.com - {{$find_resto->name}}</title>
    <link href="{{URL::asset('public/assets/images/favicon.png')}}" rel="icon" />
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> -->
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
    <script
      src="https://code.jquery.com/jquery-3.1.0.min.js"
      integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
      crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/css/icons.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/login-box.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/css/intlTelInput.css')}}">

    <style>
        select.form-control{
            height: 40px !important;
        }
    </style>

</head>
<body>
  <div class="top-header"></div>      
  <div class="grid-section">
      <!-- <div class="logo" ><img src="{{asset('public/assets/restaurant-logo/'.$find_resto->logo)}}" title="{{$find_resto->name}}" alt="{{$find_resto->name}}"/></div>     -->
      <h1 class="text-white">{{$find_resto->name}}</h1>
      <input type="hidden" name="restro_id" class="restro_id"  id="restro_id" value="{{$find_resto->id}}">
      <?php if($find_table){ ?>
      <input type="hidden" name="table_id" class="table_id"  id="table_id" value="{{$find_table->id}}">
      <?php } else { ?>
      <input type="hidden" name="table_id" class="table_id"  id="table_id" value="0">
      <?php }?>
        <!-- <a href = "newpage.html">Next Page</a> -->
  </div>
  <div id="newOrderDetails">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 bg-white rounded shadow-sm">
          <div class="od-center">
            <div class="thanks-heading"><h2>Your Order has been placed successfully.</h2></div>
            <!-- <div class="thanks-sub-line"><h4></h4></div> -->
            <div class="orderdet"><ul>
                <li><span>Order#</span>:<span class="orderid"></span></li>  
                <li><span>Order Date#</span>:<span class="orderDate"></span></li>  
                <li><span>Order Display No.#</span>:<span class="orderDisplay"></span></li>  
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- cart html start -->
  <div class="px-4 px-lg-0 cartStyle">
    <div class="pb-5">
      <div class="container">
        <div class="row bg-white rounded shadow-sm">
          <div class="col-lg-12 p-5  mb-5">
            <h1 class="display-4">Cart</h1>
            <!-- Shopping cart table -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-2 px-3 text-uppercase">Product</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Price</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Quantity</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Remove</div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if(isset($cartCookie) && is_array($cartCookie))
                  foreach ($cartCookie as $itemId => $item) {
                    if($itemId!=='details')                    
                    {
                      if(isset($item['varientId']))
                      {
                        // print_r($item);
                        foreach ($item['varientId'] as  $varientId => $varient)
                        {
                        // print_r($varient);
                        ?>
                        <tr class="item-line{{$itemId}}-{{$varientId}} itemRow">
                          <th scope="row" class="border-0">
                            <div class="p-2">
                              <img src="<?php $img_path = str_replace(' ','%20', $item['image']); $img_path1 = str_replace(' ','+', $item['image']); if(is_fileurl_exist($img_path)){ echo $img_path; $image='display:block';} else if(is_fileurl_exist($img_path1)){ echo $img_path1; $image='display:block';}  else { $image='display:none';} ?>" alt="" width="70" class="img-fluid rounded shadow-sm" style="{{$image}}">
                              <div class="ml-3 d-inline-block align-middle">
                                <div class="pro-type">
                                  <div class="{{$item['itype']}}-product"></div>
                                </div>
                                <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">{{$item['item']}} (<?php echo $varient['varientName'];?>)</a></h5>
                                <!-- <span class="text-muted font-weight-normal font-italic d-block">  Vairent: </span> -->
                              </div>
                            </div>
                          </th>
                          <td class="border-0 align-middle"><strong class="price" data-price="<?php echo ($varient['varientPrice']);?>"><?php echo $ruppeeSign.($varient['varientPrice']); $subTotal+=($varient['varientPrice'])*$varient['varientQuantity']; ?></strong></td>
                          <td class="border-0 align-middle">
                            <strong>
                              <div class="center">
                                <div class="input-group" data-itemid="{{$itemId}}"  data-varientid="{{$varientId}}" data-itemname="{{$item['item']}}", data-price="<?php echo $varient['varientPrice'];?>" data-image="{{$item['image']}}">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn btn-danger btn-number removeItemVarient" data-type="minus" data-field="quant[2]">
                                        <span class="glyphicon glyphicon-minus"></span>
                                      </button>
                                  </span>
                                  <input type="text" name="quant[2]" class="form-control input-number" readonly="true" value="<?php echo $varient['varientQuantity']; $totalcartCount+=$varient['varientQuantity'];?>" min="1" max="50">
                                  <span class="input-group-btn">
                                      <button type="button" class="btn btn-success btn-number addItemVarient" data-type="plus" data-field="quant[2]">
                                          <span class="glyphicon glyphicon-plus"></span>
                                      </button>
                                  </span>
                                </div>
                              </div>
                            </strong>
                          </td>
                          <td class="border-0 align-middle"><a href="#" class="text-dark deleteItem" data-delete="item-line{{$itemId}}-{{$varientId}}" data-type="varient" data-itemId="{{$itemId}}" data-varientid="{{$varientId}}"><i class="fa fa-trash"></i></a></td>
                        </tr>


                        <?php
                      }
                    }
                    else{
                    ?>

                   <tr class="item-line{{$itemId}} itemRow">
                      <th scope="row" class="border-0">
                        <div class="p-2">
                          <img src="<?php $img_path = str_replace(' ','%20', $item['image']); $img_path1 = str_replace(' ','+', $item['image']); if(is_fileurl_exist($img_path)){ echo $img_path; $image='display:block';} else if(is_fileurl_exist($img_path1)){ echo $img_path1; $image='display:block';}  else { $image='display:none';} ?>" alt="" width="70" class="img-fluid rounded shadow-sm" style="{{$image}}" >
                          <div class="ml-3 d-inline-block align-middle">
                            <div class="pro-type">
                              <div class="{{$item['itype']}}-product"></div>
                            </div>
                            <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">{{$item['item']}}</a></h5>
                            <!-- <span class="text-muted font-weight-normal font-italic d-block">  Vairent: Half</span> -->
                          </div>
                        </div>
                      </th>
                      <td class="border-0 align-middle"><strong class="price" data-price="<?php echo $item['price'];?>"><?php echo $ruppeeSign.$item['price'];  $subTotal+=($item['price'])*$item['qty']; ?></strong></td>
                      <td class="border-0 align-middle">
                        <strong>
                          <div class="center">
                            <div class="input-group" data-itemid="{{$itemId}}" data-itemname="{{$item['item']}}", data-price="{{$item['price']}}" data-image="{{$item['image']}}">
                              <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger btn-number removeItem"  data-type="minus" data-field="quant[2]">
                                    <span class="glyphicon glyphicon-minus"></span>
                                  </button>
                              </span>
                              <input type="text" name="quant[2]" class="form-control input-number itemcount" readonly="true" value="<?php echo $item['qty']; $totalcartCount+=$item['qty']; ?>" min="1" max="100">
                              <span class="input-group-btn">
                                  <button type="button" class="btn btn-success btn-number addItem" data-type="plus" data-field="quant[2]">
                                      <span class="glyphicon glyphicon-plus"></span>
                                  </button>
                              </span>
                            </div>
                          </div>
                        </strong>
                      </td>
                      <td class="border-0 align-middle"><a href="#" class="text-dark deleteItem" data-delete="item-line{{$itemId}}" data-type="item" data-itemId="{{$itemId}}"><i class="fa fa-trash"></i></a></td>
                    </tr>
                   
                   <?php
                    // print_r($item);                    
                    }
                  }
                } 
                ?>
                </tbody>
              </table>
            </div>
            <!-- End -->
          </div>

          <!-- <div class="row py-5 p-4 bg-white rounded shadow-sm"> -->
            <div class="col-lg-6">
             <!--  <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
              <div class="p-4">
                <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
                <div class="input-group mb-4 border rounded-pill p-2">
                  <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
                  <div class="input-group-append border-0">
                    <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
                  </div>
                </div>
              </div> -->
              <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Additional Instructions</div>
              <div class="p-4">
                <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
                <textarea name="" cols="30" rows="2" maxlength="200" class="form-control" id="instructions" name="instructions"></textarea>
              </div>
            </div>



            <?php 
			if(isset($detailsCookie) && isset($detailsCookie[$url]))
			{

			if($detailsCookie[$url]['table_id']=='0')
				{
	//				print_r($cartCookie);
			?>


		 		<div class="delivery_options">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Delivery Option</div>
        
        @if($find_resto->take_away==1)
        	<div class="p-4">
						<div class="custom-control custom-radio">
						  <input type="radio" class="custom-control-input" id="takeaway" name="delivery_option" <?php if($detailsCookie[$url]["dt"]=='ta') echo 'checked'; ?>  value="takeaway">
						  <label class="custom-control-label" for="takeaway">Take Away</label>
						</div>
        	</div>
        
        @endif
        @if($find_resto->home_delivery==1)
  				<div class="p-4">
  					<div class="custom-control custom-radio">
  					  <input type="radio" class="custom-control-input" id="homedelivery" name="delivery_option" <?php if($detailsCookie[$url]["dt"]=='hd') echo 'checked'; ?>  value="homedelivery">
  					  <label class="custom-control-label" for="homedelivery">Home Delivery</label>
  					</div>			
  				</div>
        @endif
					<div class="errors2"></div>
          <div class="errors3"></div>
        </div>

			<?php		

				}
			}
			
			?>


            <div class="col-lg-6 personal_details">
              <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Personal Details</div>
              <div class="p-4">
                <div class="input-group ">
                  <label for="fullname">Customer Name: </label>
                  <input id="fullname" type="text" placeholder="Full Name" class="form-control border-0" <?php if(isset($detailsCookie[$url]['fullname'])) echo 'value="'.$detailsCookie[$url]['fullname'].'"'; ?>   />
                </div>
                <div class="errors"></div>
              </div>


			<?php 
			if(isset($detailsCookie) && isset($detailsCookie[$url]))
			{

			if($detailsCookie[$url]['table_id']=='0')
				{
	//				print_r($cartCookie);
			?>
				<div class="p-4" style="display: block;">
	                <div class="input-group ">
						<label for="address">Delivery Address:</label>
						<textarea id="address" class="form-control"></textarea>
						<!-- <textarea id="address" style="visibility: hidden;" class="form-control">Dine In</textarea> -->
	                </div>
	                <div class="errors1"></div>
	          	</div>
			<?php		

				}
				else
				{	
				?>
      		
        <input type="hidden" id="address" class="form-control" name="address" value="In Store"/>
				<div class="p-4" style="display: none;">
                	<div class="input-group ">
                 		<label for="address">Delivery Address:</label>
                  <!-- <textarea id="address" class="form-control"></textarea> -->
                  <!-- <textarea id="address" style="visibility: hidden;" class="form-control">Dine In</textarea> -->
                	</div>
                	<div class="errors1"></div>
        </div>
				<?php
				}
			}
			
			?>




              

<!--               <div class="p-4">
                <div class="input-group ">
                  <label for="fullname">Coupon Code</label>
                  <input id="coupon_code" name="coupon_code" type="text" placeholder="Apply here" class="form-control border-0"/>               
                </div>
                <div class="coupan_error"></div>
              </div>
              <div class="p-4">
               <button class="btn btn-success" id="coupon_btn">Apply</button>
              </div>

-->

<!--               <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions for seller</div>
              <div class="p-4">
                <p class="font-italic mb-4">If you have some information for the seller you can leave them in the box below</p>
                <textarea name="" cols="30" rows="2" class="form-control"></textarea>
              </div> -->
            </div>



            <div class="col-lg-6">
              <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
              <div class="p-4">
                <!-- <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p> -->
                <ul class="list-unstyled mb-4">
                  <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong><span><?php echo $ruppeeSign;?></span><span class="subtotal"><?php echo $subTotal;?></span></strong></li>
                  <?php 
                  $taxAmt=0;
                  $totalTax=0;
                  if($find_resto->gst)
                    {
                      

                      if(count($taxes)>0){                      
                        foreach($taxes as $tax)
                        {
                          $taxAmt= (($subTotal*$tax->tax_value)/100);
                          $totalTax+=$taxAmt; 
                          echo '<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">'.$tax->tax_name.'  ('.$tax->tax_value.'%)</strong><strong><span>'.$ruppeeSign.'</span><span class="tax" data-rate="'.$tax->tax_value.'">'.$taxAmt.'</span></strong></li>';
                        }
                      }
                      else
                      {
                        echo '<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax (Inclusive in price)</strong><strong><span>'.$ruppeeSign.'</span><span class="tax" data-rate="0">'.$taxAmt.'</span></strong></li>';
                      }
                    } 
                  else 
                    {
                      echo '<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax (Inclusive in price)</strong><strong><span>'.$ruppeeSign.'</span><span class="tax" data-rate="0">'.$taxAmt.'</span></strong></li>';
                    }

                  
                  ?>

                   <li style="display:none!important;" class="d-flex justify-content-between py-3 border-bottom discount"><strong class="text-muted">Discount Applied</strong>
                    <h5 class="font-weight-bold"><span><?php echo $ruppeeSign;?></span><span class="discount_total"></span></h5>
                  </li>  
                  <!-- <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>$10.00</strong></li> -->
                  <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                    <h5 class="font-weight-bold"><span><?php echo $ruppeeSign;?></span><span class="finaltotal"><?php echo $total=$subTotal+$totalTax;?></span></h5>
                    <input type="hidden" id="hidden_main_amt" value="<?php echo $total=$subTotal+$totalTax;?>">
                  </li>
                <!-- </ul><button class="btn btn-dark rounded-pill py-2 btn-block" data-toggle="modal"   onclick="javascript:validate_pd();" data-target="#mobileOtpDialog">Place Order</button> -->
                </ul>
                <!-- <button class="btn btn-dark rounded-pill py-2 btn-block" onclick="javascript:validate_pd();">Place Order</button> -->
                <button class="btn btn-dark rounded-pill py-2 btn-block" id="place_order">Place Order</button>
              </div>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
<!-- cart html end -->
  <footer class="footer-section"> 
<?php if($find_resto->is_cart_active) { ?>
    <div><a href="<?php echo str_replace('cart','',url()->current()); ?>"><i class="fa fa-home" aria-hidden="true"></i></a></div>
    <div><a href="#" class="explore-btn" data-toggle="modal"  data-target="#feedbackDialog"><i class="fa fa-comment-alt" aria-hidden="true"></i></a></div>
    <!-- <div><a href="#" id="detailsorder-details" data-toggle="modal" data-target="#orderDetails"><i class="fa fa-user" aria-hidden="true"></i></a></div> -->
    <div class="cart-icon"><a href="<?php echo url()->current(); ?>/"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>{{$totalcartCount}}</span></a></div>
<?php 
}
else
{ 
?>  
    <div><a href="#" class="explore-btn" data-toggle="modal"  data-target="#feedbackDialog"><i class="fa fa-comments" aria-hidden="true"></i></a></div>
<?php } ?>
  </footer>

<!--- popup mobile vefication start -->
  <div id="mobileOtpDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">       
        <div class="limiter" style="display:block;">
          <div class="wrap-login100">
              <form class="login100-form validate-form" id="mobileOtp" enctype="multipart/form-data">
                  <span class="login100-form-logo">
                      <img src="{{URL::asset('public/assets/images/favicon.png')}}">
                  </span>

                  <span class="login100-form-title p-b-34 p-t-27">
                      Sign In
                  </span>
                  <div class="generate_otp">
                      <div class="wrap-input100 validate-input" data-validate = "Enter username">
                          <!-- <input class="input100" type="tel" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" placeholder="e.g. +1 702 123 4567"> -->
<?php if($currency_code==="inr")
{
    echo '<input class="input100" type="tel" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" placeholder="Enter Mobile Number">';
}
else
{
    echo '<input class="input100" type="tel" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" placeholder="e.g. +1 702 123 4567">';
}
?>
                         <input class="input100" type="hidden" name="validate_mobile_no" id="validate_mobile_no" >
                         <span class="focus-input100"><i class="fa fa-mobile-alt" aria-hidden="true"></i></span>
                      </div> 
                      <span id="mobile_validation"></span>
                      <div class="container-login100-form-btn">
                          <button class="login100-form-btn" onclick="javascript:generate_otp();">
                              Generate OTP
                          </button>
                      </div>
                  </div>
                  <div class="verify_otp">
                      <div class="wrap-input100 validate-input otpbox" data-validate="Enter password">
                          <input class="input100" type="text" maxlength="5" name="entered_otp" id="entered_otp" placeholder="OTP">
                          <span class="focus-input100"><i class="fa fa-key" aria-hidden="true"></i></span>                        
                      </div>
                      <a id="resent_otp" class="" href="#" data-count="0">Resend Otp</a>
                      <div class="container-login100-form-btn">
                          <button class="login100-form-btn close_button" onclick="javascript:validate_otp();">
                              Submit
                          </button>
                      </div>
                  </div>
                  <div id="divOuter">
                      <div id="divInner">
                      </div>
                  </div>                    

              </form>
          </div>
        </div>
        <div class="choose_dt">
<?php 
      if(isset($detailsCookie) && isset($detailsCookie[$url]))
      {

      if($detailsCookie[$url]['table_id']=='0' && $detailsCookie[$url]['dt']!='')
        {
  //        print_r($cartCookie);
      ?>

        @if($find_resto->home_delivery==1 && $detailsCookie[$url]['dt']=='hd')
        <div class=" rounded-pill px-4 py-3 text-uppercase font-weight-bold">Delivery Address</div>
        <div class="col-lg-6">
<!--           <div class="icon-box choose_delivery" data-id="hd">
            <div class="icon-outline rd">
              <img src="{{URL::asset('public/assets/user/images/delivery1.jpg')}}"  title="Home Delivery" alt="Home Delivery">
            </div>
            <div class="icon-text">Home Delivery</div>
          </div>
 -->
          <form class="border border-light p-5" name="add_delivery_address" id="add_delivery_address" action="#!">

              <p class="h4 mb-4">Please fill the delivery address.</p>
              <input type="text" id="full_name" name="full_name" required="required" class="form-control mb-4" placeholder="Full Name*">
              <input type="text" id="street_address_1" required="required"  name="street_address_1" class="form-control mb-4" placeholder="Address Line 1*">
              <input type="text" id="street_address_2" name="street_address_2" class="form-control mb-4" placeholder="Address Line 2*">
              <input type="text" id="area" name="area" required="required"  class="form-control mb-4" value="{{$detailsCookie[$url]['an']}}" placeholder="Area" readonly="readonly">
              <input type="text" id="city" name="city" required="required"  class="form-control mb-4" value="{{$detailsCookie[$url]['cn']}}" placeholder="City" readonly="readonly">
              <!-- <input type="text" id="state" name="state" required="required"  class="form-control mb-4" placeholder="State / Province / Region"> -->
<!--               <input type="text" id="zip" name="zip" required="required"  class="form-control mb-4" placeholder="Pin / Zip Code">
 -->
              <button class="btn btn-info btn-block" type="submit">Place Order</button>
          </form>


        </div>
        @endif
        
        @if($find_resto->take_away==1 && $detailsCookie[$url]['dt']=='ta')
        <div class=" rounded-pill px-4 py-3 text-uppercase font-weight-bold">Pick Up Date &amp; Time</div>

          <div class="col-lg-12">
            <form class="text-center border border-light p-5" name="add_new_name" id="add_new_name" action="#!">
                        <div class="form-group">
                            <label for="name">Select Date &amp; Time<span class="color-required">*</span></label>
  <?php 
  if($currTime>'19:00')
  {
    // print_r($range_tomorrow);
        // print_r($range_day_after);
  }
  ?>
                            <select class="form-control" name="select_date_time" id="select_date_time" required="required">
                                <option value="">Choose Time</option>
                                @foreach($range_date_1 as $value)
                                <option value="{{$date_1}},{{$value}}">{{$date_1_dd}}, {{$value}}</option>
                                @endforeach
                                @foreach($range_date_2 as $value)
                                <option value="{{$date_2}},{{$value}}">{{$date_2_dd}}, {{$value}}</option>
                                @endforeach
                            </select>
                        </div>

              <label for="name">Customer Name<span class="color-required">*</span></label>
              <input type="text" id="customer_name" name="first_name" class="form-control mb-4" required="required" data-dining="Take Away" placeholder="Full Name" <?php if(isset($detailsCookie[$url]['fullname'])) echo 'value="'.$detailsCookie[$url]['fullname'].'"'; ?>>
              <button class="btn-dark rounded-pill py-2 btn btn-block" type="submit">Place Order</button>
            </form>
          </div>
        </div>
        @endif
      <?php   

        }
      }
      
      ?>

        </div>

<?php 
      if(isset($detailsCookie) && isset($detailsCookie[$url]))
      {

      if($detailsCookie[$url]['table_id']=='0')
        {
?>        
        <div class="choose_name">
          <div class=" rounded-pill px-4 py-3 text-uppercase font-weight-bold">Customer Name</div>
          <form class="text-center border border-light p-5" name="add_new_name" id="add_new_name" action="#!">
            <input type="text" id="customer_name" name="first_name" class="form-control mb-4" required="required" data-dining="Take Away" placeholder="Full Name">
            <button class="btn-dark rounded-pill py-2 btn btn-block" type="submit">Place Order</button>
          </form>
        </div>
        <div class="choose_address">
          <div class=" rounded-pill px-4 py-3 text-uppercase font-weight-bold">Choose Address</div>
            
          <form class="border border-light p-5" name="create_hd_order" id="create_hd_order" action="#!">
            <div class="previous_addresses"></div>
            <a class="add_new_address" href="#">Add new address</a>
            <button class="btn-dark rounded-pill py-2 btn btn-block" type="submit">Place Order</button>
          </form>


          <form class="border border-light p-5" name="add_new_address" id="add_new_address" action="#!">

              <p class="h4 mb-4">Please fill the below details to add a new address.</p>
              <input type="text" id="full_name" name="full_name" required="required" class="form-control mb-4" placeholder="Full Name">
              <input type="text" id="street_address_1" required="required"  name="street_address_1" class="form-control mb-4" placeholder="Address Line 1">
              <input type="text" id="street_address_2" name="street_address_2" class="form-control mb-4" placeholder="Address Line 2">
              <input type="text" id="city" name="city" required="required"  class="form-control mb-4" placeholder="City / Town">
              <input type="text" id="state" name="state" required="required"  class="form-control mb-4" placeholder="State / Province / Region">
              <input type="text" id="zip" name="zip" required="required"  class="form-control mb-4" placeholder="Pin / Zip Code">
              <button class="btn btn-info btn-block" type="submit">Add Address</button>
              <a class="cn_new_address center-block text-center">Cancel</a>
          </form>

        </div>
  <?php 
        }
      } 
  ?>
        <span id="success" style="display:block; text-align:center;"></span>
        <button id="clsOtpModal" style="display: none;" class="right" data-dismiss="modal">Close</button>
      </div>
    </div>    
<!--     <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <span class="error"></span>
        <div class="modal-body">
          <form id="mobileOtp" enctype="multipart/form-data">
            <div class="generate_otp">
              <div class="form-group">
                <label for="mobile_for_otp" class="control-label">Mobile:</label>
                <input type="number" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" class="form-control" placeholder="Enter mobile number to receive otp" ><span id="mobile_validation"></span>
              </div>
              <div class="form-group form_buttons">                               
                <button type="button" class="btn btn-success" onclick="javascript:generate_otp();" style="margin-right: 10px;">Generate OTP</button>
              </div>                                   
            </div>
            <div class="verify_otp">
              <div class="form-group">
                <label for="recipient-name" class="control-label">Enter OTP:</label>
                <input type="number" name="entered_otp" id="entered_otp" class="form-control" placeholder="Enter otp received on mobile">
              </div>
              <div class="form-group form_buttons">                               
                <button type="button" class="btn btn-info close_button" onclick="javascript:validate_otp();" style="margin-right: 10px;">Submit</button>
                <a id="resent_otp" class="" href="#" data-count="0">Resend Otp</a>
              </div>                                   
            </div>                                   
          </form>
        </div>
        <span id="success" style="display:block; text-align:center;"></span>
        <button id="clsOtpModal" style="display: none;" class="right" data-dismiss="modal">Close</button>
      </div>
    </div> -->
  </div>
<!--- popup mobile vefication end-->

  <!--- <dialog id="dialog" class="dialog"> -->
  <div id="feedbackDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <span class="error"></span>
        <div class="modal-body">
          <!-- <form id="feedback" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" name="res_id" id="res_id" value="{{$find_resto->id}}">
              <label for="recipient-name" class="control-label">Restaurant Name:</label>
              <input type="text" name="restaurant_name" id="restaurant_name" readonly value="{{$find_resto->name}}" class="form-control">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Name:</label>
              <input type="text" name="name" id="name" required class="form-control" id="">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Email:</label>
              <input type="email" id="email" name="email" required class="form-control" id="recipient_name">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Mobile:</label>
              <input type="text" name="mobile" id="mobile" class="form-control" id="recipient_name">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">File:</label>
              <input type="file" name="file_img" id="file_img" class="form-control" id="recipient_name">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Feedback:</label>
              <textarea type="text"  id="feedback" name="feedback" class="form-control" required></textarea>
            </div>
            <input type="hidden" name="rating" id="rating">
            <div class="form-group">
              <section class='rating-widget'>
                <div class='rating-stars text-center' style="margin-right: 0px;
                margin-top: 0px;">
                  <span>Give Rating</span>
                  <ul id='stars'>
                    <li class='star' title='Poor' data-value='1'>
                      <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='Fair' data-value='2'>
                      <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='Good' data-value='3'>
                      <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='Excellent' data-value='4'>
                      <i class='fa fa-star fa-fw'></i>
                    </li>
                    <li class='star' title='WOW!!!' data-value='5'>
                      <i class='fa fa-star fa-fw'></i>
                    </li>
                  </ul>                   
                </div>
              </section>
            </div>

            <div class="form-group form_buttons">                               
              <button type="button" class="btn btn-success" onclick="javascript:Feedback('feedback');" style="margin-right: 10px;">Submit</button>
              <button id="close-modal" class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
            </div>                                   
          </form> -->
        <!---feedback-->

          <form id="feedback" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="restaurant_id" value="{{$find_resto->id}}">
            <div class="form-group">
              <label for="recipient-name" class="control-label">Name:</label>
              <input type="text" name="name" id="name" required class="form-control" id="recipient_name" value="<?php if(isset($detailsCookie) && isset($detailsCookie[$url]['fullname'])) { echo $detailsCookie[$url]['fullname']; }?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Email:</label>
              <input type="email" id="email" name="email" required class="form-control" id="recipient_email">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Mobile:</label>
              <input type="text" name="mobile" id="mobile" class="form-control" id="recipient_mobile" value="<?php if(isset($detailsCookie) && isset($detailsCookie[$url]['mobile'])) { echo $detailsCookie[$url]['mobile']; }?>">
              <input type="hidden" name="orderid" id="recipient_orderid" value="0">
            </div>




<?php 
// print_r($questions);
$q_count=0;
$i = 1;
$c=1;
$time=0;
$q_type="";
$count = count($questions);
foreach($questions as $question){

// $time=$time+$question['time'];

    $questionType =QuestionType($question['question_type_id']);
    $q_type= $questionType;

    if($count==1){
    $num = "q-last";
    }
    else{
    $num = " ";
    }

    if($i == 1){
    $active = "q-active";
    $number = "q-first";
    }
    elseif($i == $count){
    $active = "";
    $number = "q-last";
    }
    else{
    $active = "";
    $number = "";
    }

    if($question['question_type_id']==1)
    {
    ?>
    <div class="form-group">
        <label for="question_id-{{$question['id']}}" class="control-label">{{$question['question']}}</label>
        <input type="hidden" name="question_id-{{$question['id']}}" value="{{$question['id']}}">
        <input type="hidden" name="question_type_id-{{$question['id']}}" value="{{$question['question_type_id']}}">
        <div class="feedback-options">
            <?php  foreach($question['options'] as $val){   ?>
                <div class="radio radio-success form-check-inline">
                    <input type="radio" id="answer-{{$val['id']}}" value="{{$val['id']}}" name="answer_id-{{$question['id']}}">
                    <label for="answer-{{$val['id']}}">{!! html_entity_decode(strip_tags($val['options'])) !!}</label>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    } 
    else if($question['question_type_id']==2)
    {
    ?>
    <div class="form-group">
        <label for="question_id-{{$question['id']}}" class="control-label">{{$question['question']}}</label>
        <input type="hidden" name="question_id-{{$question['id']}}" value="{{$question['id']}}">
        <input type="hidden" name="question_type_id-{{$question['id']}}" value="{{$question['question_type_id']}}">
        <div class="feedback-options">
            <?php  foreach($question['options'] as $val){   ?>
                <div class="checkbox checkbox-success form-check-inline">
                    <input type="checkbox" id="answer-{{$val['id']}}" value="{{$val['id']}}" name="answer_id-{{$question['id']}}">
                    <label for="answer-{{$val['id']}}">{!! html_entity_decode(strip_tags($val['options'])) !!}</label>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    }
    else if($question['question_type_id']==3)
    {
    ?>
    <div class="form-group">
      <label for="question_id-{{$question['id']}}" class="control-label">{{$question['question']}}</label>
      <input type="hidden" name="question_id-{{$question['id']}}" value="{{$question['id']}}">
      <input type="hidden" name="question_type_id-{{$question['id']}}" value="{{$question['question_type_id']}}">
      <textarea type="text" id="answer-{{$val['id']}}" name="answer_id-{{$question['id']}}" class="form-control" required></textarea>
    </div>

    <?php
    } 
    ?>



<?php $i++; $c++; 
}
?>

            <input type="hidden" name="rating" id="rating">
            <div class="form-group">
              <label for="recipient-name" class="control-label">File:</label>
              <input type="file" name="file_img" id="file_img" class="" id="recipient_name">
            </div>
            <div class="form-group">
                <label for="stars_form" class="control-label">Give Rating:</label>
                <div id="stars_form">
                  <fieldset class="stars">
                    <input type="radio" name="stars" value="5" id="star1" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star1"></label>
                    <input type="radio" name="stars" value="4" id="star2" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star2"></label>
                    <input type="radio" name="stars" value="3" id="star3" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star3"></label>
                    <input type="radio" name="stars" value="2" id="star4" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star4"></label>
                    <input type="radio" name="stars" value="1" id="star5" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star5"></label>
<!--                     <input type="radio" name="stars" id="star-reset"/>
                    <label class="reset" for="star-reset">reset</label> -->
                <!--     <figure class="face"><i></i><i></i>
                      <u>
                        <div class="cover"></div>
                      </u>
                    </figure> -->
                  </fieldset>
                </div>
            </div>

            <div class="form-group form_buttons">                               
              <button type="button" class="btn btn-success" id="end-survey" onclick="javascript:Feedback('feedback');" style="margin-right: 10px;">Submit</button>
              <button id="close-modal " class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
            </div>                                   
        </form>
        <!---feedback-->

        </div>
        <span id="success" style="display:block; text-align:center;"></span>    
      </div>
    </div>


</div>
<!-- </dialog> -->
  
 


  <form action="{{url('payment')}}" method="get" name="myForm" style="display:none;">
  {{ csrf_field() }}
   <!-- <input type="text" id="mob" name="mob" > -->
   <input type="text" id="amt" name="amt">
   <input type="text" id="idOrder" name="idOrder">
   </form>

<!-- </dialog> -->


<div id="orderDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
       
        <div class="modal-body" id="">

        <div class="col-lg-12 p-5  mb-5">
        <button id="" style="float:right;" class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
            <h1 class="display-4">Order Details</h1>
           
            <!-- Shopping cart table -->
            <div id="details-order">
            
            
            
            </div>
           
        </div>

        </div>
      </div>
    </div>
  </div>


  <script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'></script>
  <script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'></script>
  <script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>
<?php if($currency_code!=="inr")
{
?>
<script src="{{URL::asset('public/assets/js/intlTelInput.js')}}"></script>
<?php 
}
?>
   
<script>
var uqid='<?php echo $url;?>';
// alert(uqid);
var resID=document.getElementById('restro_id').value;
var tabID=document.getElementById('table_id').value;
var pas;

$(document).ready(function() {

<?php if($currency_code!=="inr")
{
    echo '  $("#mobile_for_otp").intlTelInput();';
}
?>

  var owl = $('.owl-carousel');
  owl.owlCarousel({
    margin: 10,
    nav: true,
    loop: true,
    dots: false,
    nav: false,
    autoplay:true,
    autoplayTimeout:3000,
    // autoplayHoverPause:true

    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 1
      },
      1000: {
        items: 1
      }
    }
  })
})



$( function() {


  $('#details-order').on( 'click', '.feedback_order', function(){

    var ord_id = $(this).attr('data-orderId');
    $('#orderid').val(ord_id);
    $('#orderDetails').modal('hide');
//$("#feedbackDialog").load(location.href + " #feedbackDialog");
$('#feedbackDialog').modal('show');


});

  $('.subCategory').hide();

  $('.sub').click(function(){
    var subFilter = $(this).attr('data-filter');
   // $('.sub-cat').fadeIn().delay(1000).fadeOut();
    $('.cats').removeClass('activated');
    $(subFilter).addClass('activated');

    //$('.activated').css('display','block');
  //  var t ='.subCategory';
   // $('.subCategory'+ subFilter +'').fadeIn().next().delay(10000).fadeOut(); 
   //  $('.subCategory').removeClass('visible');
   if($('.subCategory'+ subFilter +'').hasClass('visible')){
      $('.subCategory'+ subFilter +'').hide();
      $('.subCategory'+ subFilter +'').removeClass('visible');
   }
   else{
    $('.subCategory').hide();
    $('.subCategory').removeClass('visible');
    $('.subCategory'+ subFilter +'').addClass('visible');
    $('.subCategory'+ subFilter +'').show();
   
   }
  });


  var $grid = $('.grid').isotope({
    itemSelector: 'article'
  });

  // filter buttons
  $('.filters-button-group').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter');
    var itc = 1;
    var itemClass="first-box";
    $("article"+filterValue).each(function(){
      $(this).children().removeClass('second-box');
      $(this).children().removeClass('first-box');
      $(this).children().addClass(itemClass);
      itc++;
      if(itc%4==2 || itc%4==3)
      {
        itemClass="second-box";
      }
      if(itc%4==1 || itc%4==0)
      {
        itemClass="first-box";
      }
    });

    $grid.isotope({ filter: filterValue });
  });
  
  //for sub category///
  $('.filters-button-group1').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter1');
    var itc = 1;
    var itemClass="first-box";
    $("article"+filterValue).each(function(){
      $(this).children().removeClass('second-box');
      $(this).children().removeClass('first-box');
      $(this).children().addClass(itemClass);
      itc++;
      if(itc%4==2 || itc%4==3)
      {
        itemClass="second-box";
      }
      if(itc%4==1 || itc%4==0)
      {
        itemClass="first-box";
      }
    });

    $grid.isotope({ filter: filterValue });
  });


  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });

  //////for sub category////
  $('.button-group1').each( function( i, buttonGroup1 ) {
    var $buttonGroup1 = $( buttonGroup1 );
    $buttonGroup1.on( 'click', 'button', function() {
      $buttonGroup1.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });
});

// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    timeout = setTimeout( delayed, threshold || 100 );
  }
}

$(window).bind("load", function() {
  $('#all').click();
});


/*************slider***********/




/*************Popup***********/

//Function To Display Popup

$(document).ready(function(){


 
  
$('.box-category').click(function(){
  var b =  $(this).attr('data-class');
  $('.'+b+'').css("display","block")
  //document.getElementById(b).style.display = "block";
});

$('.close').click(function(){
  var b =  $(this).attr('data-class');
  
  $('.'+b+'').css("display","none")
  //document.getElementById(b).style.display = "block";
});

$('.cartStyle').css('margin-bottom',($('.footer-section').outerHeight() +60));
//$('.buttton').css('flex-direction','unset');

});
function div_show() {
   
  
  }
  //Function to Hide Popup
  function div_hide(){
  document.getElementById('pop').style.display = "none";
  }

  $(document).ready(function(){
       // console.log($(this).attr('data-class'));
       $("#orderPlace").click(function(){
          alert(1);
       });
     
     

       $("#coupon_btn").click(function(){
       
          var code =$("#coupon_code").val();

         if(code == ""){
          var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">x</button>' +
                    '<strong>Coupon code is required</strong>' +
                    '</div>';
                    $('.coupan_error').html(error1);
                     return false;
         }

   var send_data=new FormData();
    send_data.append('res_id',resID);
    send_data.append('coupan_code',code);
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    type: "POST",
    url: "{{url('/coupan-apply')}}",
    data:send_data,
    async: false,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if(data.status=='success'){
          if(data.data['type'] == 'fixed'){
            var value =parseFloat(data.data['value']);
            var total_amt=parseFloat($('#hidden_main_amt').val());
            var final_amt = total_amt - value;
            $('.discount').css('display','block'); 
            $('.discount_total').text(value);
            $('.finaltotal').text(final_amt);
            console.log(final_amt);
            $('#coupon_code').val('');
            var error1 = '<div class="alert alert-success">' +
                    '<button type="button" class="close" data-dismiss="alert">x</button>' +
                    '<strong>'+data.msg+'</strong>'+
                    '</div>';
                    $('.coupan_error').html(error1);

          }else{
            var value =parseFloat(data.data['value']);
            var total_amt=parseFloat($('#hidden_main_amt').val());
            var percent_amt = parseFloat((total_amt * value) / 100);
            var final_amt = total_amt - percent_amt;
            $('.discount').css('display','block'); 
            $('.discount_total').text(percent_amt);
            $('.finaltotal').text(final_amt);
            console.log(final_amt);
            $('#coupon_code').val('');
            var error1 = '<div class="alert alert-success">' +
                    '<button type="button" class="close" data-dismiss="alert">x</button>' +
                    '<strong>'+data.msg+'</strong>'+
                    '</div>';
                    $('.coupan_error').html(error1);
                    setTimeout(function(){  $('.coupan_error').html(''); }, 3000);      
          }
      }else{
        var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">x</button>' +
                    '<strong>'+data.msg+'</strong>'+
                    '</div>';
                    $('.coupan_error').html(error1);
                    setTimeout(function(){  $('.coupan_error').html(''); }, 3000); 
      }
    },
    cache: false,
    enctype: 'multipart/form-data',
    contentType: false,
    processData: false
  });

       });




    })


</script>
<script>
var dailog = document.getElementById("dialog"); 
function openModal() { 
      dailog.showModal();
  
} 

function closeModal() { 
  
    dailog.close(); 

} 


function Feedback(form) {
      var name =$('#name').val();
      var email =$('#email').val();
      var mobile =$('#mobile').val();
      var feedback =$('textarea#feedback').val();

  if(name ==""){
    var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert"></button>' +
                    '<strong>Name is required</strong>' +
                    '</div>';
                $('.error').html(error1);
    return false;
  } 

  // if(email ==""){
  //   var error1 = '<div class="alert alert-danger">' +
  //                   '<button type="button" class="close" data-dismiss="alert"></button>' +
  //                   '<strong>Email is required</strong>' +
  //                   '</div>';
  //               $('.error').html(error1);
  //   return false;
  // } 
  // if(mobile ==""){
  //   var error1 = '<div class="alert alert-danger">' +
  //                   '<button type="button" class="close" data-dismiss="alert"></button>' +
  //                   '<strong>Mobile No. is required</strong>' +
  //                   '</div>';
  //               $('.error').html(error1);
  //   return false;
  // } 
  // if(feedback ==""){
  //   var error1 = '<div class="alert alert-danger">' +
  //                   '<button type="button" class="close" data-dismiss="alert"></button>' +
  //                   '<strong>Feedback is required</strong>' +
  //                   '</div>';
  //               $('.error').html(error1);
  //   return false;
  // } 

      var send_data = new FormData($('#feedback')[0]);
     //  send_data.append('restaurant_name',$("#restaurant_name").val());
      // send_data.append('name',$("#name").val());
       var res_name =$('#restaurant_name').val();
       var rating =$('#rating').val();
       var id=$('#res_id').val();
       var file =$('#file_img')[0].files[0];
    
    
      $.ajax({
             headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
            type: "POST",
            url: "{{url('/feedback')}}",           
          //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
           data:send_data,
            async: false,
            dataType: 'json',
            success: function(data){
              console.log(data);
             if(data.status == 'success'){
              $('#success').text("Thanks! For Your Feedback"); 
             setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); }, 1000);
             setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); $('#feedbackDialog').modal('hide'); location.reload();  }, 3000);
             }
              
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });

}

</script>
<script>

$(document).ready(function(){

  $('#place_order').click(function(e){
    var cart = JSON.parse(cm_readCookie(uqid));
    console.log(cart);
    if(cart===null)
    {
    }
    else if(Object.entries(cart).length===0)
    {
    }
    else{
      validate_pd();
    }


    e.stopImmediatePropagation();
  });
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      $('#rating').val(ratingValue);
    var msg = "";
    if (ratingValue > 1) {
        msg = "";
    }
    else {
        msg = "";
    }
    responseMessage(msg);
    
  });
  /*
  var wd= $(window).width();
  $('.button.sub').each(function(){
  alert(wd);
    $(this).css('width', (wd*22/100)+'px !important');
  } );
  */  
  $('.pro-button').click(function() {
    $('.addbtnoverlay').hide();
    $(this).parent().children('.addbtnoverlay').show();
    $(this).prev().prev().hide();
    return false;

  });
  $('.addCardOverlay').click(function() {
    return false;
  });

  

    $('.addbtnoverlay .cls').click(function() {
        $(this).parent().hide();
        var ct = $(this).parent().prev().text();
        if(ct=='0' || ct==''){
          $(this).parent().prev().hide();
        }
        else{
          $(this).parent().prev().show();
        }
        return false;
    });

    $('.addit').click(function(){
        var itemDetail = $(this).parent().parent();
        var itemId= itemDetail.data('itemid');
        var itemName= itemDetail.data('itemname');
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        var selectOption = itemDetail.find('select');
        //alert(itemDetail.find('select').val());
        var varientId = itemDetail.find('select').val();
        var name = $('option:selected', selectOption).attr('name');
        var price = $('option:selected', selectOption).attr('price');
//        alert(name);
  //      alert(price);
        var quantity = 1;
        addItemVarient(itemId,itemName,itemPrice,itemImage,varientId,name,price,quantity);
    
        var itemQty= $(this).parent().parent().parent().prev().text();
        if(itemQty==''){
            itemQty=0;    
        }
        itemQty=parseInt(itemQty)+1;
        $(this).parent().parent().parent().prev().text(itemQty);
    });

  $('.deleteItem').click(function(e){
    var rmCls=$(this).data('delete');
    var itype=$(this).data('type');
    var cart = JSON.parse(cm_readCookie(uqid));   
    if(itype=='item'){
      var itemId=$(this).data('itemid');
      if(cart===null)
      {
      }
      else{
        delete cart[itemId];
      }
      cm_createCookie(uqid,JSON.stringify(cart),30);
    }

    if(itype=='varient'){
      var itemId=$(this).data('itemid');
      var varientId=$(this).data('varientid');      
      if(cart===null)
      {
      }
      else{
        delete cart[itemId]['varientId'][varientId];
        var variArr=cart[itemId]['varientId'];
        if(Object.keys(variArr).length === 0)
        {          
          delete cart[itemId];
        }
      }
      cm_createCookie(uqid,JSON.stringify(cart),30);
    }

    $('.'+rmCls).remove();
    calcTotal();

    e.preventDefault();
  });

  $('.addItemVarient').click(function(){
    var itemQty= $(this).parent().prev().val();
    // alert(itemQty);
    var itemDetail = $(this).parent().parent();
    var itemId= itemDetail.data('itemid');
    var varientId= itemDetail.data('varientid');
    var itemName= itemDetail.data('itemname');
    var itemPrice= itemDetail.data('price');
    addItemVarientQty(itemId,varientId);
    itemQty=parseInt(itemQty)+1;
    var itemQty1 = pad_with_zeroes(itemQty, 1);
    // alert(itemQty1);
    $(this).parent().prev().val(itemQty1);
    calcTotal();

  });

  $('.removeItemVarient').click(function(){
    var itemQty= $(this).parent().next().val();

    var itemDetail = $(this).parent().parent();
    var itemId= itemDetail.data('itemid');
    var varientId= itemDetail.data('varientid');
    var itemName= itemDetail.data('itemname');
    var itemPrice= itemDetail.data('price');
    removeItemVarientQty(itemId,varientId)
    // alert(itemQty);
    if(parseInt(itemQty)!=0)
    {
      itemQty=parseInt(itemQty)-1;
      var itemQty1 = pad_with_zeroes(itemQty, 1)
      $(this).parent().next().val(itemQty1);
      if(itemQty1==0)
      {
        $(this).parent().parent().parent().parent().parent().parent().remove();        
      }
    }
    else{
        $(this).parent().parent().parent().parent().parent().parent().remove();        
    }

    calcTotal();
  });


  
  function addItemVarientQty(itemId,varientId)
  {
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
    }
    else
    {
      if(cart[itemId]['varientId'][varientId])
      {
        cart[itemId]['varientId'][varientId]['varientQuantity']=cart[itemId]['varientId'][varientId]['varientQuantity']+1;
//        alert('add qty in varient to cart existing item');
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
      }
      cm_createCookie(uqid,JSON.stringify(cart),30);
      console.log(cart);
    }
  }

  function removeItemVarientQty(itemId,varientId)
  {
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
    }
    else
    {
      if(cart[itemId]['varientId'][varientId])
      {
        cart[itemId]['varientId'][varientId]['varientQuantity']=cart[itemId]['varientId'][varientId]['varientQuantity']-1;
        if(cart[itemId]['varientId'][varientId]['varientQuantity']==0){
          delete cart[itemId]['varientId'][varientId];
          var variArr=cart[itemId]['varientId'];
          if(Object.keys(variArr).length === 0)
          {          
            delete cart[itemId];
          }          
        }
//        alert('remove qty in item varient');
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())-1);
      }
      cm_createCookie(uqid,JSON.stringify(cart),30);
      console.log(cart);
    }    
  }

  $('.addItem').click(function(){
    var itemQty= $(this).parent().prev().val();
    // alert(itemQty);
    var itemDetail = $(this).parent().parent();
    var itemId= itemDetail.data('itemid');
    var itemName= itemDetail.data('itemname');
    var itemPrice= itemDetail.data('price');
    var image= itemDetail.data('image');
    addItem(itemId,itemName,itemPrice,image);
    itemQty=parseInt(itemQty)+1;
    var itemQty1 = pad_with_zeroes(itemQty, 1);
    // alert(itemQty1);
    $(this).parent().prev().val(itemQty1);
    calcTotal();

  });
  $('.removeItem').click(function(){
    var itemQty= $(this).parent().next().val();

    var itemDetail = $(this).parent().parent();
    var itemId= itemDetail.data('itemid');
    var itemName= itemDetail.data('itemname');
    var itemPrice= itemDetail.data('price');
    removeItem(itemId,itemName,itemPrice)
    // alert(itemQty);
    if(parseInt(itemQty)!=0)
    {
      itemQty=parseInt(itemQty)-1;
      // alert(itemQty);
      var itemQty1 = pad_with_zeroes(itemQty, 1)
      // alert(itemQty1);
      $(this).parent().next().val(itemQty1);
      if(itemQty1==0)
      {
        $(this).parent().parent().parent().parent().parent().parent().remove();        
      }

    }
    else{
        $(this).parent().parent().parent().parent().parent().parent().remove();
    }
    calcTotal();

  });

});
/*  $(document).ready(function() {
         function disablePrev() { window.history.forward() }
         window.onload = disablePrev();
         window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
*/

//    window.onbeforeunload = function() { return "Your work will be lost."; };
function pad_with_zeroes(number, length) {

    var my_string = '' + number;
    while (my_string.length < length) {
        my_string = '0' + my_string;
    }
    return my_string;
}

function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}



//var arval =  [['Work', 9], ['Eat', 2], ['Commute', 2], ['Play Game', 2], ['Sleep', 7] ];
var cartArr={};
var arval = { 
    a:{
        item: "Product 1",
        price: 35.50,
        qty: 2
    },
    b:{
        item: "Product 2",
        price: 50,
        qty: 5
    }
};
arval['c']={
        item: "Product 3",
        price: 60,
        qty: 7
    };
//sessionStorage.setItem( "total", 120 );
//cm_createCookie('qcart',JSON.stringify(arval),10);


//sessionStorage.setItem( "qcart",JSON.stringify(arval));

//var cartValue = sessionStorage.getItem( "qcart" );
//var cartObj = JSON.parse( cartValue );

function cm_readCookie(name) 
{
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
};

function addItemVarient(itemId,itemName,itemPrice,itemImage,varientId,name,price,quantity)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                varientId:{}                         
                            }
        cartArr[itemId]['varientId'][varientId] = {
                                    varientName:name,
                                    varientPrice:price,
                                    varientQuantity:quantity
                                }
                                alert(' null cart');
        cm_createCookie(uqid,JSON.stringify(cartArr),30);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =   {
                                    item: itemName,
                                    price:itemPrice,
                                    image:itemImage,
                                    varientId:{}                        
                                }
            cart[itemId]['varientId'][varientId] = {
                                        varientName:name,
                                        varientPrice:price,
                                        varientQuantity:quantity
                                    }
            alert('add varient to cart without item');
        }
        else if(!cart[itemId]['varientId'][varientId]) {
            cart[itemId]['varientId'][varientId] = {
                                        varientName:name,
                                        varientPrice:price,
                                        varientQuantity:quantity
                                    }

            alert('add varient to cart existing item');    
        }
        else{
            // cart[itemId]['varientId'][varientId] = {
            //                             varientName:name,
            //                             varientPrice:price,
            //                             varientQuantity:quantity
            //                         }
            cart[itemId]['varientId'][varientId]['varientQuantity']=cart[itemId]['varientId'][varientId]['varientQuantity']+1;
            alert('add qty in varient to cart existing item');
        }
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        cm_createCookie(uqid,JSON.stringify(cart),30);
        console.log(cart);
    }

}

function addItem(itemId,itemName,itemPrice,itemImage)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                qty: 1
                            }
        cm_createCookie(uqid,JSON.stringify(cartArr),30);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =  {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                qty: 1
                            }
            $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);

        }
        else{
            cart[itemId]['qty']=cart[itemId]['qty']+1;
            $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        }
        cm_createCookie(uqid,JSON.stringify(cart),30);
        console.log(cart);
    }
}

function removeItem(itemId,itemName,itemPrice)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    console.log(typeof cart);
    if(cart===null)
    {
    }
    else{
        cart[itemId]['qty']=cart[itemId]['qty']-1;
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())-1);

        if(cart[itemId]['qty']==0)
        {
            delete cart[itemId];
//            delete cart[4];
        }
        cm_createCookie(uqid,JSON.stringify(cart),30);
        console.log(cart);
    }    
}

function cm_createCookie(name, value, days) 
{
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
};
function calcTotal(){
  var subtotal=0, total=0, gst=0, cartCount=0;  
  <?php if($find_resto->gst){ echo 'var taxPercent=5;'; } else { echo 'var taxPercent=0;'; } ?>
  $('.itemRow').each(function(){
    var price = $(this).find('.price').data('price');
    var qty = $(this).find('.input-number').val();
    cartCount+=parseInt(qty);
    subtotal+=price*qty;
  });

  $('.tax').each(function(){
    var rate= $(this).data('rate');
    var cur_tax=(subtotal*rate)/100;
    gst+=cur_tax;
    $(this).text(cur_tax);
  })

  total=subtotal+gst;
  gst=(subtotal*5)/100;
  $('.subtotal').text(subtotal);
  // $('.tax').text(gst);
  $('.finaltotal').text(total);
  $('.cart-icon').find('span').text(cartCount);
//  alert(total);
}


function cartUpdate(cartdata){
  var send_data=new FormData();
  send_data.append('cartdata',cartdata);

  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    type: "POST",
    url: "{{url('/cartupdate')}}",
    data:send_data,
    async: false,
    dataType: 'json',
    success: function(data){
      console.log(data);

      $('.orderid').text(data.order_id); 
      $('#idOrder').val(data.id); 
      $('.orderDate').text(getDate()); 
      $('.orderDisplay').text(data.daily_display_number);
      $('.cart-icon span').text('0');
      $('#recipient_orderid').val(data.id); 

      var f_amt =$('.finaltotal').text();
      $('#amt').val(f_amt);

       <?php  if($detailsCookie[$url]['table_id']=='0'){ ?>
         document.myForm.submit();
     <?php }else{ } ?>


    },
    cache: false,
    enctype: 'multipart/form-data',
    contentType: false,
    processData: false
  });

}

function getDate(){
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  return today = mm + '/' + dd + '/' + yyyy;
}

function mobileVerification(mobileNo){
  var send_data=new FormData();
  send_data.append('mob',mobileNo);

  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
      type: "POST",
      url: "{{url('/otp')}}",           
    //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
      data:send_data,
      async: false,
      dataType: 'json',
      success: function(data){
          console.log(data);
          $('.generate_otp').hide();
          $('.verify_otp').show();
          pas=data.otp;
          $('#validate_mobile_no').val(data.mobile_no);


      },
      cache: false,
      enctype: 'multipart/form-data',
      contentType: false,
      processData: false
  });

}
<?php 
if(isset($detailsCookie) && isset($detailsCookie[$url]))
{

if($detailsCookie[$url]['table_id']=='0')
	{
		?>

$('#takeaway').click(function(){
  	var checkAddress = $('#address');
	checkAddress.hide();
	checkAddress.val('Take Away');
});

$('#homedelivery').click(function(){
  	var checkAddress = $('#address');
	checkAddress.show();
	checkAddress.val('');
});

		<?php
	}
}
?>

function validate_pd(){
  
  var checkName =$('#fullname');
  var checkAddress = $('#address');
  var cartdetails = JSON.parse(cm_readCookie('qcart1'));
  if(cartdetails[uqid]['mobile'])
  {
    <?php 
    if(isset($detailsCookie) && isset($detailsCookie[$url]))
    {

    if($detailsCookie[$url]['table_id']=='0')
    	{
    		?>
    		var delivery_option=false;
    		var takeaway = $('#takeaway');
    		if(takeaway.is(':checked'))
    		{
    			// alert(takeaway.val())
    			checkAddress.hide();
    			// checkAddress.val('Take Away')
            if($('#select_date_time').val()!='')
            {
        			delivery_option = true;
            }
    		}				
    		var homedelivery = $('#homedelivery');
    		if(homedelivery.is(':checked'))
    		{
            if($('#address').val()!='')
            {
              delivery_option = true;
            }
    		}
    		if(!delivery_option)
    		{
    		   //  var errorText ='<div class="alert alert-danger">'+
    		  	// '<button type="button" class="close" data-dismiss="alert">×</button>'+	
    		   //  '<strong>Please select delivery option.</strong>'+
    		   //  '</div>';
    		   //  $(".errors2").html(errorText);
    		   //  takeaway.focus();

            $('#mobileOtpDialog').modal('show');
            $('.limiter').hide();
            $('.choose_dt').show();
    		    return false;
    		}			

    		<?php
    	}
    }
    ?>

  if(checkName.val() == ""){

    var errorText ='<div class="alert alert-danger">'+
  	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
    '<strong>customer name is required</strong>'+
    '</div>';
    $(".errors").html(errorText);
    checkName.focus();
    return false;
  }

  if(checkAddress.val() == ""){
    var errorText ='<div class="alert alert-danger">'+
  	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
    '<strong>address is required</strong>'+
    '</div>';
    $(".errors1").html(errorText);
    checkAddress.focus();
    return false;
  }
    var mobile=cartdetails[uqid]['mobile'];
    var cartdetails = JSON.parse(cm_readCookie('qcart1'));
    cartdetails[uqid]['fullname']= $('#fullname').val();
    cartdetails[uqid]['delivery_address']= $('#address').val();
    cartdetails[uqid]['instructions']= $('#instructions').val();
    cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
    generate_order(mobile);
  }
  else
  {
    $('#mobileOtpDialog').modal('show');
  }
  return true;
}

$('#mobileOtp').submit(function(){
  return false;
})
$('#add_new_name').submit(function(){
    
  // alert($('#customer_name').val());
  if($('#customer_name').val()!='')
  {
    $('#fullname').val($('#customer_name').val());
    $('#address').val($('#customer_name').data('dining') + ' | ' + $('#select_date_time').val());
    validate_pd();
    $('#clsOtpModal').trigger('click');

  }
  return false;
})
$('#add_delivery_address').submit(function(){
    
  // alert($('#full_name').val());
  
  if($('#full_name').val()!='')
  {
    var fn=$('#full_name').val();
    $('#fullname').val(fn);
    var sa1=$('#street_address_1').val();
    var sa2=$('#street_address_2').val();
    var an=$('#area').val();
    var cn= $('#city').val();
    $('#fullname').val($('#full_name').val());
    $('#fullname').val($('#full_name').val());
    $('#address').val(fn + ', ' + sa1+ ', ' +sa2+ ', ' +an+ ', ' +cn);
    delivery_option=true; 
    validate_pd();
    $('#clsOtpModal').trigger('click');
  }
  return false;
})

$('#create_hd_order').submit(function(){ 
  // alert($('#customer_name').val());
  if($('#fullname').val()!='' && $('#address').val()!='')
  {
    validate_pd();
    $('#clsOtpModal').trigger('click');
  }
  return false;
})

function get_address()
{
  var cartdetails = JSON.parse(cm_readCookie('qcart1'));
  var mobile = cartdetails[uqid]['mobile'];
  var send_data = new FormData();
  send_data.append('mobile_no',mobile);
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
      type: "POST",
      url: "{{url('/get-address')}}",           
    //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
      data:send_data,
      async: false,
      success: function(result){
        console.log(result); 
        if(result.status=='success')
        {
          // $('.previous_addresses').append(result.data);

          $('.previous_addresses').html('');

          $.each(result.data,function(index,val){
            // alert(val.mobile_no);
            $('.previous_addresses').append('<div class="p-4"><div class="custom-control custom-radio"><input required="required" type="radio" class="custom-control-input" id="list_address'+index+'" name="list_address"  value="'+val.id+'" data-name="'+val.full_name+'" data-street1="'+val.street_address_1+'" data-street2="'+val.street_address_2+'" data-city="'+val.city+'" data-state="'+val.state+'" data-zip="'+val.zip+'"><label class="custom-control-label" for="list_address'+index+'">'+val.full_name+'</label><label class="custom-control-label" for="list_address'+index+'">'+val.street_address_1+'</label><label class="custom-control-label" for="list_address'+index+'">'+val.street_address_2+'</label><label class="custom-control-label" for="list_address'+index+'">'+val.city+', '+val.state+', '+val.zip+'</label></div></div>');
          }) 
          $('#create_hd_order button').show();
        } 
        else
        {
          $('#create_hd_order button').hide();
        }
      },
      cache: true,
      enctype: 'multipart/form-data',
      contentType: false,
      processData: false
  });
}
$(document).on('click','input[name=list_address]',function(){
  // alert($(this).val());
  var name=$(this).data('name');
  var street1=$(this).data('street1');
  var street2=$(this).data('street2');
  var city=$(this).data('city');
  var state=$(this).data('state');
  var zip=$(this).data('zip');
  $('#fullname').val(name);
  $('#address').val(street1 +', '+street2 +', '+city +', '+state +', '+zip);
})



$('#add_new_address').submit(function(){

  var cartdetails = JSON.parse(cm_readCookie('qcart1'));
  var mobile = cartdetails[uqid]['mobile'];
  var form = $(this)[0];
  var send_data = new FormData(form);
  send_data.append('mobile_no',mobile);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/add-address')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(result){
          if(result.status=='success')
          {
            $('.previous_addresses').html('');
            $.each(result.data,function(index,val){
              // alert(val.mobile_no);
            $('.previous_addresses').append('<div class="p-4"><div class="custom-control custom-radio"><input required="required" type="radio" class="custom-control-input" id="list_address'+index+'" name="list_address"  value="'+val.id+'" data-name="'+val.full_name+'" data-street1="'+val.street_address_1+'" data-street2="'+val.street_address_2+'" data-city="'+val.city+'" data-state="'+val.state+'" data-zip="'+val.zip+'"><label class="custom-control-label" for="list_address'+index+'">'+val.full_name+'</label><label class="custom-control-label" for="list_address'+index+'">'+val.street_address_1+'</label><label class="custom-control-label" for="list_address'+index+'">'+val.street_address_2+'</label><label class="custom-control-label" for="list_address'+index+'">'+val.city+', '+val.state+', '+val.zip+'</label></div></div>');
            })
            $('#add_new_address').hide(); 
            $('#add_new_address').reset(); 
            $('#create_hd_order button').show();
        } 
        else
        {
          $('#create_hd_order button').hide();
        }


        },
        cache: true,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });

  // alert($('#customer_name').val());
  // if($('#customer_name').val()!='')
  // {
  //   $('#fullname').val($('#customer_name').val());
  //   $('#address').val('Take Away');
  //   validate_pd();
  //   $('#clsOtpModal').trigger('click');

  // }

  return false;
})






function generate_otp(){
  
/*  var checkName =$('#fullname').val();
  var checkAddress = $('#address').val();

  if(checkName == ""){

    var errorText ='<div class="alert alert-danger">'+
    '<button type="button" class="close" data-dismiss="alert">×</button>'+  
    '<strong>customer name is required</strong>'+
    '</div>';
    $(".errors").html(errorText);
    return false;
  }

  if(checkAddress == ""){
    var errorText ='<div class="alert alert-danger">'+
    '<button type="button" class="close" data-dismiss="alert">×</button>'+  
    '<strong>address is required</strong>'+
    '</div>';
    $(".errors1").html(errorText);
    return false;
  }
*/
  //alert($('#mobile_for_otp').val());
//  return false;
  if(check())
  {

    <?php if($currency_code!=="inr")
    {
    ?>
    var mobNum=$('#mobile_for_otp').val();
    <?php
    }
    else
    {
    ?>
    var mobNum='+91 ' + $('#mobile_for_otp').val();
    <?php
    }
    ?>

    mobileVerification(mobNum);
  }
  

}
$('.choose_delivery').click(function(){
  var dt=$(this).data('id');
  if(dt=='hd')
  {
    // alert(dt);
    $('#homedelivery').prop("checked", true).trigger("click");
    $('.choose_dt').hide();
    get_address();
    $('.choose_address').show();
  }
  else if(dt=='ta')
  {
    // alert(dt);
    $('#takeaway').prop("checked", true).trigger("click");
    $('.choose_dt').hide();
    $('.choose_name').show();
  }
})


function validate_otp(){
    var op= $('#entered_otp').val();
    var mobile_number= $('#validate_mobile_no').val();
    var fullname =$('#fullname').val();
    var deliveryAddress = $('#address').val();
    if(op==pas)
    {

      var cartdetails = JSON.parse(cm_readCookie('qcart1')); 
      var cart = JSON.parse(cm_readCookie(uqid)); 

      cartdetails[uqid]['mobile']= mobile_number;
      cart['details'] = cartdetails[uqid];
      cm_createCookie(uqid,JSON.stringify(cart),0.25);
      cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
      get_details(mobile_number);
      // alert('new window');
      $('.limiter').hide();
      $('.choose_dt').show();

      // cartdetails[uqid]['fullname']= fullname;
      // cartdetails[uqid]['delivery_address']= deliveryAddress;

      

      // console.log(cart);
      // cartUpdate(JSON.stringify(cart));
      // cart={};
/*
      $('.cartStyle').hide();
      var f_amt =$('.finaltotal').text();
      $('#mob').val(mobile_number);
      $('#amt').val(f_amt);
      var rest = cartdetails[uqid]['restaurant_id'];
      $('#restro_id').val(rest);
        document.myForm.submit();
*/
    
   
      //$('#orderDetails').show();
      // $('.cartStyle').hide();
      // $('#newOrderDetails').show();
    }
    else{
      alert('OTP does not match.');
    }
}

function get_details(mobile)
{
    var send_data=new FormData();
    send_data.append('mobile',mobile);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/get-details')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(data){
            var cartdetails = JSON.parse(cm_readCookie('qcart1'));
            cartdetails[uqid]['mobile']= mobile;
            cartdetails[uqid]['fullname']= data.name;
            cartdetails[uqid]['delivery_address']= data.address;
            cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
        },
        cache: true,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });

} 


function generate_order(mobile){
  var cart = JSON.parse(cm_readCookie(uqid)); 
  var cartdetails = JSON.parse(cm_readCookie('qcart1')); 
  cart['details'] = cartdetails[uqid];
  cartUpdate(JSON.stringify(cart));

/*
      $('.cartStyle').hide();
      var f_amt =$('.finaltotal').text();
      $('#mob').val(mobile_number);
      $('#amt').val(f_amt);
      var rest = cartdetails[uqid]['restaurant_id'];
      $('#restro_id').val(rest);
        document.myForm.submit();
*/
  $('#recipient_name').val(cartdetails[uqid]['fullname']);
  $('#recipient_mobile').val(cartdetails[uqid]['mobile']);
  $('.cartStyle').hide();
  $('#newOrderDetails').show();
  cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
  cart={};
  cm_createCookie(uqid,JSON.stringify(cart),0.25);




  //$('#orderDetails').show();
  // $('#clsOtpModal').trigger('click');
  cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
  cart={};
  cm_createCookie(uqid,JSON.stringify(cart),0.25);





}

jQuery('#resent_otp').click(function(){
  generate_otp();
});
$('.add_new_address').click(function(){
  $('#add_new_address').show();
});
$('.cn_new_address').click(function(){
  $('#add_new_address').hide();
});

function check()
{
  // alert();
  var mobile_number = document.getElementById('mobile_for_otp');
  var message = document.getElementById('mobile_validation');

  var goodColor = "#0C6";
  var badColor = "#fefefe";

    <?php if($currency_code!=="inr")
    {
    ?>

      if(mobile_number.value.length < 10 || mobile_number.value.length > 15 ){
        // mobile_number.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.style.display = 'block';
        message.innerHTML = "Phone Number should be 10-15 digits including country code!"
        mobile_number.style.borderColor = badColor;
        mobile_number.focus();
        return false;
      }
      else{
        message.style.display = 'none';
        mobile_number.style.borderColor = goodColor;
        return true;
      }

    <?php
    }
    else
    {
    ?>
      if(mobile_number.value.length != 10 ){
        // mobile_number.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.style.display = 'block';
        message.innerHTML = "Phone Number should be 10 digits!"
        mobile_number.style.borderColor = badColor;
        mobile_number.focus();
        return false;
      }
      else{
        message.style.display = 'none';
        mobile_number.style.borderColor = goodColor;
        return true;
      }
    <?php

    }
    ?>
}
 // cm_createCookie('qcart1',JSON.stringify({}),0);
/*
var qcartDetails=JSON.parse( cm_readCookie('qcart1'));

if(qcartDetails===null)
{
    qcartDetails={

      details:{  
        restaurant_id:13,
        table_id:0,
        home_url:'http://localhost/restaurant/qrestro/fca6662b'
      }
    };
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),30);
}
else if(!qcartDetails[uqid])
{
    qcartDetails={
      details:{     
        mobile:'8010013798',
        restaurant_id:13,
        table_id:0,
        home_url:'http://localhost/restaurant/qrestro/fca6662b'
      }
    };
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),30);
}
else if(qcartDetails[uqid]['mobile'])
{
    qcartDetails[uqid]['restaurant_id']=13;
    qcartDetails[uqid]['table_id']=0;
    qcartDetails[uqid]['home_url']='<?php echo url()->current();?>';
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0);
}

*/

var cartdetails = JSON.parse(cm_readCookie('qcart1')); 
console.log(cartdetails);
//console.log(cartObj);
//alert(cartObj['c']['item']);
</script>
<script>
$(function(){

  $("#order-details").click(function(){
     

     var cartdetails = JSON.parse(cm_readCookie('qcart1'));
     var mobile ="8826126514";
     var mobile ="8010013798";

     // var mobile =cartdetails[uqid]['mobile'];
     console.log(cartdetails);
     if(cartdetails[uqid]['mobile'])
     {
        mobile=cartdetails[uqid]['mobile'];
     }
     else
     {
         var mobile ="0000000000";        
     }

     var send_data=new FormData();
     send_data.append('mobile',mobile);
     send_data.append('table_id',tabID);
     send_data.append('res_id',resID);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/order-details')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(data){
            //console.log(data);
            $('#details-order').html(data);
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });

  });

});

</script>


</body>
</html>