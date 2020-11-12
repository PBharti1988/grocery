// $(document).on('ready', function() {
          
//   $(".regular").slick({
//     dots: false,
//     infinite: true,
//     slidesToShow: 1,
//     slidesToScroll: 1,
//     autoplay: true,
//     // variableHeight: true,
//     // dots: true,
//     speed: 1000,
//     // cssEase: 'linear',
//     // useTransform:true
//     // fade: true
//   });
 
// });


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

  var $grid = $('.grid').isotope({
    itemSelector: 'article'
  });

  // filter buttons
  $('.filters-button-group').on( 'click', 'button', function() {
   
    var filterValue = $(this).attr('data-filter');
    console.log(filterValue);
    $grid.isotope({ filter: filterValue });
  });

  $('.filters-button-group1').on( 'click', 'button', function() {
   
    var filterValue = $(this).attr('data-filter1');
    console.log(filterValue);
    $grid.isotope({ filter: filterValue });
  });

  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });

  ///

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
function div_show() {
  document.getElementById('pop').style.display = "block";
  }
  //Function to Hide Popup
  function div_hide(){
  document.getElementById('pop').style.display = "none";
  }


