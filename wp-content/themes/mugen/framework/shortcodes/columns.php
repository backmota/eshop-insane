<?php 
	/* Columns Shortcode */
	add_shortcode('row', 'if_row');
	add_shortcode('one_half', 'if_one_half');
	add_shortcode('one_third', 'if_one_third');
	add_shortcode('one_fourth', 'if_one_fourth');
	add_shortcode('one_fifth', 'if_one_fifth');
	add_shortcode('one_sixth', 'if_one_sixth');
	
	add_shortcode('two_third', 'if_two_third');
	add_shortcode('two_fourth', 'if_two_fourth');
	add_shortcode('two_fifth', 'if_two_fifth');
	add_shortcode('two_sixth', 'if_two_sixth');
	
	
	add_shortcode('three_fourth', 'if_three_fourth');
	add_shortcode('three_fifth', 'if_three_fifth');
	add_shortcode('three_sixth', 'if_three_sixth');
	
	add_shortcode('four_fifth', 'if_four_fifth');
	add_shortcode('four_sixth', 'if_four_sixth');
	
	add_shortcode('five_sixth', 'if_five_sixth');
	
	
	
	/* -----------------------------------------------------------------
		Columns shortcodes
	----------------------------------------------------------------- */
	function if_row($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="row '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	
	function if_one_half($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="six columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	

	function if_one_third($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="four columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	
	function if_one_fourth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="three columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_one_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="two columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_two_third($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="eight columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_two_fourth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="six columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_two_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="four columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_three_fourth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="nine columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_three_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="six columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	
	function if_four_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="eight columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
	
	function if_five_sixth($atts, $content = null) {
		extract(shortcode_atts(array(
					"class" => ''
		), $atts));
		
		$output = '<div class="ten columns '.$class.'">' . $content . '</div>';
		
		return do_shortcode($output);
		
	}
?>