jQuery(document).ready(function(){
	
	/*Add Class Js to html*/
	jQuery('html').addClass('js');
	
	/*icon_effects(); //temporarily shutdown */
	
	run_slidercarousel();
	
	topsearch_effects();
	
	header_effects();
	
	menu_effects();
	
	tabs_toggles();
	
	portfolio_effects();
	
	topcat_effects();
	
	topcart_effects();
	
	unload_quickview_img();
	
	form_styling();
});

/*=================================== TOPCATEGORIES ==============================*/
function topcat_effects(){
	var toppcat = jQuery("ul#toppcats li.product_cat");
	var catul = toppcat.children('ul');
	var parentlist = catul.children();
	var listwidth = parseInt(parentlist.css('width'))+25;
	var listcount = parentlist.length;
	var ulwidth = (listcount*listwidth);
	
	catul.css('width',ulwidth);
}

/*=================================== TOPCART ==============================*/
function topcart_effects(){
	
	jQuery('body').bind('added_to_cart', update_custom_cart);
	
	var btncart = jQuery("#topminicart");
	var catcont = jQuery("#topminicart .cartlistwrapper");
	
	btncart.mouseenter(function(){
		catcont.stop().fadeIn(100,'easeOutCubic');
	});
	btncart.mouseleave(function(){
		catcont.stop().fadeOut(100,'easeOutCubic');
	});
}

/*=================================== TOPSEARCH ==============================*/
function topsearch_effects(){
	
	var headertext = jQuery('#headertext');
	var outerafterheader = jQuery('#outerafterheader');
	var outerslider = jQuery('#outerslider');
	var outersliderplax = jQuery('#outerslider.parallax');
	var submitbutton = jQuery("#topsearchform input#searchsubmit");
	var topsearchtext = jQuery("#topsearchform input#s");
	var textfocusout = function(){
		if(!topsearchtext.is(":focus") && topsearchtext.val()==""){
			submitbutton.fadeTo(300,0.5);
		}
	};
	
	topsearchtext.focusin(function(){
		submitbutton.fadeTo(300,1);
	});
	topsearchtext.focusout(textfocusout);
}

/*=================================== TOP HEADER ===================================*/
function header_effects(){
	var headertext = jQuery('#headertext');
	var thebody = jQuery('body.interfeis');
	
	var headertextheight = parseInt(headertext.css("height"));
	jQuery(document).scroll(function(evt){
		if(jQuery(window).scrollTop() > (headertextheight)){
			thebody.addClass("scrolled");
		}else{
			thebody.removeClass("scrolled");
		}
	});
}

/*=================================== MENU ===================================*/
function menu_effects(){
	jQuery("ul.sf-menu").supersubs({ 
    minWidth		: 12,		/* requires em unit. */
    maxWidth		: 15,		/* requires em unit. */
    extraWidth		: 0	/* extra width can ensure lines don't sometimes turn over due to slight browser differences in how they round-off values */
                           /* due to slight rounding differences and font-family */
    }).superfish();  /* 
						call supersubs first, then superfish, so that subs are 
                        not display:none when measuring. Call before initialising 
                        containing tabs for same reason. 
					 */
	jQuery('#topnav li').find('ul.sub-menu').parent('li.menu-item').addClass('hassub').append('<span class="sub-arrow" />');
	//=================================== MOBILE MENU DROPDOWN ===================================//
	jQuery('#topnav').tinyNav({
		active: 'current-menu-item'
	});	
}

