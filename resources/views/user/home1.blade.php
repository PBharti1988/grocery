<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restaurant Project</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> -->
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/custom.css')}}">
   
    <style>
  
    </style>
   
</head>
<body>


@foreach($categories as $val)
<?php $category = $val->category_name; ?>
 @if(!empty($val->$category))
@foreach($val->$category as $val1)
<?php $cat1 = $val1->name; ?>
     @if($cat1 !="")
     @foreach($val1->$cat1 as $val2)
    <div id="pop" class="{{str_replace(' ', '_',$val2->item_name)}} close{{str_replace(' ', '_',$val2->item_name)}}  ">
      
      
            <div id="allpopupContact">
                             
                <div class="pop-container">
                    <?php $img =$val2->item_name; ?>
                   
                    <div class="slider-section">
                          <div class="owl-carousel owl-theme">                     
                              @if(!empty($val2->$img))
                            @foreach($val2->$img as $val3)
                            <div class="item">
                                <img src="{{asset('public/assets/images/item-images/'.$val3->image)}}">
                            </div>     
                            @endforeach                 
                            @else
                            @if($val2->image !="")
                             <div class="product-img">
                             <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
                               </div>
                                 @endif 
                            @endif
                          </div>
                    </div>
                  
                    <div class="product-detail text-black">
                        <h1>{{$val2->item_name}}</h1>
                        <span><i class="fa fa-inr">{{$val2->discount_price}}</i></span>
                        <span class="item_discount"><del><i class="fa fa-inr"><del>{{$val2->item_price}}</i></del></span>
                    </div>
                    <ul class="product-content">
                        <li>
                            <h1>Description</h1>
                            <p>{{$val2->long_description}}</p>
                        </li>
                        <?php $desc ='desc'.$val2->item_name; ?>
                          @if(!empty($val2->$desc))
                      @foreach($val2->$desc as $val4)
                        <li>
                            <h1>{{$val4->title}}</h1>
                            <p>{{$val4->description}}</p>
                        </li>
                        @endforeach
                   @endif

                        <?php  ?>
                    </ul>

                    
                </div>
                <div id="close">
                    <button class="close" data-class="close{{str_replace(' ', '_',$val2->item_name)}}" onclick ="div_hide()">Close</button>
                </div>
            </div>
         
        <!-- Popup Div Ends Here -->
        </div>
        @endforeach
        @endif
        @endforeach
        @endif
        @endforeach
    <div class="top-header"></div>
      
      
    <div class="grid-section">
        <h1 class="text-white">{{$find_resto->name}}</h1>
    
        <section id="grid-container" class="transitions-enabled fluid masonry js-masonry grid" style="">
      <?php $i =1;
      $count=1;
      $articleClass="tile-odd";
//      dd($categories);
      ?>

          @foreach($categories as $val)
          <?php $cat = $val->category_name; $j=1; ?>
            @if(!empty($val->$cat))
            @foreach($val->$cat as $val1)
            <?php $cat1 = $val1->name; ?>
<!--       
            <article class="@if($count%2==1){{'tile-odd'}} @else{{'tile-even'}}@endif {{str_replace(' ','_',$val->category_name)}}">
-->
            @if($cat1 !="")
            @foreach($val1->$cat1 as $val2)
            @if($count%2==1)
            <article class="{{$articleClass}} {{str_replace(' ','_',$val->category_name)}} {{str_replace(' ','_',$val1->name)}}">
            @endif

                  <div class="@if($j%2==1){{'first-box'}} @else{{'second-box'}}@endif box-category {{str_replace(' ', '_',$val2->item_name)}}" data-class="{{str_replace(' ', '_',$val2->item_name)}}" style="background:{{$val2->card_color}}" onclick="div_show()">
                    <div class="pro-type">
                        <div class="@if($val2->item_type == 'veg') veg-product @else non-veg-product @endif"></div>
                    </div>
                    @if($val2->image !="")
                    <div class="product-img">
                        <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
                    </div>
                    @endif
                    <div class="product-detail text-white">
                        <h1>{{$val2->item_name}}</h1>
                        <span><i class="fa fa-inr"></i>{{$val2->discount_price}}</span><span style="margin-left:7px;"><del><i class="fa fa-inr"></i>{{$val2->item_price}}</del></span>
                        <p>{{$val2->short_description}}</p>
                    </div>
                </div>
                <?php $j++;   ?>
            @if($count%2==0)
                </article>
            @endif
            <?php $count++; ?>
            <?php 
              if($count%2==1)
              if($articleClass=="tile-odd")
              {
                $articleClass="tile-even";
              }
              else if($articleClass=="tile-even"){
                $articleClass="tile-odd";
              }            
            ?>
           @endforeach
           @endif
            @endforeach
          @endif
            @endforeach
           
       
        </section>
    </div>

    <!--dummy data for testing sub category---->      
    <!-- <div class="grid-button1 cats  Snacks">
        <div class="button-group1 filters-button-group1">
           <button class="button1 is-checked " data-filter1=".Snacks">
                <div class="restaurant-list">
                    <p>All</p>
                </div>
            </button>
            <button class="button1  " data-filter1=".Snacks">
                <div class="restaurant-list">
                    <p>Masala Dosa</p>
                </div>
            </button>
            <button class="button1" data-filter1=".Snacks">
                <div class="restaurant-list">
                    <p>Plain Dosa</p>
                </div>
            </button>       
     </div>
     </div>   -->

     <!-- <div class="grid-button1 cats Chinese">
        <div class="button-group1 filters-button-group1">
           <button class="button1 is-checked " data-filter1=".Chinese">
                <div class="restaurant-list">
                    <p>Noodles</p>
                </div>
            </button>
            <button class="button1  " data-filter1=".Chinese">
                <div class="restaurant-list">
                    <p>Momos</p>
                </div>
            </button>
            <button class="button1" data-filter1=".Chinese">
                <div class="restaurant-list">
                    <p>Ramen</p>
                </div>
            </button>       
     </div>
     </div>   -->


    
