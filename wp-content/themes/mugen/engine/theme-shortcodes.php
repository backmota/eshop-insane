<?php
/* NATIVE SHORTCODE */
add_shortcode( 'recent_posts', 'if_recentposts' );

/******PRODUCT SHORTCODE******/
if(!function_exists('if_productbox')){
	function if_productbox($postobj){
		
		global $post, $product, $woocommerce;
		
		setup_postdata($postobj);
		
		$licontent = "";
		$licontent .= '<div class="pcontainer">';
			$licontent .= '<div class="imgbox"><div class="curve-down">';
				$licontent .= '<a href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="imglink">';
				
				if ($product->is_on_sale()){
					$licontent .= apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'woocommerce' ).'</span>', $post, $product);
				}
		
				$licontent .= woocommerce_get_product_thumbnail();
				
				$licontent .= '</a>';
		
				if ( ! $product->is_in_stock() ){
				
					$licontent .='<a href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="button btndetail onebutton"><em class="icon-eye"></em> '.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', THE_LANG ) ).'</a>';
					
				}else{
					
					$link = array(
						'url'   => '',
						'label' => '',
						'class' => ''
					);
			
					$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );
					$onebutton = false;
					switch ( $handler ) {
						case "variable" :
							$link['url'] 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
							$link['label'] 	= apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) );
							$link['class']  = apply_filters( 'add_to_cart_class', 'select_button' );
							$link['emclass']  = apply_filters( 'add_to_cart_em_class', 'icon-if-list' );
						break;
						case "grouped" :
							$link['url'] 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
							$link['label'] 	= apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
							$link['class']  = apply_filters( 'add_to_cart_class', 'select_button' );
							$link['emclass']  = apply_filters( 'add_to_cart_em_class', 'icon-if-list' );
						break;
						case "external" :
							$link['url'] 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
							$link['label'] 	= apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) );
							$link['class']  = apply_filters( 'add_to_cart_class', 'external_button onebutton' );
							$link['emclass']  = apply_filters( 'add_to_cart_em_class', 'icon-if-link' );
							$onebutton = true;
						break;
						default :
							if ( $product->is_purchasable() ) {
								$link['url'] 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
								$link['label'] 	= apply_filters( 'add_to_cart_text', __( 'Add to cart', 'woocommerce' ) );
								$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
								$link['emclass']  = apply_filters( 'add_to_cart_em_class', 'icon-if-addtocart' );
							} else {
								$link['url'] 	= apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
								$link['label'] 	= apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) );
								$link['class']  = apply_filters( 'add_to_cart_class', 'btndetail onebutton' );
								$link['emclass']  = apply_filters( 'add_to_cart_em_class', 'icon-if-detail' );
								$onebutton = true;
							}
						break;
					}
					
					$licontent .= apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s button product_type_%s"><em class="%s"></em> %s</a>', esc_url( $link['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->product_type ), esc_attr($link['emclass']), esc_html( $link['label'] ) ), $product, $link );
						
					if(!$onebutton){
						/*
						$licontent .='<a href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="btm button btndetail"><em class="icon-eye"></em>'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Details', THE_LANG ) ).'</a>';
						*/
						/*
						$licontent .='<a href="#quickview-container-'. $product->id .'" data-rel="quickview" class="btm button btndetail"><em class="icon-if-quickview"></em>'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', THE_LANG ) ).'</a>';
						*/
						$nonce = wp_create_nonce("if_quickviewproduct_nonce");
						$link = admin_url('admin-ajax.php?ajax=true&action=if_quickviewproduct&post_id='.$product->id.'&nonce='.$nonce);
						$licontent .='<a href="'. $link .'" data-rel="quickview" class="btm button btndetail"><em class="icon-if-quickview"></em>'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', THE_LANG ) ).'</a>';
					}
				}

			
			
				$licontent .= '<div class="ptext">';
					$licontent .= '<h3><a href="'. get_permalink().'">'.get_the_title().'</a></h3>';
					
					if ( get_option( 'woocommerce_enable_review_rating' ) != 'no' ){
						if ( $rating_html = $product->get_rating_html() ){
							$licontent .= $rating_html;
						}else{
							$licontent .='<div class="star-rating" title="'.__( 'Rated 0 out of 5', 'woocommerce' ).'">';
								$licontent .='<span style="width:0%;">';
									$licontent .='<strong class="rating">0.00</strong> out of 5';
								$licontent .='</span>';
							$licontent .='</div>';
						}
					}
					
					if ( $price_html = $product->get_price_html() ){
						$licontent .='<span class="price">'.$price_html.'</span>';
					}
					$licontent .= '<div class="clearfix"></div>';
				$licontent .= '</div>';
			
			$licontent .= '</div></div>'; 
			
			$licontent .= '<div class="hidden">';
				/*ob_start();
				woocommerce_get_template_part( 'content', 'quickview-product' );
				$licontent .= ob_get_contents();
				ob_end_clean();*/
			$licontent .= '</div>';
			
		$licontent .= '</div>';
		
		
		return $licontent;
	}
}