/*=================================== TABS AND TOGGLE ===================================*/
function tabs_toggles(){
	
	/*jQuery tab */
	jQuery(".tab-content").hide(); /* Hide all content */
	jQuery("ul.tabs li:first").addClass("active").show(); /* Activate first tab */
	jQuery(".tab-content:first").show(); /* Show first tab content */
	/* On Click Event */
	jQuery("ul.tabs li").click(function() {
		jQuery("ul.tabs li").removeClass("active"); /* Remove any "active" class */
		jQuery(this).addClass("active"); /* Add "active" class to selected tab */
		jQuery(".tab-content").hide(); /* Hide all tab content */
		var activeTab = jQuery(this).find("a").attr("href"); /* Find the rel attribute value to identify the active tab + content */
		jQuery(activeTab).fadeIn(200); /* Fade in the active content */
		return false;
	});
	
	/*jQuery toggle*/
	jQuery(".toggle_container").hide();
	var isiPhone = /iphone/i.test(navigator.userAgent.toLowerCase());
	if (isiPhone){
		jQuery("h2.trigger").click(function(){
			if( jQuery(this).hasClass("active")){
				jQuery(this).removeClass("active");
				jQuery(this).next().css('display','none');
			}else{
				jQuery(this).addClass("active");
				jQuery(this).next().css('display','block');
			}
		});
	}else{
		jQuery("h2.trigger").click(function(){
			jQuery(this).toggleClass("active").next().slideToggle("slow");
		});
	}
}

/*=================================== SOCIAL ICON EFFECT ===================================*/
function icon_effects(){

	jQuery('ul.sn li a').hover(
		function() {
			var iconimg = jQuery(this).children();
			iconimg.stop(true,true);
			iconimg.fadeOut(500);
		},
		function() {
			var iconimg = jQuery(this).children();
			iconimg.stop(true,true);
			iconimg.fadeIn(500);
		}
	);

}

/*=================================== RUN SLIDER ===================================*/
function run_slidercarousel(){
	
	var ctype = {
		"pcarousel-woo" : {
			"index" : '.pf .flexslider-carousel, .woocommerce .flexslider-carousel',
			"minItems" : 2,
			"maxItems" : 4,
			"itemWidth" : 197
		},
		"bcarousel" : {
			"index" : '.brand .flexslider-carousel',
			"minItems" : 2,
			"maxItems" : 6,
			"itemWidth" : 145
		}
	}
	
	for(var key in ctype){
		var carousel = ctype[key];
		jQuery(carousel.index).flexslider({
			animation: "slide",
			animationLoop: true,
			directionNav: true,
			controlNav: false,
			itemWidth: carousel.itemWidth,
			itemMargin: 0,
			minItems: carousel.minItems,
			maxItems: carousel.maxItems
		 });
	}
	
}

/*=================================== FADE EFFECT ===================================*/
function portfolio_effects(){
	
	if (jQuery.browser.msie && jQuery.browser.version < 7) return; /* Don't execute code if it's IE6 or below cause it doesn't support it. */
	
	// Fade image 
	
	jQuery('.if-pf-container li .if-pf-img, .flexslider-carousel li .if-pf-img, div.frameimg').mouseenter(function(){
		jQuery(this).find('div.rollover').stop().animate({"opacity":0.75}, 500, 'easeOutCubic');
		jQuery(this).find('a.image').stop().animate({"left":"50%","opacity":0.90}, 500, 'easeOutCubic');
		jQuery(this).find('a.zoom').stop().animate({"left":"50%","opacity":0.90}, 500, 'easeOutCubic');
	});
	jQuery('.if-pf-container li .if-pf-img, .flexslider-carousel li .if-pf-img, div.frameimg').mouseleave(function(){
		jQuery(this).find('div.rollover').stop().animate({"opacity":0}, 500, 'easeOutCubic');
		jQuery(this).find('a.image').stop().animate({"left":"-10%","opacity":0}, 500, 'easeOutCubic');
		jQuery(this).find('a.zoom').stop().animate({"left":"110%","opacity":0}, 500, 'easeOutCubic');
	});
	
	/*=================================== PRETTYPHOTO ===================================*/
	jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',gallery_markup:'',slideshow:2000,social_tools:''});
}

/*=================================== ISOTOPE FILTER ===================================*/
function isotopeinit(){
	var pffilter = jQuery('#if-pf-filter, .product_filter');
    pffilter.isotope({
        itemSelector : '.element'
    });
	
    jQuery('#filters li, .isotope-filter li').click(function(){
        jQuery('#filters li, .isotope-filter li').removeClass('selected');
        jQuery(this).addClass('selected');
        var selector = jQuery(this).find('a').attr('data-option-value');
		var selectortext = jQuery(this).find('a').text();
		jQuery(this).parents('.filterlist').find('a.filterbutton').html(selectortext);
        pffilter.isotope({ filter: selector });
        return false;
    });
}

