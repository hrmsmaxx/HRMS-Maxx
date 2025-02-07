
/* Menu */

/*
 * jQuery canvasMenu Menus Plugin v0.1.5 (2013-09-07)
 * https://github.com/tefra/canvasMenu
 *
 * Copyright (c) 2013 Chris T (@tefra)
 * BSD - https://github.com/tefra/canvasMenu/blob/master/LICENSE-BSD
 */
(function($) {

	"use strict";
        


	/**
	 * Plugin Constructor. Every menu must have a unique id which will either
	 * be the actual id attribute or its index in the page.
	 *
	 * @param {Element} el
	 * @param {Object} options
	 * @param {Integer} idx
	 * @returns {Object} Plugin Instance
	 */
	var Plugin = function(el, options, idx) {
		this.el = el;
		this.$el = $(el);
		this.options = options;
		this.uuid = this.$el.attr('id') ? this.$el.attr('id') : idx;
		this.state = {};
		this.init();
		return this;
	};

	/**
	 * Plugin methods
	 */
	Plugin.prototype = {
		/**
		 * Load cookie, assign a unique data-index attribute to
		 * all sub-menus and show|hide them according to cookie
		 * or based on the parent open class. Find all parent li > a
		 * links add the carent if it's on and attach the event click
		 * to them.
		 */
		init: function() {
			var self = this;
			self._load();
			self.$el.find('ul').each(function(idx) {
				var sub = $(this);
				sub.attr('data-index', idx);
				if (self.options.save && self.state.hasOwnProperty(idx)) {
					sub.parent().addClass(self.options.openClass);
					sub.show();
				} else if (sub.parent().hasClass(self.options.openClass)) {
					sub.show();
					self.state[idx] = 1;
				} else {
					sub.hide();
				}
			});

			if (self.options.caret) {
				self.$el.find("li:has(ul) > a").append(self.options.caret);
			}

			var links = self.$el.find("li > a");
			links.on('click', function(event) {
				event.stopPropagation();
				var sub = $(this).next();
				sub = sub.length > 0 ? sub : false;
				self.options.onClickBefore.call(this, event, sub);
				if (sub) {
					event.preventDefault();
					self._toggle(sub, sub.is(":hidden"));
					self._save();
				} else {
					if (self.options.accordion) {
						var allowed = self.state = self._parents($(this));
						self.$el.find('ul').filter(':visible').each(function() {
							var sub = $(this),
								idx = sub.attr('data-index');

							if (!allowed.hasOwnProperty(idx)) {
								self._toggle(sub, false);
							}
						});
						self._save();
					}
				}
				self.options.onClickAfter.call(this, event, sub);
			});
		},
		/**
		 * Accepts a JQuery Element and a boolean flag. If flag is false it removes the `open` css
		 * class from the parent li and slides up the sub-menu. If flag is open it adds the `open`
		 * css class to the parent li and slides down the menu. If accordion mode is on all
		 * sub-menus except the direct parent tree will close. Internally an object with the menus
		 * states is maintained for later save duty.
		 *
		 * @param {Element} sub
		 * @param {Boolean} open
		 */
		_toggle: function(sub, open) {
			var self = this,
				idx = sub.attr('data-index'),
				parent = sub.parent();

			self.options.onToggleBefore.call(this, sub, open);
			if (open) {
				parent.addClass(self.options.openClass);
				sub.slideDown(self.options.slide);
				self.state[idx] = 1;

				if (self.options.accordion) {
					var allowed = self.state = self._parents(sub);
					allowed[idx] = self.state[idx] = 1;

					self.$el.find('ul').filter(':visible').each(function() {
						var sub = $(this),
							idx = sub.attr('data-index');

						if (!allowed.hasOwnProperty(idx)) {
							self._toggle(sub, false);
						}
					});
				}
			} else {
				parent.removeClass(self.options.openClass);
				sub.slideUp(self.options.slide);
				self.state[idx] = 0;
			}
			self.options.onToggleAfter.call(this, sub, open);
		},
		/**
		 * Returns all parents of a sub-menu. When obj is true It returns an object with indexes for
		 * keys and the elements as values, if obj is false the object is filled with the value `1`.
		 *
		 * @since v0.1.2
		 * @param {Element} sub
		 * @param {Boolean} obj
		 * @returns {Object}
		 */
		_parents: function(sub, obj) {
			var result = {},
				parent = sub.parent(),
				parents = parent.parents('ul');

			parents.each(function() {
				var par = $(this),
					idx = par.attr('data-index');

				if (!idx) {
					return false;
				}
				result[idx] = obj ? par : 1;
			});
			return result;
		},
		/**
		 * If `save` option is on the internal object that keeps track of the sub-menus states is
		 * saved with a cookie. For size reasons only the open sub-menus indexes are stored.		 *
		 */
		_save: function() {
			if (this.options.save) {
				var save = {};
				for (var key in this.state) {
					if (this.state[key] === 1) {
						save[key] = 1;
					}
				}
				cookie[this.uuid] = this.state = save;
				$.cookie(this.options.cookie.name, JSON.stringify(cookie), this.options.cookie);
			}
		},
		/**
		 * If `save` option is on it reads the cookie data. The cookie contains data for all
		 * canvasMenu menus so the read happens only once and stored in the global `cookie` var.
		 */
		_load: function() {
			if (this.options.save) {
				if (cookie === null) {
					var data = $.cookie(this.options.cookie.name);
					cookie = (data) ? JSON.parse(data) : {};
				}
				this.state = cookie.hasOwnProperty(this.uuid) ? cookie[this.uuid] : {};
			}
		},
		/**
		 * Public method toggle to manually show|hide sub-menus. If no indexes are provided all
		 * items will be toggled. You can pass sub-menus indexes as regular params. eg:
		 * canvasMenu('toggle', true, 1, 2, 3, 4, 5);
		 *
		 * Since v0.1.2 it will also open parents when providing sub-menu indexes.
		 *
		 * @param {Boolean} open
		 */
		toggle: function(open) {
			var self = this,
				length = arguments.length;

			if (length <= 1) {
				self.$el.find('ul').each(function() {
					var sub = $(this);
					self._toggle(sub, open);
				});
			} else {
				var idx,
					list = {},
					args = Array.prototype.slice.call(arguments, 1);
				length--;

				for (var i = 0; i < length; i++) {
					idx = args[i];
					var sub = self.$el.find('ul[data-index="' + idx + '"]').first();
					if (sub) {
						list[idx] = sub;
						if (open) {
							var parents = self._parents(sub, true);
							for (var pIdx in parents) {
								if (!list.hasOwnProperty(pIdx)) {
									list[pIdx] = parents[pIdx];
								}
							}
						}
					}
				}

				for (idx in list) {
					self._toggle(list[idx], open);
				}
			}
			self._save();
		},
		/**
		 * Removes instance from JQuery data cache and unbinds events.
		 */
		destroy: function() {
			$.removeData(this.$el);
			this.$el.find("li:has(ul) > a").unbind('click');
		}
	};

	/**
	 * A JQuery plugin wrapper for canvasMenu. It prevents from multiple instances and also handles
	 * public methods calls. If we attempt to call a public method on an element that doesn't have
	 * a canvasMenu instance, one will be created for it with the default options.
	 *
	 * @param {Object|String} options
	 */
	$.fn.canvasMenu = function(options) {
		if (typeof options === 'string' && options.charAt(0) !== '_' && options !== 'init') {
			var callback = true,
				args = Array.prototype.slice.call(arguments, 1);
		} else {
			options = $.extend({}, $.fn.canvasMenu.defaults, options || {});
			if (!$.cookie) {
				options.save = false;
			}
		}
		return this.each(function(idx) {
			var $this = $(this),
				obj = $this.data('canvasMenu');

			if (!obj) {
				obj = new Plugin(this, callback ? $.fn.canvasMenu.defaults : options, idx);
				$this.data('canvasMenu', obj);
			}
			if (callback) {
				obj[options].apply(obj, args);
			}
		});
	};
	/**
	 * Global var holding all canvasMenu menus open states
	 *
	 * @type {Object}
	 */
	var cookie = null;

	/**
	 * Default canvasMenu options
	 *
	 * @type {Object}
	 */
	$.fn.canvasMenu.defaults = {
		caret: '<span class="sub-icon"></span>',
		accordion: false,
		openClass: 'open',
		save: true,
		cookie: {
			name: 'canvasMenu',
			expires: false,
			path: '/'
		},
		slide: {
			duration: 400,
			easing: 'swing'
		},
		onClickBefore: $.noop,
		onClickAfter: $.noop,
		onToggleBefore: $.noop,
		onToggleAfter: $.noop
	};
})(jQuery);