if(!function_exists('if_productquery')){
	function if_productquery($number=12, $type){
		global $woocommerce;
		
		if(!is_numeric($number) || $number < 1){
			$number = 12;
		}
		
		if($type == 'featured'){
			/**********QUERY FOR FEATURED PRODUCT**********/
			$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
		
			$query_args['meta_query'] = array();
		
			$query_args['meta_query'][] = array(
				'key' => '_featured',
				'value' => 'yes'
			);
			$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
			$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
			/**********END QUERY FOR FEATURED PRODUCT**********/
		}elseif($type == 'top-rated'){
			/**********QUERY FOR TOP-RATED PRODUCT**********/
			add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
		
			$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
		
			$query_args['meta_query'] = array();
		
			$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
			$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
			/**********END QUERY FOR TOP-RATED PRODUCT**********/
		}elseif($type == 'best-selling'){
			/**********QUERY FOR BEST SELLING PRODUCT**********/
			$query_args = array(
				'posts_per_page' => $number,
				'post_status' 	 => 'publish',
				'post_type' 	 => 'product',
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',
				'no_found_rows'  => 1,
			);
		
			$query_args['meta_query'] = array();
		
			if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}
		
			$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
			$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
			/**********END QUERY FOR BEST SELLING PRODUCT**********/
		}
		
		return $query_args;
	}
}


