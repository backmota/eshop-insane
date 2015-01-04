<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Mugen
 * @since Mugen 1.0
 */
?>
				<?php
                $shortname = THE_SHORTNAME;
                $sidebarposition = if_get_option( $shortname . '_sidebar_position' ,'two-col-left'); 
                
                if( is_home() ){
                    $pid = get_option('page_for_posts');
                }else{
                    $pid = get_the_ID();
                }
                
                $custom = if_get_customdata($pid);
                $aftercontent 	= (isset($custom['aftercontent_text'][0]) && $custom['aftercontent_text'][0]!="")? $custom['aftercontent_text'][0] : "";
                $pagelayout 	= ($sidebarposition!="")? $sidebarposition : 'two-col-left';
                
                if(isset( $custom['klasik_layout'][0] ) && $custom['klasik_layout'][0]!='default'){
                    $pagelayout = $custom['klasik_layout'][0];
                }
                if($pagelayout!='one-col'){ 
                ?>
                
                        <div class="clearfix"></div>
                    </div><!-- main -->
                </section><!-- content -->
                <aside id="sidebar" class="three columns <?php if($pagelayout=="two-col-left"){echo "positionright";}else{echo "positionleft";}?>">
                    <?php get_sidebar();?>  
                </aside><!-- sidebar -->
                
                <?php 
                } 
                ?>
            
                <div class="clearfix"></div>
            </section><!-- maincontent -->
            </div>
        </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
    
    <?php if($aftercontent!=""){ ?>
    <!-- AFTER CONTENT -->
    <div id="outeraftercontent">
        <div class="container">
            <section id="aftercontent" class="row">
                <div class="twelve columns">
                    <?php echo do_shortcode($aftercontent); ?>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </section>
        </div>
    </div>
    <!-- END AFTER CONTENT -->
    <?php }// end if($aftercontent!="") ?>
    
    <!-- FOOTER SIDEBAR AND FOOTER TEXT -->
	<div id="footerwrapper">
<?php
$footcol_scheme = array(
	'0;none',
	'1;twelve columns',
	'2;three columns-nine columns',
	'2;six columns-six columns',
	'2;nine columns-three columns',
	'3;three columns-six columns-three columns',
	'3;three columns-three columns-six columns',
	'3;six columns-three columns-three columns',
	'3;four columns-four columns-four columns',
	'4;three columns-three columns-three columns-three columns'
);

$disablefootersidebar 	= if_get_option($shortname. '_disable_footer_sidebar');
$opt_footerUpperLayout	= intval(if_get_option($shortname. '_footer_upper_sidebar_layout',9));
$opt_footerLayout 		= intval(if_get_option($shortname. '_footer_sidebar_layout',9));

$cf_footerUpperLayout	= (isset($custom["layout_footerupper"][0]) && (intval($custom["layout_footerupper"][0])>=0 && intval($custom["layout_footerupper"][0])<=9) )? intval($custom["layout_footerupper"][0]) : $opt_footerUpperLayout; 
$footupcol = explode(';',$footcol_scheme[$cf_footerUpperLayout]);
$footupclass = explode('-',$footupcol[1]);

$cf_footerLayout	= (isset($custom["layout_footer"][0]) && (intval($custom["layout_footer"][0])>=0 && intval($custom["layout_footer"][0])<=9) )? intval($custom["layout_footer"][0]) : $opt_footerLayout; 
$footcol = explode(';',$footcol_scheme[$cf_footerLayout]);
$footclass = explode('-',$footcol[1]);


if($footupcol[0]>0 || $footcol[0]>0){
?>			
        <!-- FOOTER SIDEBAR -->
        <div id="outerfootersidebar">
        
        	<?php if($footupcol[0]>0){ ?>
        	<div id="footersidebarupper">
                <div class="container">

                    <div class="row"> 
                        <footer class="footersidebar">
                        <?php for($i=0;$i<$footupcol[0];$i++){ $numfootcol = $i+1; ?>
                        
                        <div id="footcol<?php echo $numfootcol; ?>"  class="<?php echo $footupclass[$i]; ?>">
                            <div class="widget-area">
                                <?php if ( ! dynamic_sidebar( 'footerupper'.$numfootcol ) ) : ?><?php endif; // end general widget area ?>
                            </div>
                        </div>
                        
                        <?php } ?>
                            <div class="clearfix"></div>
                        </footer>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
            </div>
            <?php } ?>
            
            <?php if($footcol[0]>0){ ?>
            <div id="footersidebarbottom">
                <div class="container">

                    <div class="row"> 
                        <footer class="footersidebar">
                        <?php for($i=0;$i<$footcol[0];$i++){ $numfootcol = $i+1; ?>
                        
                        <div id="footcol<?php echo $numfootcol; ?>"  class="<?php echo $footclass[$i]; ?>">
                            <div class="widget-area">
                                <?php if ( ! dynamic_sidebar( 'footer'.$numfootcol ) ) : ?><?php endif; // end general widget area ?>
                            </div>
                        </div>
                        
                        <?php } ?>
                            <div class="clearfix"></div>
                        </footer>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
            <?php } ?>
            
        </div>
        <!-- END FOOTER SIDEBAR -->
<?php
}
?>
        <!-- FOOTER -->
        <div id="outerfooter">
        	<div class="container">
                <div id="footercontainer" class="row">
                    <footer id="footer" class="twelve columns">
                        <div class="copyright"><?php if_footer_text(); ?></div>
                        <nav id="footermenu">
                        <?php wp_nav_menu( array(
                          'container'       => 'ul', 
                          'menu_class'      => 'footermenu',
                          'menu_id'         => 'footernav', 
                          'depth'           => 1,
                          'sort_column'    => 'menu_order',
						  'fallback_cb'     => 'nav_2nd_fallback',
                          'theme_location' => 'footermenu' 
                          )); 
                        ?>
                        </nav><!-- nav -->	
                        <div class="clearfix"></div>
                    </footer>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- END FOOTER -->
	</div>
        
	</div><!-- end bodychild -->
</div><!-- end outercontainer -->
<?php 
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
	
	$trackingcode = stripslashes(if_get_option( THE_SHORTNAME . '_trackingcode'));
	if($trackingcode!=""){
		echo '<script type="text/javascript">';
		echo $trackingcode;
		echo '</script>';
	}
?>
</body>
</html>
