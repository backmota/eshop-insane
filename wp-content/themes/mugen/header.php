<?php
/**
 * The Header for our theme.
 *
 *
 * @package WordPress
 * @subpackage Mugen
 * @since Mugen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?> class="no-js">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?> class="no-js">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?> class="no-js">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php if_document_title(); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
/* We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
 */
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head(); /* the interfeis' custom content for wp_head is in includes/header-functions.php */
?>
</head><?php $bodyclass = if_bodyclass(); ?>
<body <?php body_class($bodyclass); ?>>


<div id="subbody">
		<div id="outercontainer">
		<?php
        $shortname = THE_SHORTNAME;
    
        if( is_home() ){
            $pid = get_option('page_for_posts');
        }else{
            $pid = get_the_ID();
        }
    
        $custom = if_get_customdata($pid);
        $showbc = (isset($custom["show_breadcrumb"][0]) && $custom["show_breadcrumb"][0]=="false")? false : true;
        
        /* Slider Position */
        $cf_enableSlider 	= (isset($custom["enable_slider"][0]))? $custom["enable_slider"][0] : "";
        $cf_sliderPos	 	= (isset($custom["slider_position"][0]))? $custom["slider_position"][0] : "";
        
        $issliderdisplayed = false;
        if($cf_enableSlider=="true" && !is_search()){
            $issliderdisplayed = true;
        }
        ?>
        
        <!-- HEADER -->
        <div id="outerheader">
            <?php
            $headerText = stripslashes(if_get_option( THE_SHORTNAME . '_header_text',''));
            $disable_topsearch = if_get_option(THE_SHORTNAME . '_disable_topsearch');
            $disable_minicart = if_get_option(THE_SHORTNAME . '_disable_minicart');
            $disable_toppcats = if_get_option(THE_SHORTNAME . '_disable_toppcats');
            $socialiconoutput = if_socialicon();
            ?>
            <div id="headertext">
                <div class="container">
                    <div class="row">
                        <div class="headercontent twelve columns">
                            <?php
                            if($headerText){
                                echo '<div class="alignleft toppanel toptext">' . do_shortcode($headerText) . '</div>';
                            }
    
                            /*=====TOPSEARCH======*/
                            if($disable_topsearch!=true){
                                echo if_searchform("topsearchform", "toppanel lastpanel");
                            }
                            
                            wp_nav_menu( array(
                            'container'       => 'ul', 
                            'menu_class'      => 'headermenu toppanel',
                            'menu_id'         => 'headernav', 
                            'depth'           => 1,
                            'sort_column'    => 'menu_order',
                            'fallback_cb'     => 'nav_2nd_fallback',
                            'theme_location' => 'headermenu' 
                            )); 
                            ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="top">
                <div class="container">
                    <header class="row">
                        <div id="logo" class="positionleft"><?php if_logo(); // print the logo html ?></div>
                        <nav id="navigation" class="positionleft">
                        <?php wp_nav_menu( array(
                          'container'       => 'ul', 
                          'menu_class'      => 'sf-menu',
                          'menu_id'         => 'topnav', 
                          'depth'           => 0,
                          'sort_column'    => 'menu_order',
                          'fallback_cb'     => 'nav_page_fallback',
                          'theme_location' => 'mainmenu' 
                          )); 
                        ?>
                        </nav><!-- nav -->	
                        <div class="three columns positionright">
                        <?php
                        /*=====MINICART======*/
                        if($disable_minicart!=true && function_exists('is_woocommerce')){
                            echo if_minicart("topminicart","commercepanel");
                        }
                        
                       /* if($disable_toppcats!=true && function_exists('is_woocommerce')){
                            if_woocategories("toppcats","commercepanel"); 
                        } */
                        ?>
                        </div>
                        <div class="clearfix"></div>
                    </header>
                </div>
            </div>
        </div>
        <!-- END HEADER -->
        <?php 
        if($issliderdisplayed){
            get_template_part( 'slider');
        }
        
        if( !$issliderdisplayed ){ 
        ?>
        <!-- AFTER HEADER -->
        <div id="outerafterheader">
            <div class="container">
                <div id="afterheader" class="row">
                    <section id="aftertheheader" class="twelve columns">
                        <?php
                        get_template_part( 'title');
                        if($showbc){
                            if( function_exists('woocommerce_breadcrumb')){
                                remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
                                woocommerce_breadcrumb();
                            }elseif(function_exists('yoast_breadcrumb')){
                                yoast_breadcrumb('<nav class="woocommerce-breadcrumb">','</nav>');
                            }
                        }
                        ?>
                        <div class="clearfix"></div>
                    </section>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- END AFTER HEADER -->
        <?php 
        }/* end if( !$issliderdisplayed ) */ 
        ?>
        
        <?php
		$beforecontent 	= (isset($custom['beforecontent_text'][0]) && $custom['beforecontent_text'][0]!="")? $custom['beforecontent_text'][0] : "";
		
		if($beforecontent!="") {
		?>
        <!-- BEFORE CONTENT -->
        <div id="outeraftercontent">
            <div class="container">
                <section id="aftercontent" class="row">
                    <div class="twelve columns">
                        <?php echo do_shortcode($beforecontent); ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </section>
            </div>
        </div>
        <!-- END BEFORE CONTENT -->
        <?php }// end if($beforecontent!="") ?>
        
        <?php
		$sidebarposition = if_get_option( $shortname . '_sidebar_position' ,'two-col-left'); 
		$pagelayout = ($sidebarposition!="")? $sidebarposition : 'two-col-left';
		if(isset( $custom['klasik_layout'][0] ) && $custom['klasik_layout'][0]!='default'){
			$pagelayout = $custom['klasik_layout'][0];
		}
		
		if($pagelayout!='one-col'){
			$mcontentclass = "hassidebar";
			if($pagelayout=="two-col-left"){
				$mcontentclass .= " mborderright";
			}else{
				$mcontentclass .= " mborderleft";
			}
		}else{
			$mcontentclass = "twelve columns";
		}
		?>
        <!-- MAIN CONTENT -->
        <div id="outermain">
        	<div id="main-gradienttop">
        	<div class="container">
            	<div class="row">
                
                <section id="maincontent" class="<?php echo $mcontentclass; ?>">
                
                <?php if($pagelayout!='one-col'){ ?>
                        
                    <section id="content" class="nine columns <?php if($pagelayout=="two-col-left"){echo "positionleft";}else{echo "positionright";}?>">
                        <div class="main">
                
                <?php } ?>
                	