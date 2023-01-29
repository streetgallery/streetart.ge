$(".user-nav").mouseenter(function () {
    $(".tooltip-user").removeClass('fade-out').addClass('fade-in');
}).mouseleave(function () {
    $(".tooltip-user").removeClass('fade-in').addClass('fade-out');
});

/*
$('.user-nav').hover(function(){
    $('.dropdown-toggle', this).trigger('click');
});
*/


$('.overlay, .bt-close').on('click', function () {
 //   $('.menuin').removeClass('active');
    $('.sidebar').removeClass('active');
    $('.overlay').removeClass('active');
    $('body').removeClass('body-lock');
   // $('.bar2').removeClass('invis');
});

$('.menuin').on('click', function () {
   // $('.menuin').toggleClass('active');
    $('.sidebar').toggleClass('active');
    $('.overlay').toggleClass('active');
    $('body').toggleClass('body-lock');
 //   $('.bar2').toggleClass('invis');
});


$(window).scroll(function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 34) {
        $(".nav-section").addClass("fixedHeader");
    } else {
        $(".nav-section").removeClass("fixedHeader");
    }
});

$("#menu").slidingMenu();

$('.search-form > input')
    .focus(function() {
        $('.search-form').addClass('focused');
    })
    .blur(function() {
        $('.search-form').removeClass('focused');
    });
