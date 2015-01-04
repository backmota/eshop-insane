<?php
function if_post_type_slider() {
	register_post_type( 'slider',
                array( 
				'label' => __('Sliders', THE_LANG ), 
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'rewrite' => array( 'slug' => 'slider', 'with_front' => false ),
				'hierarchical' => true,
				'menu_position' => 5,
				'exclude_from_search' =>true,
				'supports' => array(
				                     'title',
									 'editor',
                                     'thumbnail',
									 'custom-fields')
					) 
				);
				
	register_taxonomy('slidercat', 'slider',array('hierarchical' => true, 'label' =>  __('Slider Categories', THE_LANG ), 'singular_name' => __('Category', THE_LANG ))
	);
}
add_action('init', 'if_post_type_slider');
add_filter('manage_edit-slider_columns', 'if_slider_add_list_columns');
add_action('manage_slider_posts_custom_column', 'if_slider_manage_column');
add_action( 'restrict_manage_posts', 'if_slider_add_taxonomy_filter');

function if_slider_add_list_columns($slider_columns){
		
	$new_columns = array();
	$new_columns['cb'] = '<input type="checkbox" />';
	
	$new_columns['title'] = __('Title', THE_LANG);
	$new_columns['images'] = __('Images', THE_LANG);
	$new_columns['author'] = __('Author', THE_LANG);
	
	$new_columns['slidercat'] = __('Categories', THE_LANG);
	
	$new_columns['date'] = __('Date', THE_LANG);
	
	return $new_columns;
}

function if_slider_manage_column($column_name){
	global $post;
	$posttype = 'slider';
	$taxonom = 'slidercat';
	
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
		
		case 'slidercat':
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
function if_slider_add_taxonomy_filter() {
	global $typenow;
	$posttype = 'slider';
	$taxonomy = 'slidercat';
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