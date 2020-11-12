<?php $cartCookie; 
$ruppeeSign='&#8377;';
// setcookie('qcart2', '', time() + (86400 * 30), "/"); // 86400 = 1 day
if(isset($_COOKIE['qcart2'])) 
    $cartCookie=json_decode($_COOKIE['qcart2'],true);  // print_r($cartCookie); 
$totalcartCount=0;
$subTotal = 0;
// print_r($cartCookie);
 // die;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Qrestro.com</title>
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

    <style></style>
</head>
<body>
  <div class="top-header"></div>      
  <div class="grid-section">
      <h1 class="text-white"></h1>    
        <!-- <a href = "newpage.html">Next Page</a> -->
  </div>

  <div id="">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 bg-white rounded shadow-sm">
          <div class="od-center">
            <div class="thanks-heading"><h2>Your Order is on its way!</h2></div>
            <div class="thanks-sub-line"><h4>We are happy to tell you that your order is placed successfully.</h4></div>
            <div class="orderdet"><ul>
              <li><span>Payment ID#</span>:<span class="orderid">{{$data->payment_id}}</span></li>  
                <li><span>Order#</span>:<span class="orderid">{{$data->order_id}}</span></li>          
                <li><span>Order Date#</span>:<span class="orderDate">{{date('Y-m-d',strtotime($data->created_at))}}</span></li>  
              
                <!-- <li><span>Order Total#:</span><span class="orderTotal"></span></li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer-section"> 
    <div><a href="{{$url->project_url}}"><i class="fa fa-home" aria-hidden="true"></i></a></div>
    <div><a href="#" class="explore-btn" data-toggle="modal"  data-toggle="modal" data-target="#feedbackDialog">Feedback</a></div>
    <div><a href="#" id="order-details" data-toggle="modal" data-target="#orderDetails"><i class="fa fa-user" aria-hidden="true"></i></a></div>
    <div class="cart-icon"><a href="<?php echo $url->project_url; ?>/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>{{$totalcartCount}}</span></a></div>
  </footer>
  <!-- cart html start -->
  
<!-- cart html end -->
  

<!--- popup mobile vefication start --

<!-- </dialog> -->
  <script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'></script>
  <script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'></script>
  <script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>
    
   
<script>
var pas;
$(document).ready(function() {
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
    $(document).ready(function(){
       // console.log($(this).attr('data-class'));
    })
  
  }
  //Function to Hide Popup
  function div_hide(){
  document.getElementById('pop').style.display = "none";
  }


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

  if(email ==""){
    var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert"></button>' +
                    '<strong>Email is required</strong>' +
                    '</div>';
                $('.error').html(error1);
    return false;
  } 
  if(mobile ==""){
    var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert"></button>' +
                    '<strong>Mobile No. is required</strong>' +
                    '</div>';
                $('.error').html(error1);
    return false;
  } 
  if(feedback ==""){
    var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert"></button>' +
                    '<strong>Feedback is required</strong>' +
                    '</div>';
                $('.error').html(error1);
    return false;
  } 

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
             setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); dailog.close(); location.reload();  }, 3000);
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
        var selectOption = itemDetail.find('select');
        //alert(itemDetail.find('select').val());
        var varientId = itemDetail.find('select').val();
        var name = $('option:selected', selectOption).attr('name');
        var price = $('option:selected', selectOption).attr('price');