if(!function_exists('if_productfilter')){
	function if_productfilter($atts, $content = null) {
		extract(shortcode_atts(array(
					"title" => '',
					"id" => '',
					"class" => '',
					"type" => 'featured',
					"showposts" => '12',
					"col" => 4
		), $atts));
		
		$col = intval($col);
		if($col<3 || $col>4){
			$col = 4;
		}
		
		if($type!='featured' && $type!='top-rated' && $type!='best-selling'){
			$type = 'featured';
		}
		
		$contentformatted = "";
		if($content){
			$contentformatted = if_content_formatter($content);
		}
		global $woocommerce, $woocommerce_loop;
		
		$woocommerce_loop['columns'] = $col;

		$number = (int) $showposts;
		if ( !is_numeric($number)){
			$number = 12;
		}elseif ( $number < 1 ){
			$number = 1;
		}elseif ( $number > 24 ){
			$number = 24;
		}
		
		$query_args = if_productquery($number, $type);
		
		$r = new WP_Query($query_args);
		$output = $content = "";
		$allterms = array();
		if ($r->have_posts()){ 

			while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
				global $product;
				
				// Store loop count we're currently on
				if ( empty( $woocommerce_loop['loop'] ) )
					$woocommerce_loop['loop'] = 0;
				
				// Store column count for displaying the grid
				if ( empty( $woocommerce_loop['columns'] ) )
					$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
				
				// Ensure visibilty
				if ( ! $product->is_visible() )
					continue;
				
				// Increase loop count
				$woocommerce_loop['loop']++;
				
				if($woocommerce_loop['columns']==4){
					$colclass = "three columns";
				}else{
					$colclass = "four columns";
				}
				
				$ptermsobj = get_the_terms($product->id,'product_cat');
				$pterms = "";
				if(!is_wp_error($ptermsobj) && $ptermsobj!=false){
					$ptermsarr = array();
					foreach($ptermsobj as $ptermobj){
						$ptermsarr[] = $ptermobj->slug;
						if(!in_array($ptermobj->slug, $allterms)){
							$allterms[] = $ptermobj->slug;
						}
					}
					if(count($ptermsarr)) $pterms = implode(" ",$ptermsarr);
				}
					
				$content .= '<div class="product element '.$pterms.' '.$colclass.'">';
					$content .= if_productbox($r->post);
				$content .= '</div>';

            }
			
		} /* end if($r->have_posts()) */
		
		$output .= '<div id="'.$id.'" class="pfilter_container '.$class.' woocommerce">';
			
			$titleoutput = "";
			if($title!=""){
				$titleoutput .= '<h3 class="contenttitle"><span>'.$title.'</span></h3>';
			}
			
			if(count($allterms)>0){
				$titleoutput .= '<div class="filterlist"><a class="filterbutton" href="#filter">'. __('All Categories', THE_LANG ).'</a><span class="sf-sub-indicator"></span>';
				$titleoutput .= '<div class="sub-arrow"></div>';
				$titleoutput .= '<ul class="isotope-filter option-set clearfix " data-option-key="filter">';
					$filtersli = '';
					$numli = 1;
					foreach($allterms as $theterm){
						$termobj = get_term_by("slug", $theterm, 'product_cat');
						if($numli==1){
							$liclass = 'omega';
						}else{
							$liclass = '';
						}
						$filtersli = '<li class="'.$liclass.'"><a href="#filter" data-option-value=".'.$termobj->slug.'">'.$termobj->name.'</a></li>'.$filtersli;
						$numli++;
					}
					$filtersli = '<li><a href="#filter" data-option-value="*">'. __('All Categories', THE_LANG ).'</a></li>'.$filtersli;
					$titleoutput .= $filtersli;
				$titleoutput .= '</ul>';
				$titleoutput .= '</div>';
			}
			
			if($titleoutput!=""){
				$output .= '<div class="titlecontainer">';
					$output .= $titleoutput;
					$output .= '<div class="clearfix"></div>';
				$output .= '</div>';
			}
			
			$output .= '<div class="product_filter row">';
				$output .= '<div class="products isotope">';
					$output .= $content;
				$output .= '</div>';
			$output .= '</div>';
			
		$output .= '</div>';
		
        wp_reset_postdata();
		
		return trim( do_shortcode( shortcode_unautop( $output ) ) );
	}
	
	add_shortcode( 'product_filter', 'if_productfilter' );
}

/******PRODUCT CAROUSEL******/
if(!function_exists('if_productcarousel')){
	function if_productcarousel($atts, $content = null) {
		extract(shortcode_atts(array(
					"title" => '',
					"class" => '',
					"type" => 'featured',
					"showposts" => '-1'
		), $atts));
		
			if($type!='featured' && $type!='top-rated' && $type!='best-selling'){
				$type = 'featured';
			}
			
			$output  ='<div class="pcarousel '.$class.' woocommerce">';
			if($title!=""){
			$output  .='<div class="titlecontainer"><h3 class="contenttitle"><span>'.$title.'</span></h3></div>';
			}
			
			global $woocommerce, $woocommerce_loop;
	
			$number = (int) $showposts;
			if ( !is_numeric($number) || $number < 1){
				$number = -1;
			}
			
			$query_args = if_productquery($number, $type);
	
			$r = new WP_Query($query_args);
			$licontent = "";
			$allterms = array();
			$havepost = false;
			if ($r->have_posts()){ 
				$havepost = true;
				while ($r->have_posts()){ $r->the_post();
					global $product;
					
					$colclass = "";
					
					$licontent .= '<li class="product '.$colclass.'">';
						$licontent .= if_productbox($r->post);
					$licontent .= '</li>';
	
				}
				
			} /* end if($r->have_posts()) */
			wp_reset_postdata();
			
			$output  .='<div class="flexslider-carousel row">';
				$output  .='<ul class="slides products">';
				
				$output .= $licontent;
				 
				$output .='</ul>';
			$output .='</div>';
			$output .='</div>';
			
			if($havepost){
				return $output;
			}else{
				return false;
			}
	}
	
	add_shortcode( 'product_carousel', 'if_productcarousel' );
}

