<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$onebutton = false;
$buttonclass = '';
$emclass = '';
if($product->product_type=='external'){ 
	$onebutton = true; 
	$buttonclass = 'external_button onebutton';
	$emclass = 'icon-if-link';
}elseif($product->product_type=='grouped'){
	$buttonclass = 'select_button';
	$emclass = 'icon-if-list';
}elseif($product->product_type=='variable'){
	$buttonclass = 'select_button';
	$emclass = 'icon-if-list';
}else{
	if($product->is_purchasable()){
		$buttonclass = 'add_to_cart_button';
		$emclass = 'icon-if-addtocart';
	}else{
		$buttonclass = 'btndetail onebutton';
		$emclass = 'icon-if-detail';
		$onebutton = true;
	}
}

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s"><em class="%s"></em> %s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		esc_attr( $buttonclass ),
		esc_attr( $product->product_type ),
		esc_attr( $emclass ),
		esc_html( $product->add_to_cart_text() )
	),
$product );

if(!$onebutton){
	$nonce = wp_create_nonce("if_quickviewproduct_nonce");
    $ajaxlink = admin_url('admin-ajax.php?ajax=true&action=if_quickviewproduct&post_id='.$product->id.'&nonce='.$nonce);
	?>
    <a href="<?php echo $ajaxlink; ?>" data-rel="quickview" class="btm button btndetail"><em class="icon-if-quickview"></em> <?php echo apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', THE_LANG ) ); ?></a>
	<?php
}