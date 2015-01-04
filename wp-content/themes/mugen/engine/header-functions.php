<?php 
// get website title
if(!function_exists("if_document_title")){
	function if_document_title(){
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
		if( !defined('WPSEO_URL') ){
			// Add the blog name.
			bloginfo( 'name' );
		
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
		
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s', THE_LANG ), max( $paged, $page ) );
		}
	}// end if_document_title()
}

// head action hook
if(!function_exists("if_head")){
	function if_head(){
		do_action("if_head");
	}
	add_action('wp_head', 'if_head', 20);
}

if(!function_exists("if_metaviewport")){
	function if_metaviewport(){
		$dis_viewport = if_get_option(THE_SHORTNAME . '_disable_viewport');
		if(!$dis_viewport){
			echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		}
	}
	add_action('if_head', 'if_metaviewport', 5);
}

if(!function_exists("if_print_headmiscellaneous")){
	function if_print_headmiscellaneous(){
	
		echo "<!--[if lt IE 9]>\n";
		echo "<script src='".THE_JSURI."html5shiv.js type='text/javascript'></script>\n";
		echo "<![endif]-->\n";

        $favicon = if_get_option( THE_SHORTNAME . '_favicon');
        if($favicon =="" ){
            $favicon = get_template_directory_uri() . '/images/favicon.ico';
        }
		echo '<link rel="shortcut icon" href="' . $favicon . '" />';
        
	}
	add_action('if_head', 'if_print_headmiscellaneous', 6);
}

