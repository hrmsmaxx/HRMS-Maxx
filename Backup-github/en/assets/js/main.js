		
		
		
$(function () {
	"use strict";
	$.fn.scrollTo = function (options) {

		var settings = {
			offset: 0, //an integer allowing you to offset the position by a certain number of pixels. Can be negative or positive
			speed: 'slow', //speed at which the scroll animates
			override: null, //if you want to override the default way this plugin works, pass in the ID of the element you want to scroll through here
			easing: 'linear' //easing equation for the animation. Supports easing plugin as well (http://gsgd.co.uk/sandbox/jquery/easing/)
		};

		if (options) {
			if (options.override) {
				//if they choose to override, make sure the hash is there
				options.override = (override('#') != -1) ? options.override : '#' + options.override;
			}
			$.extend(settings, options);
		}

		return this.each(function (i, el) {
			$(el).click(function (e) {
				var idToLookAt;
				if ($(el).attr('href').match(/#/) !== null) {
					e.preventDefault();
					idToLookAt = (settings.override) ? settings.override : $(el).attr('href'); //see if the user is forcing an ID they want to use
					//if the browser supports it, we push the hash into the pushState for better linking later
					if (history.pushState) {
						history.pushState(null, null, idToLookAt);
						$('html,body').stop().animate({
							scrollTop: $(idToLookAt).offset().top + settings.offset
						}, settings.speed, settings.easing);
					} else {
						//if the browser doesn't support pushState, we set the hash after the animation, which may cause issues if you use offset
						$('html,body').stop().animate({
							scrollTop: $(idToLookAt).offset().top + settings.offset
						}, settings.speed, settings.easing, function (e) {
							//set the hash of the window for better linking
							window.location.hash = idToLookAt;
						});
					}
				}
			});
		});
	};
	
	
	
	
	
	
});

//Scroll-Anchor
$(document).ready(function () {
	$('.scroll-to').scrollTo();
});


$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.navbar-affixed-top.affix').addClass("affix-position");
    } else {
        $('.navbar-affixed-top.affix').removeClass("affix-position");
    }

});





// Place any code in here.
$(function() {
    'use strict';
    if (/Mobi/.test(navigator.userAgent)) {
        // if mobile device, use native pickers
       
        $(".time input").attr("type", "time");
      } else {
    $("#timepicker").datetimepicker({
        format: "LT",
        icons: {
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down"
        }
      });
    }
    /**
     * PRICING TABLES
     **/
    $(".pricing-plans").on("change", 'input[name="pricing-basis"]', function() {
		console.log(this.value);
        var period = this.value; // can take 'monthly' or 'yearly' as value
		var removeClassName = period === 'monthly' ? 'yearly' : 'monthly';
		
        $(".price", $(".pricing-plans")).each(function() {
            // add 'yearly' css class to 'this' if you want to display /yr label for the price when displayed a yearly basis
			$(this).removeClass(removeClassName);
			$(this).addClass(period);
            this.innerHTML = $(this).data(period);
        });
    });
});



 var screenshot = $(".screenshot-carousel");
    screenshot.owlCarousel({
        loop:true,
        margin:30,
        nav:false,
        dots:false,
        center:true,
        autoplay: true,
        autoplayTimeout: 8000,
        responsive:{
            0:{
                items:2,
            },
            767:{
                items:2,
            },
            768:{
                items:3,
            },
            992:{
                items:3,
            },
            1200:{
                items:3
            }
        }
});


// Data Picker Initialization
$(document).ready(function () {

	$('.datepicker input').datepicker({
		
	});
	
});


// dropdown hover
$('.dropdown-toggle').click(function(e) {
  if ($(document).width() > 768) {
    e.preventDefault();

    var url = $(this).attr('href');

       
    if (url !== '#') {
    
      window.location.href = url;
    }

  }
});