/******PORTFOLIO CAROUSEL******/
if(!function_exists('if_portfoliocarousel')){
	function if_portfoliocarousel($atts, $content = null) {
		extract(shortcode_atts(array(
					"title" => '',
					"class" => '',
					"cat" => '',
					"showposts" => '-1'
		), $atts));
			
			if($content){
				$content = if_content_formatter($content);
			}
			$output  ='<div class="pcarousel '.$class.' pf">';
			if($title!=""){
			$output  .='<div class="titlecontainer"><h3 class="contenttitle"><span>'.$title.'</span></h3></div>';
			}
			if($content){
				$output .='<div class="pc-content">'.$content.'</div><div class="clearfix"></div>';
			}
	
			$i=1;
			$argquery = array(
				'post_type' => 'portofolio',
				'showposts' => $showposts
			);
			if($cat){
				$argquery['tax_query'] = array(
					array(
						'taxonomy' => 'portfoliocat',
						'field' => 'slug',
						'terms' => $cat
					)
				);
			}
			query_posts($argquery);
			global $post;
			
			$output  .='<div class="flexslider-carousel row">';
				$output  .='<ul class="slides">';
				
				$havepost = false;
				while (have_posts()) : the_post();
				$havepost = true;
				$excerpt = get_the_excerpt(); 
				
					$output .= if_portfoliobox( get_the_ID() );
				
				 	$i++; $addclass=""; endwhile; wp_reset_query();
				 
				 $output .='</ul>';
			 $output .='</div>';
			 $output .='</div>';
			 if($havepost){
			 	return do_shortcode($output);
			}else{
				return false;
			}
	}
	
	add_shortcode( 'portfolio_carousel', 'if_portfoliocarousel' );
}

/******BRAND CAROUSEL******/
if(!function_exists('if_brandcarousel')){
	function if_brandcarousel($atts, $content = null) {
		extract(shortcode_atts(array(
					"title" => '',
					"class" => '',
					"cat" => '',
					"showposts" => '-1'
		), $atts));
			
			if($content){
				$content = if_content_formatter($content);
			}

			$output  ='<div class="pcarousel brand '.$class.'">';
			if($title!=""){
				$output .='<div class="titlecontainer"><h3 class="contenttitle"><span>'.$title.'</span></h3></div>';
			}
			
			$i=1;
			$argquery = array(
				'post_type' => 'brand',
				'showposts' => $showposts
			);
			if($cat){
				$argquery['tax_query'] = array(
					array(
						'taxonomy' => 'brandcat',
						'field' => 'slug',
						'terms' => $cat
					)
				);
			}
			query_posts($argquery);
			global $post;
			
			$output  .='<div class="flexslider-carousel row">';
				$output  .='<ul class="slides">';
				
				$havepost = false;
				while (have_posts()) : the_post();
				$havepost = true;
				$excerpt = get_the_excerpt(); 
				$postid = get_the_ID();
				$custom = get_post_custom( $postid );
				$cthumb = (isset($custom["carousel_thumb"][0]))? $custom["carousel_thumb"][0] : "";
				
				$thumbid = get_post_thumbnail_id( $postid );
				$alttext = get_post_meta($postid, '_wp_attachment_image_alt', true);
				$imagesrc = wp_get_attachment_image_src( $thumbid, 'brand-image' );
				
				if($cthumb!=""){
					$imagethumb = $cthumb;
					$alttext = get_the_title( $postid );
				}else{
					if($imagesrc!=false){
						$imagethumb = $imagesrc[0];
					}else{
						$imagethumb = get_template_directory_uri().'/images/noimage.png';
						$alttext = get_the_title( $postid );
					}
				}
				
				$output  .='<li>';
					$output .= '<div class="cr-item-container">';
						$output  .='<img src="'.$imagethumb.'" alt="'.$alttext.'" />';
					$output .= '</div>';
				$output  .='</li>';
				
				$i++; $addclass=""; endwhile; wp_reset_query();
				 
				$output .='</ul>';
			 $output .='</div>';
			 $output .='</div>';
			 if($havepost){
			 	return do_shortcode($output);
			}else{
				return false;
			}
	}
	
	add_shortcode( 'brand_carousel', 'if_brandcarousel' );
}