// get style
if(!function_exists("if_print_stylesheet")){
	function if_print_stylesheet(){
	
		//Get Option Style
		$optGeneralTextFont = if_get_option( THE_SHORTNAME . '_general_font');
		if($optGeneralTextFont!="0"){
			$GeneralTextFont = explode(":",$optGeneralTextFont);
			$GeneralTextOutput = "'". $GeneralTextFont[0] . "',";
		}
		
		$optBigTextFont = if_get_option( THE_SHORTNAME . '_bigtext_font');
		if($optBigTextFont!="0"){
			$BigTextFont = explode(":",$optBigTextFont);
			$BigTextOutput = "'". $BigTextFont[0] . "',";
		}
		
		$optHeadingFont = if_get_option( THE_SHORTNAME . '_heading_font');
		if($optHeadingFont!="0"){
			$HeadingFont = explode(":",$optHeadingFont);
			$HeadingOutput = "'". $HeadingFont[0] . "',";
		}
		
		$optMenuFont = if_get_option( THE_SHORTNAME . '_menunav_font');
		if($optMenuFont!="0"){
			$MenuFont = explode(":",$optMenuFont);
			$MenuOutput = "'". $MenuFont[0] . "',";
		}
		
		$txtContainerWidth = intval( if_get_option( THE_SHORTNAME . '_container_width') );
		$optionDefault = of_get_default_values();
		if($txtContainerWidth<960 || $txtContainerWidth >1140){
			$txtContainerWidth = $optionDefault[THE_SHORTNAME . '_container_width'];
		}
		
		$optHeaderPos = if_get_option( THE_SHORTNAME . '_header_position');
		
		//get background from metabox
		$prefix = 'if_';
		if( is_home() ){
			$pid = get_option('page_for_posts');
		}else{
			$pid = get_the_ID();
		}
		$custom = if_get_customdata($pid);
		
		$optBodyBG = if_get_option( THE_SHORTNAME . '_body_background');
		$optBodyBGColor = $optBodyBG['color'];
		$optBodyBGImage = $optBodyBG['image'];
		$optBodyBGPosition = $optBodyBG['position'];
		$optBodyBGStyle = $optBodyBG['repeat'];
		$optBodyBGattachment = $optBodyBG['attachment'];
		
		$cf_pagebgimg = (isset($custom[$prefix."page-bgimg"][0]))? $custom[$prefix."page-bgimg"][0] : "";
		$cf_pagebgposition = (isset($custom[$prefix."page-bgposition"][0]))? $custom[$prefix."page-bgposition"][0] : "";
		$cf_pagebgstyle = (isset($custom[$prefix."page-bgstyle"][0]))? $custom[$prefix."page-bgstyle"][0] : "";
		
		/* Header Background */
		$opt_bgHeader 		= if_get_option( THE_SHORTNAME . '_header_background');
        
		$cf_bgHeader 		= "";
		$cf_bgRepeat 		= "repeat";
		$cf_bgPos	 		= "center";
		$cf_bgAttch	 		= "";
		$cf_bgColor	 		= "transparent";
		
		if( $opt_bgHeader){
			if($opt_bgHeader["image"]!=""){
				$cf_bgHeader 	= $opt_bgHeader["image"];
			}
			$cf_bgRepeat 		= $opt_bgHeader["repeat"];
			$cf_bgPos	 		= $opt_bgHeader["position"];
			$cf_bgAttch	 		= $opt_bgHeader["attachment"];
			$cf_bgColor	 		= ($opt_bgHeader["color"]!="")? $opt_bgHeader["color"] : "transparent";
		}

		$cf_bgHeader 		= (isset($custom["bg_header"][0]) && trim($custom["bg_header"][0])!="")? $custom["bg_header"][0] : $cf_bgHeader;
		$cf_bgRepeat 		= (isset($custom["bg_repeat"][0]) && trim($custom["bg_repeat"][0])!="")? $custom["bg_repeat"][0] : $cf_bgRepeat;
		$cf_bgPos	 		= (isset($custom["bg_pos"][0]) && trim($custom["bg_pos"][0])!="")? $custom["bg_pos"][0] : $cf_bgPos;
		$cf_bgAttch	 		= (isset($custom["bg_attch"][0]) && trim($custom["bg_attch"][0])!="")? $custom["bg_attch"][0] : $cf_bgAttch;
		$cf_bgColor	 		= (isset($custom["bg_color"][0]) && trim($custom["bg_color"][0])!="")? $custom["bg_color"][0] : $cf_bgColor;
		
		/* Footer Background */
		$opt_bgFooter 		= if_get_option( THE_SHORTNAME. '_footer_background');

		$cf_bgFooter 		= "";
		$cf_bgRepeatFooter	= "repeat";
		$cf_bgPosFooter		= "center";
		$cf_bgColorFooter	= "transparent";
		
		if( $opt_bgFooter ){
			if($opt_bgFooter["image"]!=""){
				$cf_bgFooter 	= $opt_bgFooter["image"];
			}
			$cf_bgRepeatFooter	= $opt_bgFooter["repeat"];
			$cf_bgPosFooter		= $opt_bgFooter["position"];
			$cf_bgAttchFooter	= $opt_bgFooter["attachment"];
			$cf_bgColorFooter	= ($opt_bgFooter["color"]!="")? $opt_bgFooter["color"] : "";
		}

		$cf_bgFooter 		= (isset($custom["bg_footer"][0]) && trim($custom["bg_footer"][0])!="")? $custom["bg_footer"][0] : $cf_bgFooter;
		$cf_bgRepeatFooter	= (isset($custom["bg_repeat_footer"][0]) && trim($custom["bg_repeat_footer"][0])!="")? $custom["bg_repeat_footer"][0] : $cf_bgRepeatFooter;
		$cf_bgPosFooter		= (isset($custom["bg_pos_footer"][0]) && trim($custom["bg_pos_footer"][0])!="")? $custom["bg_pos_footer"][0] : $cf_bgPosFooter	;
		$cf_bgColorFooter	= (isset($custom["bg_color_footer"][0]) && trim($custom["bg_color_footer"][0])!="")? $custom["bg_color_footer"][0] : $cf_bgColorFooter;
		
		?>
		<style type="text/css" media="screen">
			body{
			<?php if($optGeneralTextFont!="0"){ ?>
				font-family: <?php echo $GeneralTextOutput; ?> sans-serif !important;
			<?php } ?>
			<?php if($cf_pagebgimg!=""){ ?>
				background-image:url(<?php echo $cf_pagebgimg ; ?>);
				background-repeat:<?php echo $cf_pagebgstyle ; ?>;
				background-position: <?php echo $cf_pagebgposition; ?>;
			
			<?php }else{ ?>
			
				<?php if($optBodyBGImage!="" || $optBodyBGColor!=""){?>
				background-color:<?php echo $optBodyBGColor ; ?>;
				background-image:url(<?php echo $optBodyBGImage ; ?>);
				background-repeat:<?php echo $optBodyBGStyle ; ?>;
				background-position: <?php echo $optBodyBGPosition; ?>;
				background-attachment: <?php echo $optBodyBGattachment ; ?>;
				<?php } ?>
				
			<?php } ?>
			}
			
			#outerafterheader{
			<?php
				if($cf_bgHeader){
					echo 'background-image:url(' . $cf_bgHeader . ');';
				}
				if($cf_bgColor!=""){
					echo 'background-color:' . $cf_bgColor . ';';
				}
				echo 'background-repeat:' . $cf_bgRepeat . '; background-position:' . $cf_bgPos . ';';
			?>
			}
			
			<?php if($optMenuFont!="0"){ ?>
			#topnav li a, #topnav li a:visited{font-family: <?php echo $MenuOutput; ?> futura !important;}
			<?php } ?>
			<?php if($optHeadingFont!="0"){ ?>
			h1, h2, h3, h4, h5, h6{font-family: <?php echo $HeadingOutput; ?> futura !important;}
			<?php } ?>
			<?php if($optBigTextFont!="0"){ ?>
			.bigtext{
				font-family: <?php echo $BigTextOutput; ?> sans-serif !important;
			}
			<?php } ?>
			#subbody .row{max-width:<?php echo $txtContainerWidth; ?>px;}
			.boxed #outercontainer{max-width:<?php echo $txtContainerWidth+120; ?>px;}
			#outerheader{position:<?php echo $optHeaderPos; ?>;}
			
			#footerwrapper{
			<?php
				if($cf_bgFooter){ 			
					echo 'background-image:url(' . $cf_bgFooter . ');';
				}
				if($cf_bgColorFooter!=""){
					echo 'background-color:' . $cf_bgColorFooter . ';';
				}
				echo 'background-repeat:' . $cf_bgRepeatFooter . '; background-position:' . $cf_bgPosFooter . ';';
			?>
			}
        </style>
       <?php
		
	}// end function if_print_stylesheet
	add_action("if_head","if_print_stylesheet",7);
}