$(document).ready(function () {

	//Navigation Menu Slider
	$('.nav-expander').on('click', function (e) {
		e.preventDefault();
		$('body').toggleClass('nav-expanded');
	});
	$('#nav-close').on('click', function (e) {
		e.preventDefault();
		$('body').removeClass('nav-expanded');
	});


	// Initialize canvasMenu with default options
	$(".main-menu").canvasMenu({
		caret: '<span class="sub-icon"></span>',
		accordion: false,
		openClass: 'open',
		save: true,
		cookie: {
			name: 'canvasMenu',
			expires: false,
			path: '/'
		},
		slide: {
			duration: 300,
			easing: 'swing'
		}
	});


});



/* scroll-to-top */

$('.return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});




//Breadcrumb

$(function(){
    
   $('.banner-contents li a').click(function(){
      var item=$(this).parent();
       $('.banner-contents li a').removeClass('current');
       item.addClass("current")
    });
       
});
        
jQuery(function($) {
 var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
 $('ul.sub-nav-block a, ul.main-menu a').each(function() {
  if (this.href === path) {
   $(this).addClass('active');
  }
 });
});

              $(".carousel").on("touchstart", function(event){
        var xClick = event.originalEvent.touches[0].pageX;
    $(this).one("touchmove", function(event){
        var xMove = event.originalEvent.touches[0].pageX;
        if( Math.floor(xClick - xMove) > 5 ){
            $(this).carousel('next');
        }
        else if( Math.floor(xClick - xMove) < -5 ){
            $(this).carousel('prev');
        }
    });
    $(".carousel").on("touchend", function(){
            $(this).off("touchmove");
    });
});


function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
