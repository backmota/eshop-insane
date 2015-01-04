<?php
$sliderarrange = if_get_option( THE_SHORTNAME . '_slider_arrange');
$sliderDisableText = if_get_option( THE_SHORTNAME . '_slider_disable_text');

$headerText = stripslashes(if_get_option( THE_SHORTNAME . '_header_text',''));
$disable_topsearch = if_get_option(THE_SHORTNAME . '_disable_topsearch');
$socialiconoutput = if_socialicon();
if($headerText=="" && $disable_topsearch==true && $socialiconoutput==""){
	$emptyclass = "empty";
}else{
	$emptyclass = "";
}

$prefix = 'if_';
					
if( is_home() ){
	$pid = get_option('page_for_posts');
}else{
	$pid = get_the_ID();
}

$custom = if_get_customdata($pid);
$cf_sliderCategory 	= (isset($custom["slider_category"][0]))? $custom["slider_category"][0] : "";
$cf_sliderLayerid 	= (isset($custom["slider_layerid"][0]))? $custom["slider_layerid"][0] : "";
$cf_sliderType		= (isset($custom["slider_type"][0]))? $custom["slider_type"][0] : "flexslider";

?>
<!-- SLIDER -->
<div id="outerslider" class="<?php echo $emptyclass; ?>">
	
    <div id="slidercontainer">
        <section id="slider">
        	<?php if($cf_sliderType=='flexslider'){ ?>
            <div id="slideritems" class="flexslider preloader">
                <ul class="slides">
                    <?php
                    
					$catSlider = get_term_by('slug', $cf_sliderCategory, "slidercat");
                    if($cf_sliderCategory!=""){
                        $catSliderInclude = '&slidercat='. $catSlider->slug ;
                    }
                    
                    query_posts('post_type=slider'.$catSliderInclude.'&post_status=publish&showposts=-1&order=' . $sliderarrange);
                    while ( have_posts() ) : the_post();
                    
                    $prefix = 'if_';
                    $custom = get_post_custom( get_the_ID() );
                    $thumbid = get_post_thumbnail_id( get_the_ID() );
                    $slidersrc = wp_get_attachment_image_src( $thumbid, 'full' );

                    $cf_slideurl = (isset($custom["external_link"][0]))?$custom["external_link"][0] : "";
                    $cf_thumb = (isset($custom["image_url"][0]))? $custom["image_url"][0] : "";
					$cf_subtitle = (isset($custom["subtitle"][0]))? $custom["subtitle"][0] : "";
					$cf_talign = (isset($custom["text_align"][0]))? $custom["text_align"][0] : "";
                    $cf_bgSlideImg = (isset($custom["bgslide_img"][0]))? $custom["bgslide_img"][0] : "";
					$cf_bgSlideRepeat = (isset($custom["bgslide_repeat"][0]) && trim($custom["bgslide_repeat"][0])!="")? $custom["bgslide_repeat"][0] : "";
					$cf_bgSlidePos = (isset($custom["bgslide_pos"][0]) && trim($custom["bgslide_pos"][0])!="")? $custom["bgslide_pos"][0] : "";
					$cf_bgSlideAttch = (isset($custom["bgslide_attch"][0]) && trim($custom["bgslide_attch"][0])!="")? $custom["bgslide_attch"][0] : "";
                    $cf_bgSlideColor = (isset($custom["bgslide_color"][0]))? $custom["bgslide_color"][0] : "";
                    
                    $output = $style ="";
					if($cf_bgSlideImg!=""){
						$style .= 'background-image:url(' . $cf_bgSlideImg . ');';
					}
					if($cf_bgSlideRepeat!=""){
						$style .= 'background-repeat:' . $cf_bgSlideRepeat . ';';
					}
					if($cf_bgSlidePos!=""){
						$style .= 'background-position:' . $cf_bgSlidePos . ';';
					}
					if($cf_bgSlideAttch!=""){
						$style .= 'background-attachment:' . $cf_bgSlideAttch . ';';
					}
					if($cf_bgSlideColor!=""){
						$style .= 'background-color:' . $cf_bgSlideColor . ';';
					}
                    $output .='<li style="'.$style.'">';
                        if($cf_slideurl!=""){
                            $output .= '<a href="'.$cf_slideurl.'">';
                        }
                       
                        //slider images
                        if(has_post_thumbnail( get_the_ID()) || $cf_thumb!=""){
                            if($cf_thumb!=""){
                                $output .= '<img src="'.$cf_thumb.'" alt="" />';
                            }else{
                                $output .= get_the_post_thumbnail(get_the_ID(),'full');
                            }
                        }
                            
                        if($cf_slideurl!=""){
                            $output .= '</a>';
                        }
                        
                       //slider text
                       if($sliderDisableText!=true){
					   		if($cf_talign=="left"){
								$talign = "left";
							}elseif($cf_talign=="right"){
								$talign = "right";
							}else{
								$talign = "top";
							}
                           $output .='<div class="flex-caption">';
						   	$output .='<div class="text-caption row '.$talign.'">';
						   		$output .='<div class="caption-content">';
						   if($cf_slideurl!=""){
                               $output .='<h2><a href="'.$cf_slideurl.'">'.get_the_title().'</a></h2>';
                           }else{
                               $output .='<h2>'.get_the_title().'</h2>';
                           }
						   
						   if($cf_subtitle!=""){
						   		$output .= '<h3>'.$cf_subtitle.'</h3>';
						   }
						   
                           if($cf_slideurl!=""){
                               $output .='<div><a href="'.$cf_slideurl.'">'.get_the_excerpt().'</a></div>';
							   $output .='<a class="sliderbutton" href="'.$cf_slideurl.'"><span>'.__( 'Learn more', THE_LANG ).'</span></a>';
                           }else{
                               $output .='<div>'.get_the_excerpt().'</div>';
                           }
						   
						   		$output .='</div>';
								$output .='<div class="clearfix"></div>';
							$output .='</div>';
                           $output .='</div>';
                       }
                        
                    $output .='</li>';
                    
                    echo $output;
                    
                    endwhile;
                    wp_reset_query();
                    ?>
                </ul>
            </div>
            <?php }elseif($cf_sliderType=='layerslider'){ ?>
            	<?php 
				if($cf_sliderLayerid!=""){
					echo do_shortcode('[layerslider id="'.$cf_sliderLayerid.'"]');
				}
				?>
            <?php } //endif cf_sliderType ?>
            <div class="clearfix"></div>
        </section>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END SLIDER -->