/******BIGTEXT******/
if(!function_exists('if_bigtext')){
	function if_bigtext($atts, $content = null) {
		extract(shortcode_atts(array(
		), $atts));
		$output = '<h2 class="bigtext"><span>'.$content.'</span></h2>';
		return do_shortcode($output);
	}
	add_shortcode( 'bigtext', 'if_bigtext' );
}
/******SECONDARYTEXT******/
if(!function_exists('if_secondarytext')){
	function if_secondarytext($atts, $content = null) {
		extract(shortcode_atts(array(
		), $atts));
		$output = '<span class="secondarytext">'.$content.'</span>';
		return do_shortcode($output);
	}
	add_shortcode( 'secondarytext', 'if_secondarytext' );
}

/******HEADING******/
if(!function_exists('if_heading')){
	function if_heading($atts, $content = null) {
		extract(shortcode_atts(array(
			'level' => '3',
			'align' => 'left',
			'class' => ''
		), $atts));
		
		$arrH = array('1','2','3','4','5','6');
		$arrA = array('left','center','right');
		if(!in_array($level,$arrH)){
			$level = 3;
		}
		if(!in_array($align,$arrA)){
			$align = 'left';
		}
		$output = '<div class="if-heading"><h'.$level.' class="'.$align.'"><span class="'.$class.'">'.$content.'</span></h'.$level.'></div>';
		return do_shortcode($output);
	}
	add_shortcode( 'heading', 'if_heading' );
}

/******SOCIAL ICON******/
if(!function_exists('if_socialshortcode')){
	function if_socialshortcode($atts, $content = null) {
		
		$output = if_socialicon();
		return do_shortcode($output);
	}
	add_shortcode( 'social_icon', 'if_socialshortcode' );
}

/******IMAGEBOX******/
if(!function_exists('if_imageboxed')){
	function if_imageboxed($atts, $content = null) {
		extract(shortcode_atts(array(
			'url' => '#'
		), $atts));
		
		$output = '<div class="imgbox"><div class="curve-down"><a href="'.$url.'">'.$content.'</a></div></div>';
		return do_shortcode($output);
	}
	add_shortcode( 'imgbox', 'if_imageboxed' );
}

if(!function_exists('if_frameimage')){
	function if_frameimage($atts, $content = null) {
		extract(shortcode_atts(array(
			'src' => '',
			'class' => '',
			'alt' => ''
		), $atts));
		
		$output = "";
		if($src!=""){
			$output = '<div class="frameimg '.$class.'"><div class="curve-down"><div class="if-pf-img"><img src="'.$src.'" alt="'.$alt.'" /></div></div></div>';
		}
		return do_shortcode($output);
	}
	add_shortcode( 'frameimg', 'if_frameimage' );
}

/******SLIDER******/
if(!function_exists('if_sliders')){
	function if_sliders($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' => '',
			'title' => '',
		), $atts));
		if($id!=""){
			$ids = 'id="'.$id.'" ';
		}else{
			$ids = '';
		}
		$output  = '<div '.$ids.' class="minisliders flexslider">';
		
		if($title!=""){
			$output  .='<div class="titlecontainer"><h2 class="contenttitle"><span>'.$title.'</span></h2></div>';
		}
		
		$output	.= '<ul class="slides">';
		$output	.= $content;
		$output	.= '</ul>';
		$output	.= '<div class="clearfix"></div>';
		$output .= '</div>';
		return do_shortcode($output);
	}
	add_shortcode( 'sliders', 'if_sliders' );
}
if(!function_exists('if_slide')){
	function if_slide($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' 	=> '',
			'class'	=> ''
		), $atts));
		if($id!=""){
			$ids = 'id="'.$id.'" ';
		}else{
			$ids = '';
		}
		$classes = 'class="slide '.$class.'" ';
		
		$output  = '<li '.$ids.$classes.'>';
		$output	.= $content;
		$output	.= '</li>';
		return do_shortcode($output);
	}
	add_shortcode( 'slide', 'if_slide' );
}