// print the logo html
if(!function_exists("if_logo")){
	function if_logo(){ 
	
		$logotype = if_get_option( THE_SHORTNAME . '_logo_type');
		$logoimage = if_get_option( THE_SHORTNAME . '_logo_image');
		$sitename =  if_get_option( THE_SHORTNAME . '_site_name');
		$tagline = if_get_option( THE_SHORTNAME . '_tagline');
		
		if($sitename=="") $sitename = get_bloginfo('name');
		if($tagline=="") $tagline = get_bloginfo('description'); 
		if($logoimage == "") $logoimage = get_stylesheet_directory_uri() . "/images/logo.png"; 
?>
		<?php if($logotype == 'textlogo'){ ?>
			
			<h1><a href="<?php echo home_url( '/'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', THE_LANG ) ); ?>"><?php echo $sitename; ?></a></h1><span class="desc"><?php echo $tagline; ?></span>
        
        <?php } else { ?>
        	
            <div id="logoimg">
            <a href="<?php echo home_url( '/' ) ; ?>" title="<?php echo $sitename; ?>" >
                <img src="<?php echo $logoimage ; ?>" alt="<?php echo $sitename; ?>" />
            </a>
            </div>
            
		<?php } ?>
        
<?php 
	}
}

if(!function_exists("if_searchform")){
	function if_searchform($id="", $class=""){
		if(function_exists('is_woocommerce')){
			$outputposttype = '<input type="hidden" name="post_type" value="product" />';
			$searchtext = __('Search product...', THE_LANG );
		}else{
			$outputposttype = '';
			$searchtext = __('Search...', THE_LANG );
		}
		$output = '<div class="'.$class.'">';
			$output .= '<form method="get" id="'.$id.'" class="btntoppanel" action="'. esc_url( home_url( '/' ) ) .'">';
				$output .= '<div class="searcharea">';
					$output .= '<input type="text" name="s" id="s" placeholder="'. $searchtext .'" value="" />';
					$output .= '<input type="submit" class="submit" name="submit" id="searchsubmit" value="" />';
					$output .= $outputposttype;
				$output .= '</div>';
			$output .= '</form>';
		$output .= '</div>';
		
		return $output;
	}
}

