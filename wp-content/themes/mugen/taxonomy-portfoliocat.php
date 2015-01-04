<?php
/**
 * Template Name: Portfolio
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

get_header(); ?>

		<?php
        
        $custom = if_get_customdata();
        $column = (isset($custom["p_column"][0]))? intval($custom["p_column"][0]) : "";
        $cats = (isset($custom["p_category"][0]))? $custom["p_category"][0] : "";
        $showpost = (isset($custom["p_showpost"][0]))? $custom["p_showpost"][0] : "";
        $categories = $cats;

        if(is_front_page()){
            $paged = (get_query_var('page'))? get_query_var('page') : 1;
        }else{
            $paged = (get_query_var('paged'))? get_query_var('paged') : 1;
        }
        
        $idnum = 0;

        if($column!= 2 && $column!= 3 && $column!= 4 ){
            $column = 3;
        }
        $typecol = "if-pf-col-".$column;
        $imgsize = "portfolio-image-col".$column;
        ?>
        
        <div class="if-pf-container">
            <ul class="<?php echo $typecol; ?>">
        
        <?php
        while ( have_posts() ) : the_post(); 
                $idnum++;
                
                if($column=="2"){
                    $classpf = 'six columns ';
                }elseif($column=="4"){
                    $classpf = 'three columns ';
                }else{
                    $classpf = 'four columns ';
                }
                
                if(($idnum%$column) == 1){ $classpf .= "first ";}
                if(($idnum%$column) == 0){$classpf .= "last ";}
                
                echo if_pf_get_box( $imgsize, get_the_ID(), $classpf );
                    
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