if(!function_exists('if_testimonial')){
	function if_testimonial($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' 	=> '',
			'class'	=> '',
			'col' => '1',
			'cat' => '',
			'showposts' => 5,
			'showtitle' => 'yes',
			'showinfo' => 'yes',
			'showthumb' => 'yes'
		), $atts));
		
		$catname = get_term_by('slug', $cat, 'testimonialcat');
		$showtitle = ($showtitle=='yes')? true : false;
		$showinfo = ($showinfo=='yes')? true : false;
		$showthumb = ($showthumb=='yes')? true : false;
		$showposts = (is_numeric($showposts))? $showposts : 5;
		
		if($col!='1' && $col!='2' && $col!='3'){
			$col = '1';
		}
		
		if($col=='3'){
			$col = 3;
		}elseif($col=='2'){
			$col = 2;
		}else{
			$col = 1;
		}
		
		$qryargs = array(
			'post_type' => 'testimonialpost',
			'showposts' => $showposts
		);
		if($catname!=false){
			$qryargs['tax_query'] = array(
				array(
					'taxonomy' => 'testimonialcat',
					'field' => 'slug',
					'terms' => $catname->slug
				)
			);
		}
		
		query_posts( $qryargs ); 
		global $post;
		
		$output = "";
		if( have_posts() ){
			$output .= '<div class="if-testimonial '.$class.'">';
			$output .= '<ul class="row">';
			$i = 1;
			while ( have_posts() ) : the_post(); 
				
				if($col==3){
					$liclass = 'four columns';
				}elseif($col==2){
					$liclass = 'six columns';
				}else{
					$liclass = '';
				}
				
				$custom = get_post_custom($post->ID);
				$testiinfo 	= (isset($custom["testi_info"][0]))? $custom["testi_info"][0] : "";
				$testithumb = (isset($custom["testi_thumb"][0]))? $custom["testi_thumb"][0] : "";
				
				if($i%$col==0 && $col>1){
					$liclass .= ' last';
				}
				if($i%$col==1 && $col>1){
					$output .= '<li class="clearfix"></li></ul><ul class="row">';
				}
				
				$output .= '<li class="'.$liclass.'">';
				
				if($showthumb){
					$output .='<div class="testiimg">';
					$output .='<img src="'.$testithumb.'" width="70" height="70" alt="'.get_the_title( $post->ID ).'" title="'. get_the_title( $post->ID ) .'" class="scale-with-grid" />';
					$output .='<span class="insetshadow"></span>';
					$output .='</div>';
					
					$bqclass="";
				}else{
					$bqclass="nomargin";
				}
				
				$output .= '<blockquote class="'.$bqclass.'">'.get_the_content();
				
				if($showtitle || $showinfo){
					$output .= '<span class="testiinfo">';
					if($showtitle){
						$output .= get_the_title( $post->ID );
					}
					if($testiinfo){
						$output .= ' - '.$testiinfo;
					}
					$output .= '</span>';
				}
				$output .= '</blockquote>';
				$output .= '<div class="clearfix"></div>';
				$output .= '</li>';
				
				$i++;
			endwhile;
			$output .= '</ul>';
			$output .= '<div class="clearfix"></div>';
			$output .= "</div>";
		}else{
			$output .= '<!-- no testimonial post -->';
		}
		wp_reset_query();
		
		return do_shortcode($output);
	}
	add_shortcode( 'testimonial', 'if_testimonial' );
}