if(!function_exists("if_minicart")){
	function if_minicart($id="",$class=""){
		
		global $woocommerce;
		$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
		$link = $woocommerce->cart->get_cart_url();
		
		ob_start();
		the_widget('WC_Widget_Cart', '', array('widget_id'=>'cart-dropdown',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<span class="hidden">',
			'after_title' => '</span>'
		));
		$widget = ob_get_clean();
	
		$output = '<div id="'.$id.'" class="'.$class.'">';
			$output .= '<a class="topcartbutton btnpanel" href="'.$link.'"><span class="cart_subtotal">'.$cart_subtotal.'</span></a>';
			$output .= '<span class="arrowpanel"></span>';
			$output .= '<div class="cartlistwrapper">';
				$output .= $widget;
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

if(!function_exists('if_woocategories')){
	function if_woocategories($id="", $class=""){
		
		global $woocommerce;
		
		$args = array(
			'taxonomy' => 'product_cat',
			'hide_empty' => 0,
			'hierarchical' => 1,
			'title_li' => '<a href="'.get_permalink(woocommerce_get_page_id('shop')).'" class="btnpanel">'.__('All Dept', THE_LANG).'</a><span class="arrowpanel"></span>'
		);
		echo '<ul class="'.$class.'" id="'.$id.'">';
		wp_list_categories($args);
		echo '</ul>';
	}
}

if (!function_exists('if_socialicon')){
	function if_socialicon(){
		
		$socialfolder = get_template_directory_uri() . '/images/social/';
		$optSocialIcons = if_readsocialicon();
		
		$outputli = "";
		for($i=1;$i<=count($optSocialIcons);$i++){
			$socialoption = if_get_option( THE_SHORTNAME . '_socialicon_'.$i, "" );

			if($socialoption['select']!='0'){
				$socialicon = $socialfolder . $socialoption['select'] ;
				$sociallink = $socialoption['text'];
				$outputli .= '<li><a href="'.$sociallink.'" style="background-image:url('.$socialicon.')" target="_blank"><span class="icon-img" style="background-image:url('.$socialicon.')"></span></a></li>'."\n";
			}
		}
		$output = "";
		if($outputli!=""){
			$output .= '<ul class="sn">';
			$output .= $outputli;
			$output .= '</ul>';
		}
		return $output;
	}
}//end if(!function_exists('if_bodyclass'))
if (!function_exists('if_bodyclass')){
	function if_bodyclass(){
		
		$bodyclass = array('interfeis','mugen');
		$boxed_style = if_get_option(THE_SHORTNAME . '_boxed_style');
		if($boxed_style){
			$bodyclass[] = "boxed"; 
		}
		return $bodyclass;
		
	}
}//end if(!function_exists('if_bodyclass'))