/*=================================== CUSTOM CART ===================================*/
function update_custom_cart(){
	var the_cart = jQuery("#topminicart"),
		dropdown_cart = the_cart.find(".cartlistwrapper:eq(0)"),
		subtotal = the_cart.find('.cart_subtotal'),
		cart_widget = jQuery('.widget_shopping_cart');
		
		var new_subtotal = dropdown_cart.find('.total');
		new_subtotal.find('strong').remove();
		subtotal.html( new_subtotal.html() );
}

/*=================================== QUICK VIEW ===================================*/
/*
$("img.hidden").reveal("fadeIn", 1000);
*/

function chgpicturecallback(){

	if(jQuery.isFunction(jQuery.fn.wc_variation_form)){
		jQuery('form.variations_form').wc_variation_form();
	}
	jQuery('form.variations_form .variations select').change();
	jQuery('.quickview-container .images a').removeAttr('rel');
	var mainimage = jQuery('.quickview-container .images a.woocommerce-main-image');
	mainimage.on('click',function(evt){
		evt.preventDefault();
	}).css('cursor','default');
	jQuery('.thumbnails a').on('click',function(evt){
		evt.preventDefault();
		var imgsrc = jQuery(this).attr('href');
		mainimage.find('img').attr("src",imgsrc);
	});
	
	// Quantity buttons
	jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

	// Target quantity inputs on product pages
	jQuery("input.qty:not(.product-quantity input.qty)").each(function(){

		var min = parseFloat( jQuery(this).attr('min') );

		if ( min && min > 0 && parseFloat( jQuery(this).val() ) < min ) {
			jQuery(this).val( min );
		}

	});
	
	var qcselector = jQuery('.quickview-container .if_selector');
	qcselector.each(function(){
		var selval = jQuery(this).find('select option:selected').text();
		var sel = jQuery(this).children('select');
		var selclass = sel.attr('class');
		jQuery(this).children('span').text(selval);
		jQuery(this).addClass(selclass);
		sel.css('width','100%');
		sel.change(function(){
			var selvals = jQuery(this).children('option:selected').text();
			jQuery(this).parent().children('span').text(selvals);
		});
	});
	
}
function unload_quickview_img(){
	var adminurl = interfeis_var.adminurl;
	jQuery("a[rel^='quickview']").prettyPhoto({
		animationSpeed:'slow',
		allow_resize: true,
		gallery_markup:'',
		default_width:760,
		slideshow:2000,
		social_tools:'',
		theme:'light_rounded',
		changepicturecallback: chgpicturecallback,
		ajaxcallback: chgpicturecallback
	}).on('click',function(){jQuery(".quickview-container img").reveal("fadeIn", 1000);});

    jQuery.fn.reveal = function(options){
        return this.each(function(){
            var img = jQuery(this),
                src = img.data("src");
            src && img.attr("src", src).show(options);
        });
    }

    jQuery(function () {
       jQuery(".quickview-container img").not(":visible").each(function () {
           jQuery(this).data("src", this.src).attr("src", "");
       });
    });

}

function form_styling(){
	/* Select */
	var selects = jQuery('select').not('.country_select').not('.state_select').not('#rating');
	selects.wrap('<div class="if_selector" />');
	var selector = jQuery('.if_selector');
	selector.prepend('<span />');
	selector.each(function(){
		var selval = jQuery(this).find('select option:selected').text();
		var sel = jQuery(this).children('select');
		var selclass = sel.attr('class');
		jQuery(this).children('span').text(selval);
		jQuery(this).addClass(selclass);
		sel.css('width','100%');
		sel.change(function(){
			var selvals = jQuery(this).children('option:selected').text();
			jQuery(this).parent().children('span').text(selvals);
		});
	});
}