<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibilty
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

if($woocommerce_loop['columns']==4){
	$colclass = "three columns";
}else{
	$colclass = "four columns";
}

$ptermsobj = get_the_terms($product->id,'product_cat');
$pterms = "";
if(!is_wp_error($ptermsobj) && $ptermsobj!=false){
	$ptermsarr = array();
	foreach($ptermsobj as $ptermobj){
		$ptermsarr[] = $ptermobj->slug;
	}
	if(count($ptermsarr)) $pterms = implode(" ",$ptermsarr);
}
$classes = $pterms." ".$colclass." ";

if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
	$classes .= ' last';
elseif ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 )
	$classes .= ' first';

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
?>
<li <?php post_class( $classes ); ?>>
	<div class="pcontainer">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    	<div class="imgbox">
        	<div class="curve-down">
        	<?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
					echo '<a href="'.get_permalink().'" class="imglink">';
                	do_action( 'woocommerce_before_shop_loop_item_title' );
					echo '</a>';
					woocommerce_template_loop_add_to_cart();
            ?>
            
            <div class="ptext">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php
                    /**
                     * woocommerce_after_shop_loop_item_title hook
                     *
                     * @hooked woocommerce_template_loop_price - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item_title' );
                ?>
                <div class="clearfix"></div>
            </div>
            
			</div>
        </div>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
    
    <div class="hidden">
    	<?php //woocommerce_get_template_part( 'content', 'quickview-product' ); ?>
    </div>
    
</li>