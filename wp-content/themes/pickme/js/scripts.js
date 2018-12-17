
$(document).ready(function(){
	var owl = $('.owl-carousel-home'); 
	owl.owlCarousel({
		nav:true,
	    items:1,
	    loop:true,
	    autoplay:true,
	    autoplayTimeout:5000,
	    navText: ["<i class='arrow_left'></i>","<i class='arrow_right'></i>"],
	    autoplayHoverPause:true
	});
	$('.testimonial_carusel').owlCarousel({ 
		nav:false,
		dots:false,
	    items:1,
	    loop:true,
	    autoplay:true,
	    autoplayTimeout:10000, 
	    autoplayHoverPause:true
	});
	/* $('.header_menu_scroll').css({'display':'none'})
	
    $(window).scroll(function(){
        var scrollTop = 150;
		console.log($(window).scrollTop());
        if($(window).scrollTop() > scrollTop){
			$('.header_menu_scroll').next('.container').css({
				'padding-top':'250px'
			})
			$('.header_menu_scroll').css({'display':'block'})
			$('.header_menu_top').css({'display':'none'})
        }else{
			$('.header_menu_scroll').css({
				'display':'none'
			})
            $('.header_menu_scroll').next('.container').removeAttr('style');
			$('.header_menu_top').css({'display':'block'})
        }
    }) */
   
    var nav = $('.header_menu_top');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 146) {
            nav.addClass("navbar-fixed-top header_menu_scroll");
        } else {
            nav.removeClass("navbar-fixed-top header_menu_scroll");
        }
    });   
   
    $('.framework_description').on('click', function(){
	    $(this).toggleClass('open_framework');
	})
	
	$('.selectBox').on('change',function(){
	   var defaulttext2 = $(this).find(":selected").text(); 
	   var selected_text = $(this).parent().find('.selectDefault');
	   console.log(selected_text);
	   selected_text.text(defaulttext2);
	});
	
	/* $(".scroll-to-this").click(function(e) {
		var _this = $(this);
		console.log(_this.data('scroll'));
		$('html, body').animate({
			scrollTop: $("#history").offset().top
		}, 500);
	});	 */


	/* $(function() {
	  $('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		  if (target.length) {
			$('html,body').animate({
			  scrollTop: target.offset().top
			}, 1000);
			return false;
		  }
		}
	  });
	}); */	
	/* 
	if (window.location.hash.length){
		var target = window.location.hash,
			target = target.replace('#', '');

		// delete hash so the page won't scroll to it
		window.location.hash = "";

		// now whenever you are ready do whatever you want
		// (in this case I use jQuery to scroll to the tag after the page has loaded)
		$(window).on('load', function() {
			if (target) {
				console.log($("#" + target));
				$('html, body').animate({
					scrollTop: $("#" + target).offset().top
				}, 700, 'swing', function () {});
			}
		});
	}	
	 */
});