if(!function_exists('if_rotatingtestimonial')){
	function if_rotatingtestimonial($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' 	=> '',
			'class'	=> '',
			'cat' => '',
			'title' => '',
			'showposts' => 5,
			'showtitle' => 'yes',
			'showinfo' => 'yes',
			'showthumb' => 'yes'
		), $atts));
		
		$catname = get_term_by('slug', $cat, 'testimonialcat');
		$showtitle = ($showtitle=='yes')? true : false;
		$showinfo = ($showinfo=='yes')? true : false;
		$showthumb = ($showthumb=='yes')? true : false;
		$showposts = (is_numeric($showposts))? $showposts : 5;
		
		$qryargs = array(
			'post_type' => 'testimonialpost',
			'showposts' => $showposts
		);
		if($catname!=false){
			$qryargs['tax_query'] = array(
				array(
					'taxonomy' => 'testimonialcat',
					'field' => 'slug',
					'terms' => $catname->slug
				)
			);
		}
		
		query_posts( $qryargs ); 
		global $post;
		
		$output = '';
		if( have_posts() ){
			$output .= '<div class="if-trotating '.$class.'">';
			if($title!=""){
				$output .= '<div class="if-trotating-title"><h3><span>'.$title.'</span></h3></div>';
			}
				$output .= '<div class="flexslider">';
					$output .= '<ul class="slides">';
						while ( have_posts() ) : the_post(); 
							$custom = get_post_custom($post->ID);
							$testiinfo 	= (isset($custom["testi_info"][0]))? $custom["testi_info"][0] : "";
							$testithumb = (isset($custom["testi_thumb"][0]))? $custom["testi_thumb"][0] : "";
							
							$output .= '<li>';
								$output .= '<blockquote>'.get_the_content().'<span class="arrowbubble"></span></blockquote>';
								$output .= '<div class="clearfix"></div>';
								
								if($showthumb){
									$output .='<span class="testiimg">';
									$output .='<img src="'.$testithumb.'" width="70" height="70" alt="'.get_the_title( $post->ID ).'" title="'. get_the_title( $post->ID ) .'" class="scale-with-grid" />';
									$output .='<span class="insetshadow"></span>';
									$output .='</span>';
								}
								if($showtitle || $showinfo){
									$output .= '<span class="testiinfo">';
									if($showtitle){
										$output .= '<strong>'.get_the_title( $post->ID ).'</strong>';
									}
									if($testiinfo){
										$output .= '<br/>'.$testiinfo;
									}
									$output .= '</span>';
								}
								$output .= '<div class="clearfix"></div>';
							$output .= '</li>';
							
						endwhile;
					$output .= '</ul>';
					$output .= '<div class="clearfix"></div>';
				$output .= "</div>";
				$output .= '<div class="clearfix"></div>';
			$output .= "</div>";
		}else{
			$output .= '<!-- no testimonial post -->';
		}
		wp_reset_query();
		
		return do_shortcode($output);
	}
	add_shortcode( 'testimonial360', 'if_rotatingtestimonial' );
}

if(!function_exists('if_featuredslider')){
	function if_featuredslider($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' => '',
			'class' => 'minisliders',
			'moreproperties' => ''
		), $atts));
		
		global $post;
		
		if($id!=""){
			$ids = 'id="'.$id.'" ';
			$theid = $id;
		}else{
			$ids = 'id="'.$post->ID.'" ';
			$theid = $post->ID;
		}
		
		$qrychildren = array(
			'post_parent' => $theid,
			'post_status' => null,
			'post_type' => 'attachment',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_mime_type' => 'image'
		);

		$attachments = get_children( $qrychildren );
		$imgsize = "portfolio-image-col2";
		$cf_thumb2 = array(); $cf_full2 = "";
		
		foreach ( $attachments as $att_id => $attachment ) {
			$getimage = wp_get_attachment_image_src($att_id, $imgsize, true);
			$portfolioimage = $getimage[0];
			$alttext = get_post_meta( $attachment->ID , '_wp_attachment_image_alt', true);
			$image_title = $attachment->post_title;
			$caption = $attachment->post_excerpt;
			$description = $attachment->post_content;
			$cf_thumb2[] ='<img src="'.$portfolioimage.'" alt="'.$alttext.'" title="'. $image_title .'" class="scale-with-grid" />';
			
			$getfullimage = wp_get_attachment_image_src($att_id, 'full', true);
			$fullimage = $getfullimage[0];
			
			$cf_full2 .='<li class="slide" id="'.$att_id.'"><img src="'.$fullimage.'" alt="'.$alttext.'" title="'. $image_title .'" /></li>';
		}
		
		$output  = '<div '.$ids.' class="'.$class.' flexslider" '.$moreproperties.'>';
		$output	.= '<ul class="slides">';
		$output	.= $cf_full2;
		$output	.= '</ul>';
		$output	.= '</div>';
		return $output;
	}
	add_shortcode( 'featuredslider', 'if_featuredslider' );
}

