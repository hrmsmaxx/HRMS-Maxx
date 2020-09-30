
$(document).ready(function(){
	if($('.content-page').length > 0 ){
		var height = $(window).height();	
		$(".content-page").css("min-height", height);
	}
});
$(window).resize(function(){
	if($('.content-page').length > 0 ){
		var height = $(window).height();
		$(".content-page").css("min-height", height);
	}
});
$(document).ready(function() {
	if($('.datatable').length > 0 ){
		$('.datatable').DataTable({
			"bPaginate": false,
		});
	}
});
$(document).ready(function() {
	if($('.releasetable').length > 0 ){
		$('.releasetable').DataTable({
		});
	}
});
!function($) {
    "use strict";
    var Sidemenu = function() {
        this.$menuItem = $("#sidebar-menu a")
    };
    // Sidebar Menu
    Sidemenu.prototype.menuItemClick = function(e) {
        if($(this).parent().hasClass("has_sub")) {
          e.preventDefault();
        }   
        if(!$(this).hasClass("subdrop")) {
          // close open menu
          $("ul",$(this).parents("ul:first")).slideUp(350);
          $("a",$(this).parents("ul:first")).removeClass("subdrop");
          $("#sidebar-menu .pull-right i").removeClass("md-remove").addClass("md-add");
          // open new menu
          $(this).next("ul").slideDown(350);
          $(this).addClass("subdrop");
          $(".pull-right i",$(this).parents(".has_sub:last")).removeClass("md-add").addClass("md-remove");
          $(".pull-right i",$(this).siblings("ul")).removeClass("md-remove").addClass("md-add");
        }else if($(this).hasClass("subdrop")) {
          $(this).removeClass("subdrop");
          $(this).next("ul").slideUp(350);
          $(".pull-right i",$(this).parent()).removeClass("md-remove").addClass("md-add");
        }
    },
    Sidemenu.prototype.init = function() {
      var $this  = this;
      $this.$menuItem.on('click', $this.menuItemClick);
      $("#sidebar-menu ul li.has_sub a.active").parents("li:last").children("a:first").addClass("active").trigger("click");
    },
    $.Sidemenu = new Sidemenu, $.Sidemenu.Constructor = Sidemenu
}(window.jQuery),

 function($) {
    "use strict";
    var App = function() {
        this.$body = $("body")
    };
    App.prototype.init = function() {
        var $this = this;
        $(document).ready($this.onDocReady);
        $.Sidemenu.init();
    },
    $.App = new App, $.App.Constructor = App
}(window.jQuery),

function($) {
    "use strict";
    $.App.init();
}(window.jQuery);

$(document).ready(function(){
	if($('.slimscrollleft').length > 0 ){
		$('.slimscrollleft').slimScroll({
			height: 'auto',
			width: '100%',
			position: 'right',
			size: "5px",
			color: '#dcdcdc',
			touchScrollStep : 50,
			wheelStep: 5
		});
		var h=$(window).height()-60;
		$('.slimscrollleft').height(h);
		$('.sidebar .slimScrollDiv').height(h);
		
		$(window).resize(function(){
			var h=$(window).height()-60;
			$('.slimscrollleft').height(h);
			$('.sidebar .slimScrollDiv').height(h);
		});
	}
});

$('#site_logo').change(function(){
   var url = $(this).val();    
   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
   if ((ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "ico")) 
    {
        $('#img_upload_error').css('display','none');
   }
   else
   {
     $('#img_upload_error').css('display','block');
     $('#site_logo').val('');
   }
 });
$('#favicon').change(function(){
   var url = $(this).val();    
   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
   if ((ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "ico")) 
    {
        $('#img_upload_errors').css('display','none');
   }
   else
   {
     $('#img_upload_errors').css('display','block');
     $('#favicon').val('');
   }
 });
	$(document).on('click', '#mobile_btn', function (e) {
		$("#wrapper").removeClass('close-menu').toggleClass('slide-nav-toggle');
		$("body").removeClass('').toggleClass('menu-open');
		return false;
	});
	$(document).on('click', '#close_menu', function() {
		$('#wrapper').toggleClass('close-menu').removeClass('slide-nav-toggle');
		$("body").removeClass('menu-open').toggleClass('');
		return false;
	});

  