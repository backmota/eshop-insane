<?php 

//Theme init
require_once THE_ENGINEPATH . 'theme-init.php';

//Custom Post Type init
require_once THE_ENGINEPATH . 'cp-init-portfolio.php'; // Portofolio
require_once THE_ENGINEPATH . 'cp-init-testimonial.php'; // Testimonials
require_once THE_ENGINEPATH . 'cp-init-brand.php'; // Brand
require_once THE_ENGINEPATH . 'cp-init-slider.php'; // Slider

//Metaboxes
require_once THE_ENGINEPATH . 'theme-metaboxes.php';

//Widget and Sidebar
require_once THE_ENGINEPATH . 'sidebar-init.php';
require_once THE_ENGINEPATH . 'widgets-init.php';

//Theme Functions
require_once THE_ENGINEPATH . 'theme-functions.php';

//Header function
require_once THE_ENGINEPATH . 'header-functions.php';

//Footer function
require_once THE_ENGINEPATH . 'footer-functions.php';

//Loading jQuery
require_once THE_ENGINEPATH . 'theme-scripts.php';

//Loading Style Css
require_once THE_ENGINEPATH . 'theme-styles.php';

//Loading Theme Shortcodes
require_once THE_ENGINEPATH . 'theme-shortcodes.php';

//Loading LayerSlider Plugins
if(!defined('LS_PLUGIN_VERSION')){
	require_once THE_ENGINEPATH . '/plugins/LayerSlider/layerslider.php';
	
	$if_layerslider_version = get_option(THE_THEMENAME.'_layerslider_version','1.0');
	if(get_option(THE_THEMENAME.'_layerslider_activated',0)==0){
		// Run activation script
		if( is_admin() ){
			layerslider_activation_scripts();
		}
		// Save a flag that it is activated, so this won't run again
		update_option(THE_THEMENAME.'_layerslider_activated', '1');
		update_option(THE_THEMENAME.'_layerslider_version', LS_PLUGIN_VERSION);
	}elseif(version_compare(LS_PLUGIN_VERSION, $if_layerslider_version, '>')) {
		// Check the activation scripts for possible adjustments
		if( is_admin() ){
			layerslider_activation_scripts();
		}
		// Update the layerslider version
		update_option(THE_THEMENAME.'_layerslider_version', LS_PLUGIN_VERSION);
	}
}