if(!function_exists('if_featuredgallery')){
	function if_featuredgallery($atts, $content = null) {
		extract(shortcode_atts(array(
			'id' => '',
			'class' => '',
			'column' => '4',
			'moreproperties' => ''
		), $atts));
		
		global $post;
		
		if($id!=""){
			$ids = 'id="'.$id.'" ';
			$theid = $id;
		}else{
			$ids = 'id="'.$post->ID.'" ';
			$theid = $post->ID;
		}
		
		$qrychildren = array(
			'post_parent' => $theid,
			'post_status' => null,
			'post_type' => 'attachment',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_mime_type' => 'image'
		);
		
		$column = intval($column);
		if($column!= 2 && $column!= 3 && $column!= 4 ){
			$column = 4;
		}

		$attachments = get_children( $qrychildren );
		
		$typecol = "if-pf-col-".$column;
		$imgsize = "portfolio-image-col".$column;
		
		$lipf = "";
		$idnum = 0;
		foreach ( $attachments as $att_id => $attachment ) {
			$getimage = wp_get_attachment_image_src($att_id, $imgsize, true);
			$portfolioimage = $getimage[0];
			$alttext = get_post_meta( $attachment->ID , '_wp_attachment_image_alt', true);
			$image_title = $attachment->post_title;
			$caption = $attachment->post_excerpt;
			$description = $attachment->post_content;
			$cf_thumb ='<img src="'.$portfolioimage.'" alt="'.$alttext.'" title="'. $image_title .'" class="scale-with-grid" />';
			
			$getfullimage = wp_get_attachment_image_src($att_id, 'full', true);
			$fullimage = $getfullimage[0];
			
			if(($idnum%$column) == 0 && $idnum>0 ){ 
				$lipf .='<li class="pf-clear"></li></ul><ul class="'.$typecol.'">';
			}
			
			if($column==2){
				$classpf = 'six columns ';
			}elseif($column==3){
				$classpf = 'four columns ';
			}else{
				$classpf = 'three columns ';
			}
			
			$rel = " ";

			if((($idnum+1)%$column) == 0 && $idnum>0){$classpf .= "last";}else{$classpf .= "";}
			
			$lipf .='<li class="'.$classpf.'">';
			$lipf .='<div class="if-pf-img">';
				$lipf .='<a href="'.$fullimage.'" data-rel="prettyPhoto['.$theid.']" title="'.$image_title.'">'.$cf_thumb.'</a>';
			$lipf .='</div>';
			$lipf .='</li>';
			
			$idnum++;
		}
		
		$output  = '<div '.$ids.' class="'.$class.' if-pf-container" '.$moreproperties.'>';
		$output	.= '<ul class="'.$typecol.'">';
		$output	.= $lipf;
		$output	.= '<li class="pf-clear"></li></ul>';
		$output	.= '</div>';
		return $output;
	}
	add_shortcode( 'featuredgallery', 'if_featuredgallery' );
}
// Actual processing of the shortcode happens here
function if_pre_shortcode( $content ) {
    global $shortcode_tags;
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
 
add_filter( 'the_content', 'if_pre_shortcode', 7 );