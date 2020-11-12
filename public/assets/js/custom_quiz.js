$('.start-survey').click(function(event) {
    alert(1);
    event.preventDefault();
    $(".survey-wrap").css({"margin-left": ""});
    startQuiz();
    $('.survey-wrapnew').show();
   
});


$('.survey-end').hide();
$('.end-survey').click(function(event) {
    finishQuiz();
      $("#test_form").submit();
   
});

$('.go-back').click(function() {
    $('.survey-end').hide();
    $(".click").trigger('click'); 
    $(".survey-questions").css({"display": ""});
    $(".questions").css({"display": ""});
    $(".br").removeClass('q-active1');

    startQuiz();
    $('.q-btn').show();
    $('.timernew').show();
    $(".survey-wrap").show();
    $('.survey-exit').hide();
    $('.survey-wrapnew').show();
    $('.questions').show();
   
});



$('.survey-wrapnew').hide();

//$('.check').prop("checked", true);
// $().click(function(){
// alert();
// });

$('.button5').click(function() {

 //$('.question.q-active').removeClass('q-active').addClass('q-active');
 //$('.question')
 if($('.question').hasClass('q-active')){
    $('.question').removeClass('q-active');
    $('.button5').removeClass('q-active1');
    $('.button5').removeClass('lapColor');
 }
//$(this).addClass('q-active2');

var get_class = $(this).attr("data-class");
var lap_check=$(this).attr('lap-check');
$('.' + get_class).addClass('q-active');

$('.' + lap_check).addClass('lapColor');
$('.' + lap_check).addClass('q-active1');

//alert(get_class);

});


$('.button5').click(function() {

var btn_check12=$('.q-active1').attr('data-class');
var split_lap=btn_check12.split('p');
var lap12=split_lap[1];
var next_valuebtn=$('.q-btn-wrap').attr('data-count');


if(next_valuebtn == lap12){
    $('.q-btn').text('Submit');

}else{
    $('.q-btn').text('Next');
}

});

$('.lap_change').click(function(event) {
    event.preventDefault();
   var t=$('.button5').attr('lap-check');
  // alert(t);
   // nextQuestion();
});


$('.q-btn').click(function(event) {
    event.preventDefault();
    nextQuestion();
});

$('.q-btn.skip').click(function(event) {
    event.preventDefault();
    nextQuestionSkip();
});




// $('.ans').click(function(event) {
//     event.preventDefault();
//   //  $(".skiptype").attr("checked", false);

// });



$('.q-btn-ans').click(function() {
    
   // alert();
     var btn1=$(this).attr('data-count');
   
    if ($('.question').hasClass('q-active')) {
        var lap_take1=$('.q-active').attr('data-class');
        var split_var1=lap_take1.split('p');
             
        var lap_value1=split_var1[1];
        if(btn1-1 == lap_value1){
            $('.q-btn-ans').text('Finish');       
        }else{
             $('.q-btn-ans').text('Next');
         }

    } 
    
    
    
    
    nextAnswer();
});







$('.question').on('change', 'input', function() {
    $('.question.q-active .ans-wrap').removeClass("ans-selected");
    $(this).parent().addClass("ans-selected");
    if($(this).parent().hasClass('ans-selected')){
        var attr=$(this).parent().attr('checked_data');
         $('.'+attr).addClass('selected_color');
    }

    
});



function startQuiz() {
    $("#q-loader").show();
    setTimeout(function() {
        $('.survey-intro').hide();
        $("#q-loader").hide();
        $('.survey-questions').show();
    }, 0);
}


function nextQuestion() {
   // if ($('.question.q-active .ans').is(':checked')) {
        $("#q-loader").show();
        $('.button5').removeClass('lapColor');
        setTimeout(function() {
            $("#q-loader").hide();
            $('.question.q-active').removeClass('q-active').next().addClass('q-active');
            $('.q-active1').removeClass('q-active1').next().addClass('q-active1');
            //var check=$('')

        }, 500);
        
        
        
        
          $(".q-btn-wrap").click(function(){
           var btn=$('.q-btn-wrap').attr('data-count');
            if ($('.question').hasClass('q-active')) {
              
              //  var next_value=$('.q_btn').attr('data-count');
               var lap_take=$('.q-active').attr('data-class');
              // alert(lap_take);
              var split_var=lap_take.split('p');
             
              var lap_value=split_var[1];
              if(btn-1 == lap_value){
                  $('.q-btn').text('Submit');
              }else{
                $('.q-btn').text('Next');
              }
                }
            });
   // } 

    // else {
    //     $('.question.q-active .ans-wrap').addClass("q-warning");
    //     setTimeout(function() {
    //         $('.question.q-active .ans-wrap').removeClass("q-warning");
    //     }, 400);
    //      }
    if ($('.question.q-last').hasClass('q-active')) {
        $('.survey-wrapnew').hide();
         $('.survey-end').show();
      $('.q-btn').hide();
      $('.timernew').hide();
        // finishQuiz();
        // $("#test_form").submit();
        
    } 
}


// $('.select_check').click(function(){
    
//     if($('.select_check').hasClass('ans-selected')){
//       var attr=$(this).attr('checked_data');
//       $('.'+attr).addClass('selected_color');
    
  
//     }
  
//   });



// function nextQuestionSkip() {
//  //   if ($('.question.q-active .ans').prop('checked'),false) {
//     $('.question.q-active .ans-wrap').removeClass("q-warning");
//         $("#q-loader").show();
//         setTimeout(function() {
//             $("#q-loader").hide();
//             $('.question.q-active').removeClass('q-active').next().addClass('q-active');
//             $('.q-active1').removeClass('q-active1').next().addClass('q-active1');

//         }, 500);
//     // } else {
//     //     $('.question.q-active .ans-wrap').addClass("q-warning");
//     //     setTimeout(function() {
//     //         $('.question.q-active .ans-wrap').removeClass("q-warning");
//     //     }, 400);
//     // }
    
//     if ($('.question.q-last').hasClass('q-active')) {
//         finishQuiz();
//         $("#test_form").submit();
        
//     } 


// }









function nextAnswer() {
        $("#q-loader").show();
        setTimeout(function() {
            $("#q-loader").hide();
            $('.question.q-active').removeClass('q-active').next().addClass('q-active');

        }, 200);

        if ($('.question.q-last').hasClass("q-active")){
            //  $("#test_form").submit();
              finishQuiz();
              $("#alert1").hide();
              $("#status_ques").hide();
           //  alert();
          }
}

function finishQuiz() {
    $("#q-loader").show();
    setTimeout(function() {
        $('.survey-questions').hide();
        $("#q-loader").hide();
        $('.survey-exit').show();
    }, 100);
}