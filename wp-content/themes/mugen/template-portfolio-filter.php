<?php
/**
 * Template Name: Portfolio Filter
 *
 * A custom page template for portfolio page.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Mugen
 * @since Mugen 1.0
 */

get_header(); 
?>
       <?php
			the_content();
			
			if( is_home() ){
				$pid = get_option('page_for_posts');
			}else{
				$pid = get_the_ID();
			}
		
			$custom = if_get_customdata($pid);
			$column = (isset($custom["p_column"][0]))? intval($custom["p_column"][0]) : "";
			$cats = (isset($custom["p_categories"][0]))? $custom["p_categories"][0] : "";
			$orderby = (isset($custom["p_orderby"][0]))? $custom["p_orderby"][0] : "date";
			$ordersort = (isset($custom["p_sort"][0]))? $custom["p_sort"][0] : "DESC";
			$categories = explode(",",$cats);
			
			$approvedcats = array();
			foreach($categories as $category){
				$catname = get_term_by('slug',$category,"portfoliocat");
				if($catname!=false){
					$approvedcats[] = $catname;
				}
			}
			
			$catslugs = array();
			if(count($approvedcats)>0){
				echo '<ul id="filters" class="option-set clearfix " data-option-key="filter">';
					echo '<li class="alpha selected"><span class="radiobutton"></span><a href="#filter" data-option-value="*">'. __('All Categories', THE_LANG ).'</a><span class="clearfix"></span></li>';
					$filtersli = '';
					$numli = 1;
					foreach($approvedcats as $approvedcat){
						if($numli==1){
							$liclass = 'omega';
						}else{
							$liclass = '';
						}
						$filtersli = '<li class="'.$liclass.'"><span class="radiobutton"></span><a href="#filter" data-option-value=".'.$approvedcat->slug.'">'.$approvedcat->name.'</a><span class="clearfix"></span></li>'.$filtersli;
						$catslugs[] = $approvedcat->slug;
						$numli++;
					}
					echo $filtersli;
				echo '</ul>';
			}

			$idnum = 0;

			if($column!= 2 && $column!= 3 && $column!= 4 ){
				$column = 3;
			}
			$typecol = "if-pf-col-".$column;
			$imgsize = "portfolio-image-col".$column;
			
			$argquery = array(
				'post_type' => 'portofolio',
				'showposts' => -1,
				'orderby' => $orderby,
				'order' => $ordersort,
				'paged' => $paged
			);
			
			if(count($catslugs)>0){
				$argquery['tax_query'] = array(
					array(
						'taxonomy' => 'portfoliocat',
						'field' => 'slug',
						'terms' => $catslugs
					)
				);
			}
	
			query_posts($argquery); 
			global $post, $wp_query;
			
			?>
			
			<div id="if-pf-filter" class="if-pf-container row">
				<ul class="<?php echo $typecol; ?> isotope">
			
			<?php
			while ( have_posts() ) : the_post(); 
					$prefix = 'if_';
					$idnum++;
					
					if($column=="2"){
						$classpf = 'six columns ';
					}elseif($column=="4"){
						$classpf = 'three columns ';
					}else{
						$classpf = 'four columns ';
					}
					
					$thepfterms = get_the_terms( get_the_ID(), 'portfoliocat');
					
					$literms = "";
					if ( $thepfterms && ! is_wp_error( $thepfterms ) ){

						$approvedterms = array();
						foreach ( $thepfterms as $term ) {
							$approvedterms[] = $term->slug;
						}			
						$literms = implode( " ", $approvedterms );
					}
					
					echo if_pf_get_box( $imgsize, get_the_ID(), $classpf.' element '.$literms );
						
					$classpf=""; 
						
			endwhile; // End the loop. Whew.
			?>
				<li class="pf-clear"></li>
				</ul>
				<div class="clearfix"></div>
			</div><!-- end #if-portfolio -->
					  
			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
			 <?php if(function_exists('wp_pagenavi')) { ?>
				 <?php wp_pagenavi(); ?>
			 <?php }else{ ?>
				<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', THE_LANG ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', THE_LANG ) ); ?></div>
				</div><!-- #nav-below -->
			<?php }?>
			<?php endif;  wp_reset_query();?>
					
			<div class="clearfix"></div><!-- clear float --> 
                
<?php get_footer(); ?>