<?php
function if_script() {
	if (!is_admin()) {

		wp_enqueue_script('jquery');
		
		wp_register_script('jeasing', THE_JSURI .'jquery.easing.js', array('jquery'), '1.2', true);
		wp_enqueue_script('jeasing');
		
		wp_register_script('jcolor', THE_JSURI .'jquery.color.js', array('jquery'), '2.0', true);
		wp_enqueue_script('jcolor');
		
		wp_register_script('switcher', THE_JSURI .'switcher.js', array('jquery'), '1.0', true);
		wp_register_script('jcookie', THE_JSURI .'jquery.cookie.js', array('jquery'), '1.0', true);
		if(if_get_option( THE_SHORTNAME . '_enable_switcher') ){
			wp_enqueue_script('switcher');
			wp_enqueue_script('jcookie');
		}
		
		wp_register_script('modernizr', THE_JSURI .'modernizr.js', array('jquery'), '2.5.3');
		wp_enqueue_script('modernizr');
		
		wp_register_script('jisotope', THE_JSURI .'jquery.isotope.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jisotope');
		
		wp_register_script('jsuperfish', THE_JSURI .'superfish.js', array('jquery'), '1.4.8', true);
		wp_enqueue_script('jsuperfish');
		
		wp_register_script('jsupersubs', THE_JSURI .'supersubs.js', array('jquery'), '0.2', true);
		wp_enqueue_script('jsupersubs');
		
		wp_register_script('jprettyPhoto', THE_JSURI .'jquery.prettyPhoto.js', array('jquery'), '3.0', true);
		wp_enqueue_script('jprettyPhoto');
		
		wp_register_script('jflexslider', THE_JSURI .'jquery.flexslider-min.js', array('jquery'), '1.8', true);
		wp_enqueue_script('jflexslider');
		
		wp_register_script('tinynav', THE_JSURI .'tinynav.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('tinynav');
		
		$depcustomjs = array('jquery');
		if(function_exists('is_woocommerce')){
			$depcustomjs[] = 'wc-add-to-cart-variation';
		}
		
		wp_register_script('jcustom', THE_JSURI .'custom.js', $depcustomjs, '1.0', true);
		wp_enqueue_script('jcustom');
		
		wp_enqueue_script( 'wc-add-to-cart-variation');
		
		wp_register_script('jcustomaddtocart', THE_JSURI .'custom-add-to-cart.js', array('jquery', 'wc-add-to-cart-variation'), '1.0', true);
		wp_enqueue_script('jcustomaddtocart');
		
		$interfeisvar = array( 'siteurl' => site_url(), 'adminurl' => admin_url() );
		wp_localize_script( 'jcustom', 'interfeis_var', $interfeisvar );
		
	}
}
add_action('init', 'if_script');

add_action('wp_footer','if_add_to_cart_script');
function if_add_to_cart_script(){ wp_enqueue_script('wc-add-to-cart-variation'); }