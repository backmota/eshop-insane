<?php
function if_post_type_testimonial() {
	register_post_type( 'testimonialpost',
                array( 
				'label' => __('Testimonials', THE_LANG ), 
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'rewrite' => array( 'slug' => 'testimonial', 'with_front' => false ),
				'hierarchical' => true,
				'menu_position' => 5,
				'exclude_from_search' =>true,
				'supports' => array(
				                     'title',
									 'editor',
                                     'revisions',
									 'custom-fields',
									 'comments')
					) 
				);
				
	register_taxonomy('testimonialcat', 'testimonialpost',array('hierarchical' => true, 'label' =>  __('Testimonial Categories', THE_LANG ), 'singular_name' => __('Category', THE_LANG ))
	);
}
add_action('init', 'if_post_type_testimonial');
add_filter('manage_edit-testimonialpost_columns', 'if_testi_add_list_columns');
add_action('manage_testimonialpost_posts_custom_column', 'if_testi_manage_column');
add_action( 'restrict_manage_posts', 'if_testi_add_taxonomy_filter');

function if_testi_add_list_columns($testimonialpost_columns){
		
	$new_columns = array();
	$new_columns['cb'] = '<input type="checkbox" />';
	
	$new_columns['title'] = __('Title', THE_LANG);
	$new_columns['images'] = __('Images', THE_LANG);
	$new_columns['author'] = __('Author', THE_LANG);
	
	$new_columns['testimonialcat'] = __('Categories', THE_LANG);
	
	$new_columns['date'] = __('Date', THE_LANG);
	
	return $new_columns;
}

function if_testi_manage_column($column_name){
	global $post;
	$posttype = 'testimonialpost';
	$taxonom = 'testimonialcat';
	
	$id = $post->ID;
	$title = $post->post_title;
	switch($column_name){
		case 'images':
			$thumbnailid = get_post_thumbnail_id($id);
			$imagesrc = wp_get_attachment_image_src($thumbnailid, 'thumbnail');
			if($imagesrc){
				echo '<img src="'.$imagesrc[0].'" width="50" alt="'.$title.'" />';
			}else{
				_e('No Featured Image', THE_LANG);
			}
			break;
		
		case 'testimonialcat':
			$postterms = get_the_terms($id, $taxonom);
			if($postterms){
				$termlists = array();
				foreach($postterms as $postterm){
					$termlists[] = '<a href="'.admin_url('edit.php?'.$taxonom.'='.$postterm->slug.'&post_type='.$posttype).'">'.$postterm->name.'</a>';
				}
				if(count($termlists)>0){
					$termtext = implode(", ",$termlists);
					echo $termtext;
				}
			}
			
			break;
	}
}

/* Filter Custom Post Type Categories */
function if_testi_add_taxonomy_filter() {
	global $typenow;
	$posttype = 'testimonialpost';
	$taxonomy = 'testimonialcat';
	if( $typenow==$posttype){
		$filters = array($taxonomy);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
			echo "<option value=''>".__('View All',THE_LANG)." "."$tax_name</option>";
			if(count($terms)){
				foreach ($terms as $term) { 
					$selectedstr = '';
					if(isset($_GET[$tax_slug]) && $_GET[$tax_slug] == $term->slug){
						$selectedstr = ' selected="selected"';
					}
					echo '<option value='. $term->slug. $selectedstr . '>' . $term->name .' (' . $term->count .')</option>'; 
				}
			}
			echo "</select>";
		}
	}
}