@foreach($categories as $val)
<?php $category = $val->category_name; ?>

   <div class="grid-button1 cats subCategory {{str_replace(' ','_',$val->category_name)}} ">
   <div class="button-group1 filters-button-group1"> 
        @if(!empty($val->$category))
        @foreach($val->$category as $val1)
        <button class="button1" data-filter1=".{{str_replace(' ','_',$val1->name)}}">
                <div class="restaurant-list">
                <img fit="contain" alt="Tiffin Centre" src="{{asset('public/assets/images/sub-category-icon/'.$val1->icon)}}" class="restaurant-img">
                    <p>{{$val1->name}}</p>
                </div>
            </button>
     @endforeach
     @endif
     </div>
     </div> 
       
     @endforeach  

    <!---------->


    <div class="grid-button">
        <div class="button-group filters-button-group">

            <!-- <button class="button is-checked sub " data-filter="*">
                <div class="restaurant-list">
                        <img fit="contain" alt="Tiffin Centre" src="{{asset('public/assets/images/category-icon/all.jpg')}}" class="restaurant-img">

                    <p>All</p>
                    <p></p>
                </div>
            </button> -->
        <?php $i=1;
        ?>
         @foreach($categories as $val)
         <?php $i==1? $active="is-checked":$active=""; ?>
            <button class="button sub {{str_replace(' ','_',$val->category_name)}}"  data-filter=".{{str_replace(' ','_',$val->category_name)}}">
                <div class="restaurant-list">
                   
                        <img fit="contain" alt="Tiffin Centre" src="{{asset('public/assets/images/category-icon/'.$val->icon)}}" class="restaurant-img">
                  
                    <p>{{$val->category_name}}</p>
                   
                </div>
            </button>
            <?php $i++; ?>
            @endforeach
         
        </div>
    </div>

    




    <footer class="footer-section"> 
        <div><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a></div>
        <div><a href="#" class="explore-btn" data-toggle="modal"  onclick="openModal()">Feedback</a></div>
         <div><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></div>
    </footer>
  

  <dialog id="dialog" class="dialog">
  <span class="error"></span>
                <div class="modal-body">
                                      <form id="feedback" enctype="multipart/form-data">
                                
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
                                <span>Give Rating</span><ul id='stars'>
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
                                        <a href="#" id="close-modal"  onclick="closeModal()" class="right btn btn-info close_button">Close</a>
                                       </div>                                   
                                  </form>
                                        </div>
                                  <span id="success" style="display:block; text-align:center;"></span>                                   
  </dialog>

  
      <script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'></script>
      <script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'></script>
      <script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>
    
   
<script>
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
   $('.subCategory'+ subFilter +'').addClass('visible');
   $('.subCategory'+ subFilter +'').show();
   if($('.subCategory'+ subFilter +'').hasClass('visible')){

   }
  });


  var $grid = $('.grid').isotope({
    itemSelector: 'article'
  });

  // filter buttons
  $('.filters-button-group').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter');
    $grid.isotope({ filter: filterValue });
  });
  
  //for sub category///
  $('.filters-button-group1').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter1');
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

$('#grid-container').css('padding-bottom',($('.footer-section').outerHeight() + $('.grid-button').outerHeight()+10));
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
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}

</script>
</body>
</html>