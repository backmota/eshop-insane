<?php
function if_portfoliobox( $postid="" ){

	$output = "";
	
	global $post;
	if($postid==""){
		$postid = get_the_ID();
	}
	
	$get_image = if_pf_get_image( 'portfolio-image-col4', $postid );
	extract($get_image);
	
	$output  .='<li>';
		$output .= '<div class="cr-item-container">';
			$output  .='<div class="frameimg">';
				$output  .='<div class="curve-down">';
				
					$output  .='<div class="if-pf-img">';
						$output .='<div class="rollover"></div>';
						$output .='<a class="image '.$rollover.'" href="'.$golink.'" title="'.get_the_title().'"></a>';
						if($bigimageurl!=''){
							$output .='<a class="image zoom" href="'.$bigimageurl.'" '.$rel.' title="'.$bigimagetitle.'"></a>';
						}
						$output  .=$cf_thumb;
						$output  .=$cf_full2;
					$output  .='</div>';
					
				$output  .='</div>';
			$output  .='</div>';
			$output  .='<h3><a href="'.get_permalink($postid).'">'.get_the_title($postid).'</a></h3>';
			$excerpt = if_string_limit_char( get_the_excerpt(),30 );
			$output  .='<div class="if-pf-text">'.$excerpt.'</div>';
		$output .= '</div>';
	$output  .='</li>';
	
	return $output; 
}

function if_pf_get_image($imgsize, $postid=""){

	global $post;
	if($postid==""){
		$postid = get_the_ID();
	}

	$custom = get_post_custom( $postid );
	$cf_thumb = (isset($custom["custom_thumb"][0]))? $custom["custom_thumb"][0] : "";
	$cf_externallink = (isset($custom["external_link"][0]))? $custom["external_link"][0] : "";
	if(isset($custom["lightbox_img"])){
		$checklightbox = $custom["lightbox_img"] ; 
		$cf_lightbox = array();
		for($i=0;$i<count($checklightbox);$i++){
			if($checklightbox[$i]){
				$cf_lightbox[] = $checklightbox[$i];
			}
		}
		if(!count($cf_lightbox)){
			$cf_lightbox = "";
		}
	}else{
		$cf_lightbox = "";
	}
	
	
	/*get recent-portfolio-post-thumbnail*/
	$qrychildren = array(
		'post_parent' => $postid ,
		'post_status' => null,
		'post_type' => 'attachment',
		'order_by' => 'menu_order',
		'order' => 'ASC',
		'post_mime_type' => 'image'
	);

	$attachments = get_children( $qrychildren );
	
	$cf_thumb2 = array();
	$cf_full2 = "";
	$z = 1;
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
		
		if($z==1){
			$fullimageurl = $fullimage;
			$fullimagetitle = $image_title;
			$fullimagealt = $alttext;
		}elseif($att_id == get_post_thumbnail_id( $postid ) ){
			$cf_full2 ='<a data-rel="prettyPhoto['.$post->post_name.']" href="'.$fullimageurl.'" title="'. $fullimagetitle .'" class="hidden"></a>'.$cf_full2;
			$fullimageurl = $fullimage;
			$fullimagetitle = $image_title;
			$fullimagealt = $alttext;
		}else{
			$cf_full2 .='<a data-rel="prettyPhoto['.$post->post_name.']" href="'.$fullimage.'" title="'. $image_title .'" class="hidden"></a>';
		}
		$z++;
	}
	
	if($cf_thumb!=""){
		$cf_thumb = '<img src="' . $cf_thumb . '" alt="'. get_the_title($postid) .'"  class="scale-with-grid" />';
	}elseif( has_post_thumbnail( $postid ) ){
		$cf_thumb = get_the_post_thumbnail($postid, $imgsize, array('class' => 'scale-with-grid'));
	}elseif( isset( $cf_thumb2[0] ) ){
		$cf_thumb = $cf_thumb2[0];
	}else{
		$cf_thumb = '<span class="if-noimage"></span>';
	}
	
	
	if($cf_externallink!=""){
		$golink = $cf_externallink;
		$rollover = "gotolink";
		$cf_full2 = '';
	}else{
		$golink = get_permalink();
		$rollover = "gotopost";
	}
	
	$bigimageurl = '';
	if( is_array($cf_lightbox) ){
		$bigimageurl = $cf_lightbox[0];
		$bigimagetitle = get_the_title();
		$rel = ' data-rel="prettyPhoto['.$post->post_name.']"';
		$cf_lightboxoutput = '';
		for($i=1;$i<count($cf_lightbox);$i++){
			$cf_lightboxoutput .='<a data-rel="prettyPhoto['.$post->post_name.']" href="'.$cf_lightbox[$i].'" title="'. get_the_title($postid) .'" class="hidden"></a>';
		}
		$cf_full2 = $cf_lightboxoutput;
	}else{
		if( isset($fullimageurl)){
			$bigimageurl = $fullimageurl; 
			$bigimagetitle = $fullimagetitle;
			$rel = ' data-rel="prettyPhoto['.$post->post_name.']"';
		}
	}
	
	$return = array(
		'bigimageurl' 	=> $bigimageurl,
		'bigimagetitle'	=> $bigimagetitle,
		'rel'			=> $rel,
		'cf_full2'		=> $cf_full2,
		'golink'		=> $golink,
		'rollover'		=> $rollover,
		'cf_thumb'		=> $cf_thumb
	);
	return $return;
}

function if_pf_get_box( $imgsize, $postid="",$class="", $limitchar = 250 ){

	$output = "";
	global $post;
	
	if($postid==""){
		$postid = get_the_ID();
	}
	
	$get_image = if_pf_get_image($imgsize, $postid );
	extract($get_image);
	
	$output  .='<li class="'.$class.'">';
		$output  .='<div class="frameimg">';
			$output  .='<div class="curve-down">';
			
			$output  .='<div class="if-pf-img">';
				$output .='<div class="rollover"></div>';
				
				$output .='<a class="image '.$rollover.'" href="'.$golink.'" title="'.get_the_title($postid).'"></a>';
				if($bigimageurl!=''){
					$output .='<a class="image zoom" href="'.$bigimageurl.'" '.$rel.' title="'.$bigimagetitle.'"></a>';
				}
				
				$output  .=$cf_thumb;
				$output  .=$cf_full2;
			$output  .='</div>';
			
			$output  .='</div>';
		$output  .='</div>';
		
		$excerpt = if_string_limit_char( get_the_excerpt(), $limitchar );
		$output  .='<div class="if-pf-text">';
		
			$output  .='<h2><a href="'.get_permalink($postid).'" title="'.get_the_title($postid).'">'.get_the_title($postid).'</a></h2>';
			$output .= '<div>'.$excerpt.'</div>';
			
		$output  .='</div>';
		$output  .='<div class="if-pf-clear"></div>';
	$output  .='</li>';
	
	return $output; 
}

/*********QUICK VIEW PRODUCT**********/
add_action("wp_ajax_if_quickviewproduct", "if_quickviewproduct");
add_action("wp_ajax_nopriv_if_quickviewproduct", "if_quickviewproduct");
function if_quickviewproduct(){
	
	if( !wp_verify_nonce( $_REQUEST['nonce'], "if_quickviewproduct_nonce")) {
    	exit("No naughty business please");
	}
	
	$productid = (isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]>0)? $_REQUEST["post_id"] : 0;
	
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 

		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			global $product;
			ob_start();
			woocommerce_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}// end if ($r->have_posts())
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	echo $output;
}