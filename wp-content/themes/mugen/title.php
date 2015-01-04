<?php
//custom meta field
$prefix = 'if_';
if( is_home() ){
	$pid = get_option('page_for_posts');
}else{
	$pid = get_the_ID();
}

$custom = if_get_customdata($pid);
$cf_pagetitle = (isset($custom["page-title"][0]))? $custom["page-title"][0] : "";

if(is_singular('portofolio') || is_attachment()){

	echo '<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
	
}elseif( function_exists('is_woocommerce') && is_woocommerce() ){
	echo '<h1 class="pagetitle"><span>';
		if ( is_search() ){
			
			printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
			if ( get_query_var( 'paged' ) )
				printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );

		}elseif ( is_tax() ){
		
			echo single_term_title( "", false );
			
		}elseif(is_product()){
	
			echo get_the_title();
			
		}else{

			$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
			echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );

		}
	echo '</span></h1>';
}elseif(is_single()){
	
	echo '<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
	
}elseif(is_archive()){
	echo ' <h1 class="pagetitle"><span>';
	if ( is_day() ) :
	printf( __( 'Daily Archives <span>%s</span>', THE_LANG ), get_the_date() );
	elseif ( is_month() ) :
	printf( __( 'Monthly Archives <span>%s</span>', THE_LANG ), get_the_date('F Y') );
	elseif ( is_year() ) :
	printf( __( 'Yearly Archives <span>%s</span>', THE_LANG ), get_the_date('Y') );
	elseif ( is_author()) :
	printf( __( 'Author Archives %s', THE_LANG ), "<a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" );
	else :
	printf( __( '%s', THE_LANG ), '<span>' . single_cat_title( '', false ) . '</span>' );
	endif;
	echo '</span> </h1>';
	
}elseif(is_search()){
	echo ' <h1 class="pagetitle"><span>';
	printf( __( 'Search Results for %s', THE_LANG ), '<span>' . get_search_query() . '</span>' );
	echo '</span> </h1>';
	
}elseif(is_404()){
	echo ' <h1 class="pagetitle"><span>';
	_e( '404 Page', THE_LANG );
	echo '</span> </h1>';
	
}elseif( is_home() ){
	$postspage = get_option('page_for_posts');
	$poststitle = get_the_title($postspage);
	
	echo ' <h1 class="pagetitle"><span>';
	echo ($postspage)? $poststitle : __('Blog', THE_LANG );
	echo '</span> </h1>';
	
}else{

 if (have_posts()) : while (have_posts()) : the_post();
	$titleoutput='';
	
	if($cf_pagetitle == ""){
		$titleoutput.='<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
	}else{
		$titleoutput.='<h1 class="pagetitle"><span>'.$cf_pagetitle.'</span></h1>';
	}
	
	echo $titleoutput;
endwhile; endif; wp_reset_query();

}