//        alert(name);
  //      alert(price);
        var quantity = 1;
        addItemVarient(itemId,itemName,itemPrice,varientId,name,price,quantity);
    
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
    var cart = JSON.parse(cm_readCookie('qcart2'));   
    if(itype=='item'){
      var itemId=$(this).data('itemid');
      if(cart===null)
      {
      }
      else{
        delete cart[itemId];
      }
      cm_createCookie('qcart2',JSON.stringify(cart),30);
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
      cm_createCookie('qcart2',JSON.stringify(cart),30);
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
      // alert(itemQty);
      var itemQty1 = pad_with_zeroes(itemQty, 1)
      // alert(itemQty1);
      $(this).parent().next().val(itemQty1);
    }
    else{
      alert('hellooooo');
      $(this).parent().parent().parent().parent().parent().parent().hide();

    }

    calcTotal();
  });


  
  function addItemVarientQty(itemId,varientId)
  {
    var cart = JSON.parse(cm_readCookie('qcart2'));
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
      cm_createCookie('qcart2',JSON.stringify(cart),30);
      console.log(cart);
    }
  }

  function removeItemVarientQty(itemId,varientId)
  {
    var cart = JSON.parse(cm_readCookie('qcart2'));
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
      cm_createCookie('qcart2',JSON.stringify(cart),30);
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
    addItem(itemId,itemName,itemPrice);
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
    }
    else{
      alert('hellooooo');
      $(this).parent().parent().parent().parent().parent().parent().hide();

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

function addItemVarient(itemId,itemName,itemPrice,varientId,name,price,quantity)
{
    var cart = JSON.parse(cm_readCookie('qcart2'));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                varientId:{}                         
                            }
        cartArr[itemId]['varientId'][varientId] = {
                                    varientName:name,
                                    varientPrice:price,
                                    varientQuantity:quantity
                                }
                                alert(' null cart');
        cm_createCookie('qcart2',JSON.stringify(cartArr),30);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =   {
                                    item: itemName,
                                    price:itemPrice,
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
            cart[itemId]['varientId'][varientId] = {
                                        varientName:name,
                                        varientPrice:price,
                                        varientQuantity:quantity
                                    }
            cart[itemId]['varientId'][varientId]['varientQuantity']=cart[itemId]['varientId'][varientId]['varientQuantity']+1;
            alert('add qty in varient to cart existing item');
        }
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        cm_createCookie('qcart2',JSON.stringify(cart),30);
        console.log(cart);
    }

}

function addItem(itemId,itemName,itemPrice)
{
    var cart = JSON.parse(cm_readCookie('qcart2'));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                qty: 1
                            }
        cm_createCookie('qcart2',JSON.stringify(cartArr),30);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =  {
                                item: itemName,
                                price:itemPrice,
                                qty: 1
                            }
            $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);

        }
        else{
            cart[itemId]['qty']=cart[itemId]['qty']+1;
            $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        }
        cm_createCookie('qcart2',JSON.stringify(cart),30);
        console.log(cart);
    }
}

function removeItem(itemId,itemName,itemPrice)
{
    var cart = JSON.parse(cm_readCookie('qcart2'));
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
        cm_createCookie('qcart2',JSON.stringify(cart),30);
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
  $('.itemRow').each(function(){
    var price = $(this).find('.price').data('price');
    var qty = $(this).find('.input-number').val();
    cartCount+=parseInt(qty);
    subtotal+=price*qty;
  });
  gst=(subtotal*5)/100;
  total=subtotal+gst;
  $('.subtotal').text(subtotal);
  $('.tax').text(gst);
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
  //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
    data:send_data,
    async: false,
    dataType: 'json',
    success: function(data){
      console.log(data);
      $('.orderid').text(data.order_id); 
      $('.orderDate').text(getDate()); 
      $('.orderDisplay').text(data.daily_display_number); 

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

      },
      cache: false,
      enctype: 'multipart/form-data',
      contentType: false,
      processData: false
  });

}
function generate_otp(){
  if(check())
  {
    var mobNum= $('#mobile_for_otp').val();
    mobileVerification(mobNum);
  }
}

function validate_otp(){
    var op= $('#entered_otp').val();
    var mobile_number= $('#mobile_for_otp').val();
    if(op==pas)
    { 
      
      var cart = JSON.parse(cm_readCookie('qcart2'));   
      cart['details']['mobile']= mobile_number;
      console.log(cart);
      cartUpdate(JSON.stringify(cart));
      $('.cartStyle').hide();
      $('#orderDetails').show();
      $('#clsOtpModal').trigger('click');
    }
    else{
      alert('OTP does not match.');
    }
}

jQuery('#resent_otp').click(function(){
  generate_otp();
});

function check()
{
  // alert();
  var mobile_number = document.getElementById('mobile_for_otp');
  var message = document.getElementById('mobile_validation');

  var goodColor = "#0C6";
  var badColor = "#FF0000";

  if(mobile_number.value.length!=10){
    // mobile_number.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.style.display = 'block';
    message.innerHTML = "Required 10 digits, match requested format!"
    mobile_number.style.borderColor = badColor;
    mobile_number.focus();
    return false;
  }
  else{
    message.style.display = 'none';
    mobile_number.style.borderColor = goodColor;
    return true;
  }
}

console.log(document.cookie);
//console.log(cartObj);
//alert(cartObj['c']['item']);
</script>
<?php
$cookie_name = "user";
$cookie_value = "John Doe";
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>
<?php //print_r($_COOKIE); ?>
<?php // $cartCookie=json_decode($_COOKIE['qcart2'],true); print_r($cartCookie['8']); ?>
<?php //print_r($_SESSION); ?>
</body>
</html>