<?php
/* Recent Posts */
if( !function_exists('if_recentposts') ){
	function if_recentposts($atts, $content = null) {
		extract(shortcode_atts(array(
					"title" => '',
					"cat" => '',
					"cols" => '3',
					"showposts" => '3',
					'limitchar' => 110
		), $atts));
			
		if($content){
			$content = if_content_formatter($content);
		}
		$output  ='<div class="recentposts">';
		if($title!=""){
			$output  .='<div class="titlecontainer"><h3><span>'.$title.'</span></h3></div>';
		}
		if($content){
			$output .='<div class="pc-content">'.$content.'</div><div class="clearfix"></div>';
		}
		
		$cols = intval($cols);
		if(($cols<1 || $cols>4)){
			$cols = 3;
		}
		if($cols==1){
			$colclass = 'twelve';
		}elseif($cols==2){
			$colclass = 'six';
		}elseif($cols==4){
			$colclass = 'three';
		}else{
			$colclass = 'four';
		}
		$colclass .= ' columns';

		$i=1;
		$argquery = array(
			'showposts' => $showposts
		);
		if($cat){
			$argquery['category_name'] = $cat;
		}
		query_posts($argquery);
		global $post;
		
		$output  .='<div class="row">';
			
			$havepost = false;
			while (have_posts()) : the_post();
			$havepost = true;
			$excerpt = get_the_excerpt();
			$custom = get_post_custom( get_the_ID() );
			$cthumb = (isset($custom["image_url"][0]) && $custom["image_url"][0]!="")? $custom["image_url"][0] : "";
			
			/*get recent-portfolio-post-thumbnail*/
			$qrychildren = array(
				'post_parent' => get_the_ID(),
				'post_status' => null,
				'post_type' => 'attachment',
				'order_by' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image'
			);

			$attachments = get_children( $qrychildren );
			
			$cf_thumb2 = array();
			$z = 1;
			foreach ( $attachments as $att_id => $attachment ) {
				$getimage = wp_get_attachment_image_src($att_id, 'portfolio-image-col4', true);
				$portfolioimage = $getimage[0];
				$alttext = get_post_meta( $attachment->ID , '_wp_attachment_image_alt', true);
				$image_title = $attachment->post_title;
				$caption = $attachment->post_excerpt;
				$description = $attachment->post_content;
				$cf_thumb2[] =array(
					'image' => $portfolioimage,
					'alt' => $alttext,
					'title' => $image_title
				);
				
				$z++;
			}
			
			$thumbid = get_post_thumbnail_id( get_the_ID() );
			$alttext = get_post_meta($thumbid, '_wp_attachment_image_alt', true);
			$imagesrc = wp_get_attachment_image_src( $thumbid, 'portfolio-image-col3' );
			
			if($cthumb!=""){
				$imagethumb = $cthumb;
				$alttext = get_the_title( get_the_ID() );
			}else{
				if($imagesrc!=false){
					$imagethumb = $imagesrc[0];
				}elseif( count($cf_thumb2)>0 ){
					$imagethumb = $cf_thumb2[0]['image'];
					$alttext = $cf_thumb2[0]['alt'];
				}else{
					$imagethumb = "";
					$limitchar = 270;
				}
			}
			
			$output  .='<div class="'.$colclass.'">';
				$output .= '<div class="post-container">';
					if($imagethumb!=""){
						$output .= '<div class="image-container">';
							$output  .='<a href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.$imagethumb.'" alt="'.$alttext.'" /></a>';
						$output .= '</div>';
					}
					$output  .='<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
					$excerpt = if_string_limit_char( get_the_excerpt(), $limitchar );
					$output  .='<div class="meta-date"><span class="icon-calendar">'. get_the_time('F d, Y', get_the_ID()) .'</span></div>';
					$output  .='<div class="entry-text">'.$excerpt.'</div>';
				$output .= '</div>';
			$output  .='</div>';
			
			$i++; $addclass=""; endwhile; wp_reset_query();

		 $output .='</div>';
		 $output .='</div>';
		 if($havepost){
			return do_shortcode($output);
		}else{
			return false;
		}
	}
}
?>