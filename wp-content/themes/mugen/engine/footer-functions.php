<?php 
/* print javascript in the footer */
if(!function_exists("if_print_javascript")){
	function if_print_javascript(){

		wp_reset_query();
		
		$twitterusername = if_get_option( THE_SHORTNAME . '_twitter_username' ,''); 
		
		$sliderEffect = if_get_option( THE_SHORTNAME . '_slider_effect' ,'fade'); 
		$sliderInterval = if_get_option( THE_SHORTNAME . '_slider_interval' ,600);
		$sliderDisableNav = if_get_option( THE_SHORTNAME . '_slider_disable_nav');
		$sliderDisablePrevNext = if_get_option( THE_SHORTNAME . '_slider_disable_prevnext');
?>
<!-- Hook Flexslider -->
<script type="text/javascript">
jQuery(document).ready(function(){
    var slidereffect 			= '<?php echo $sliderEffect; ?>';
    var slider_interval 		= '<?php echo $sliderInterval; ?>';
    var slider_disable_nav 		= '<?php echo $sliderDisableNav; ?>';
    var slider_disable_prevnext	= '<?php echo $sliderDisablePrevNext; ?>';
    
    if(slider_disable_prevnext=="0"){
        var direction_nav = true;
    }else{
        var direction_nav = false;
    }
    
    if(slider_disable_nav=="0"){
        var control_nav = true;
    }else{
        var control_nav = false;
    }
        
    jQuery('.flexslider').flexslider({
        animation: slidereffect,
        animationDuration: slider_interval,
        directionNav: direction_nav,
        controlNav: control_nav,
        smoothHeight: true,
		pauseOnHover: true
    });
	
	<?php if($twitterusername){ ?>
	jQuery.getJSON("https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=<?php echo $twitterusername; ?>&count=1&callback=?",
		function(data){
			jQuery.each(data, function(i,item){ 
				ct = item.text;
				mytime = item.created_at;
				var strtime = mytime.replace(/(\+\S+) (.*)/, '$2 $1')
				var mydate = new Date(Date.parse(strtime)).toLocaleDateString();
				var mytime = new Date(Date.parse(strtime)).toLocaleTimeString();		
	
				ct = ct.replace(/http:\/\/\S+/g,  '<a href="$&" target="_blank">$&</a>');
				ct = ct.replace(/\s(@)(\w+)/g,    ' @<a href="http://twitter.com/$2" target="_blank">$2</a>');
				ct = ct.replace(/\s(#)(\w+)/g,    ' #<a href="http://search.twitter.com/search?q=%23$2" target="_blank">$2</a>');
				jQuery("#jstweets").append('<div>'+ct + "</div>");
			});
		}
	).done(function() { console.log( "second success" ); })
.fail(function() { console.log( "error" ); })
.always(function() { console.log( "complete" ); });
	<?php }?>
	
});

jQuery(window).load(function(){
	isotopeinit();
});
jQuery(window).resize(function(){
	isotopeinit();
});
</script>
<?php 
	}/* end if_print_javascript() */
	add_action("wp_footer","if_print_javascript",19);
}

	
/* get website title */
if(!function_exists("if_footer_text")){
	function if_footer_text(){
	
		$foot= stripslashes(if_get_option( THE_SHORTNAME . '_footer'));
		if($foot==""){
		
			_e('Copyright', THE_LANG ); echo ' &copy;';
			global $wpdb;
			$post_datetimes = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstyear, YEAR(max(post_date_gmt)) AS lastyear FROM $wpdb->posts WHERE post_date_gmt > 1970");
			if ($post_datetimes) {
				$firstpost_year = $post_datetimes[0]->firstyear;
				$lastpost_year = $post_datetimes[0]->lastyear;
	
				$copyright = $firstpost_year;
				if($firstpost_year != $lastpost_year) {
					$copyright .= '-'. $lastpost_year;
				}
				$copyright .= ' ';
	
				echo $copyright;
				echo '<a href="'.home_url( '/').'">'.get_bloginfo('name') .'.</a>';
			}
			?> 
			<?php _e('Designed by', THE_LANG ); ?> 
            <a href="<?php echo esc_url( __( 'http://www.interfeis.com', THE_LANG) ); ?>" title="<?php _e('Interfeis - It\'s Beautiful', THE_LANG); ?>"><?php _e('Interfeis', THE_LANG); ?></a>
        <?php 
		}else{
        	echo $foot;
        }
		
	}/* end if_footer_text() */
}