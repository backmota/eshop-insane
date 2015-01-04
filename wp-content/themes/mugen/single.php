<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Mugen
 * @since Mugen 1.0
 */

get_header(); ?>

                <div id="singlepost">
                
                     <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                     <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                     
                        <?php
                            
                        $custom = get_post_custom($post->ID);
                        $cf_thumb = (isset($custom["image_url"][0]))? $custom["image_url"][0] : "";
                        
                        if($cf_thumb!=""){
                            $thumb = '<div class="frameimg"><img src='. $cf_thumb .' alt="" width="" height="" class="scale-with-grid"/></div>';
                        }elseif(has_post_thumbnail($post->ID) ){
                            $thumb = '<div class="frameimg">'.get_the_post_thumbnail($post->ID, 'blog-post-image', array('alt' => '', 'class' => '')).'</div>';
                        }else{
                            $thumb ="";
                        }

                        echo  $thumb;
                        ?>
                        
                         <div class="entry-content">
                            <?php the_content();?>
                            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', THE_LANG ) . '</span>', 'after' => '</div>' ) ); ?>
                            <div class="entry-utility">
                                <div class="meta-author"><span class="icon-user"></span> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author();?></a></div> 
                                <div class="meta-date"><span class="icon-calendar"></span> <?php the_time('F d, Y') ?></div>
                                <div class="meta-cat"><span class="icon-archive"></span> <?php the_category(', '); ?></div>
                                <div class="meta-comment"><span class="icon-retweet"></span> <?php comments_popup_link(__('0 Comment', THE_LANG), __('1 Comment', THE_LANG), __('% Comments', THE_LANG)); ?></div>
                                <span class="nav-next"><?php next_post_link( '%link', __( 'Next', THE_LANG ) ); ?></span>
                                <span class="nav-previous"><?php previous_post_link( '%link', __( 'Previous', THE_LANG ) ); ?></span>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                        
                     </article>
                    <?php
                    
                    // If a user has filled out their description, show a bio on their entries.
                    if ( get_the_author_meta( 'description' ) ) : ?>
                    <div id="entry-author-info">
                        <div id="author-avatar">
                            <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'interfeis_author_bio_avatar_size', 60 ) ); ?>
                        </div><!-- author-avatar -->
                        <div id="author-description">
                            <h2><span class="author"><?php printf( __( 'About %s', THE_LANG ), get_the_author() ); ?></span></h2>
                            <?php the_author_meta( 'description' ); ?>
                        </div><!-- author-description	-->
                    </div><!-- entry-author-info -->
                    <?php endif; ?>

                    <?php comments_template( '', true ); ?>
                    
                    <?php endwhile; ?>
                
                </div><!-- singlepost --> 
                <div class="clearfix"></div>

<?php get_footer(); ?>