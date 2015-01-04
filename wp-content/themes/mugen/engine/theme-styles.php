<?php
function if_styles() {
	if (!is_admin()) {
		
		wp_register_style('reset-css', THE_CSSURI . 'reset.css', '', '', 'screen, all');
		wp_enqueue_style('reset-css');
		
		wp_register_style('normalize-css', THE_CSSURI . 'normalize.css', 'reset-css', '', 'screen, all');
		wp_enqueue_style('normalize-css');
		
		if( if_register_font( THE_SHORTNAME . '_general_font' ) ){
			wp_enqueue_style( THE_SHORTNAME . '_general_font' );
		}
		
		if( if_register_font( THE_SHORTNAME . '_bigtext_font') ){
			wp_enqueue_style( THE_SHORTNAME . '_bigtext_font');
		}
		
		if( if_register_font( THE_SHORTNAME . '_heading_font') ){
			wp_enqueue_style( THE_SHORTNAME . '_heading_font');
		}
		
		if( if_register_font( THE_SHORTNAME . '_menunav_font') ){
			wp_enqueue_style( THE_SHORTNAME . '_menunav_font');
		}
		
		wp_register_style('skeleton-css', THE_CSSURI . '1140.css', 'normalize-css', '', 'screen, all');
		wp_enqueue_style('skeleton-css');
		
		wp_register_style('entypo-css', THE_CSSURI . 'entypo.css', 'skeleton-css', '', 'screen, all');
		wp_enqueue_style('entypo-css');
		
		wp_register_style('flexslider-css', THE_CSSURI .'flexslider.css', 'entypo-css', '', 'screen, all');
		wp_enqueue_style('flexslider-css');
		
		wp_register_style('main-css', THE_CSSURI . 'main.css', 'entypo-css', '', 'screen, all');
		wp_enqueue_style('main-css');
		
		wp_register_style('prettyPhoto-css', THE_CSSURI . 'prettyPhoto.css', '', '', 'screen, all');
		wp_enqueue_style('prettyPhoto-css');
		
		wp_register_style('layout-css', THE_CSSURI . 'layout.css', '', '', 'screen, all');
		wp_enqueue_style('layout-css');
		
		wp_register_style('color-css', THE_CSSURI . 'color.css', '', '', 'screen, all');
		wp_enqueue_style('color-css');
		
		wp_register_style('stylecustom', THE_STYLEURI . 'style-custom.css', '', '', 'screen, all');
		wp_enqueue_style('stylecustom');
		
		wp_register_style('switcher-css', THE_CSSURI . 'style-switcher.css', '', '', 'screen, all');
		if( if_get_option( THE_SHORTNAME . '_enable_switcher')){
			wp_enqueue_style('switcher-css');
		}
		
		wp_register_style('noscript-css', THE_CSSURI .'noscript.css', '', '', 'screen, all');
		wp_enqueue_style('noscript-css');
		
		wp_register_style('woocommerce-css', THE_CSSURI . 'woocommerce.css', 'woocommerce_frontend_styles', '', 'screen, all');
		wp_enqueue_style('woocommerce-css');
		
	}
}
add_action('init', 'if_styles');