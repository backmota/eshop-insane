<?php
/**
 * The template for displaying search forms in the template
 *
 * @package WordPress
 * @subpackage Mugen
 * @since Mugen 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<div class="searcharea">
    <input type="text" name="s" id="s" value="<?php _e('Search...', THE_LANG );?>" onfocus="if (this.value == '<?php _e('Search...',THE_LANG ) ;?>')this.value = '';" onblur="if (this.value == '')this.value = '<?php _e('Search...', THE_LANG );?>';" />
</div>
</form>