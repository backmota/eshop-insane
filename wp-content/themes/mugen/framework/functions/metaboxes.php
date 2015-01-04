<?php
add_action('add_meta_boxes', 'mytheme_add_box');

// Add meta box
function mytheme_add_box() {
	global $meta_boxes;
	foreach($meta_boxes as $meta_box){
		$metaargs = array(
			'meta_array' => $meta_box
		);
		add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['showbox'], $meta_box['page'], $meta_box['context'], $meta_box['priority'], $metaargs);
	}
}

function meta_option_show_box($post, $metaargs) {
	global $meta_boxes;
	
	$meta_array = $metaargs['args']['meta_array'];
	// Use nonce for verification
	echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo mytheme_create_metabox($meta_array);
}


// Create Metabox Form Table
function mytheme_create_metabox($meta_box){

	global $post;
	
	$returnstring = "";
	$returnstring .='
					<style type="text/css">
						.optionimg{border:3px solid #cecece; margin-right:4px;cursor:pointer;}
						.optionimg.optselected{border-color:#ababab;}
						.form-table td em{font-style:normal;color:#999999;font-size:11px;}
					</style>
					<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery( \'.optionimg\').click(function(){
							jQuery(this).parent().find( \'.optionimg\').removeClass( \'optselected\' );
							jQuery(this).addClass( \'optselected\' );
						});
					});
					</script>
				';
	$returnstring .= '<table class="form-table">';
 
	foreach ($meta_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
 
		$returnstring .= '<tr>'.
				'<th style="width:20%;border-bottom:1px solid #e4e4e4;padding:15px 0px"><label for="'. $field['id']. '">'.$field['name']. '</label></th>'.
				'<td style="border-bottom:1px solid #e4e4e4;padding:15px 0px">';
		switch ($field['type']) {
 
//If Text		
			case 'text':
				$textvalue = $meta ? $meta : $field['std'];
				$widthinput = "97%";
				$prefixinput = "";
				$postfixinput = "";
				if(isset($field['class'])){
					if($field['class']=="mini"){
						$widthinput = "20%";
					}
				}
				if(isset($field['prefix'])){
					$prefixinput = stripslashes(trim($field['prefix']));
				}
				if(isset($field['postfix'])){
					$postfixinput = stripslashes(trim($field['postfix']));
				}
				$returnstring .= $prefixinput.'<input type="text" name="'. $field['id']. '" id="'. $field['id']. '" value="'. htmlspecialchars($textvalue) .'" size="30" style="width:'.$widthinput.'" /> '.$postfixinput.
					'<br />'.$field['desc'];
				break;
 
 
//If Text Area			
			case 'textarea':
				$textvalue = $meta ? $meta : $field['std'];
				$returnstring .= '<textarea name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" style="width:97%">'. htmlspecialchars($textvalue) .'</textarea>'.
					'<br />'.$field['desc'];
				break;
 
//If Select Combobox			
			case 'select':
				$optvalue = $meta ? $meta : $field['std'];
				$returnstring .= '<select name="'. $field['id']. '" id="'. $field['id']. '">';
				foreach ($field['options'] as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.$option.'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';
				$returnstring .= '<br />'.$field['desc'];
				break;
			
			case 'select-blog-category':
				$optvalue = $meta ? $meta : $field['std'];
				
				// Pull all the categories into an array
				$options_categories = array();
				$options_categories_obj = get_categories();
				$options_categories["allcategories"] =__('Select Post Category',THE_LANG);
				foreach ($options_categories_obj as $category) {
					$options_categories[$category->slug] = $category->cat_name;
				}
				
				$returnstring .= '<select name="'. $field['id']. '" id="'. $field['id']. '">';
				foreach ($options_categories as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.$option.'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';
				
				$returnstring .= '<br />'.$field['desc'];
				break;

//If Checkbox for Blog Categories
			case 'checkbox-blog-categories':
				$chkvalue = $meta ? $meta : $field['std'];
				$chkvalue = explode(",",$chkvalue);
				$args = array(
					"type" 			=> "post",
					"taxonomy" 	=> "category"
				);
				$portcategories = get_categories($args);
				foreach($portcategories as $category){
					$checkedstr="";
					if(in_array($category->slug,$chkvalue)){
						$checkedstr = 'checked="checked"';
					}
					$returnstring .= '<div style="float:left;width:30%;">';
					$returnstring .= '<input type="checkbox" value="'. $category->slug .'" name="'. $field['id']. '[\''.$category->slug.'\']" id="'. $field['id']."-". $category->name . '" '.$checkedstr.' />&nbsp;&nbsp;'. $category->name;
					$returnstring .= '</div>';
				}
				$returnstring .= '<div style="clear:both;"></div><br />'.$field['desc'];
				break;

//If Select Slider Combobox			
			case 'select-slider-category':
				$optvalue = $meta ? $meta : $field['std'];
				
				// Pull all the slider categories into an array
				$options_pcategory = array();
				$options_pcategory_obj = get_terms('slidercat');
				$options_pcategory[""] =__('Select Slider Category',THE_LANG);
				if($options_pcategory_obj){
					foreach ($options_pcategory_obj as $pcategory) {
						$options_pcategory[$pcategory->slug] = $pcategory->name;
					}
				}
				
				$returnstring .= '<select name="'. $field['id']. '" id="'. $field['id']. '">';
				foreach ($options_pcategory as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.$option.'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';
				
				$returnstring .= '<br />'.$field['desc'];
				break;

//If Checkbox for Slider Categories
			case 'checkbox-slider-categories':
				$chkvalue = $meta ? $meta : $field['std'];
				$chkvalue = explode(",",$chkvalue);
				$args = array(
					"type" 			=> "slider",
					"taxonomy" 	=> "slidercat"
				);
				$portcategories = get_categories($args);
				foreach($portcategories as $category){
					$checkedstr="";
					if(in_array($category->slug,$chkvalue)){
						$checkedstr = 'checked="checked"';
					}
					$returnstring .= '<div style="float:left;width:30%;">';
					$returnstring .= '<input type="checkbox" value="'. $category->slug .'" name="'. $field['id']. '[\''.$category->slug.'\']" id="'. $field['id']."-". $category->name . '" '.$checkedstr.' />&nbsp;&nbsp;'. $category->name;
					$returnstring .= '</div>';
				}
				$returnstring .= '<div style="clear:both;"></div><br />'.$field['desc'];
				break;
				
//If Select Portfolio Combobox			
			case 'select-portfolio-category':
				$optvalue = $meta ? $meta : $field['std'];
				
				// Pull all the slider categories into an array
				$options_pcategory = array();
				$options_pcategory_obj = get_terms('portfoliocat');
				$options_pcategory[""] =__('Select Portfolio Category',THE_LANG);
				if($options_pcategory_obj){
					foreach ($options_pcategory_obj as $pcategory) {
						$options_pcategory[$pcategory->slug] = $pcategory->name;
					}
				}
				
				$returnstring .= '<select name="'. $field['id']. '" id="'. $field['id']. '">';
				foreach ($options_pcategory as $option => $val){
					$selectedstr = ($optvalue==$option)? 'selected="selected"' : '';
					$returnstring .= '<option value="'.$option.'" '.$selectedstr.'>'. $val .'</option>';
				}
				$returnstring .= '</select>';
				
				$returnstring .= '<br />'.$field['desc'];
				break;
				
//If Checkbox for Portfolio Categories
			case 'checkbox-portfolio-categories':
				$chkvalue = $meta ? $meta : $field['std'];
				$chkvalue = explode(",",$chkvalue);
				$args = array(
					"type" 			=> "portofolio",
					"taxonomy" 	=> "portfoliocat"
				);
				$portcategories = get_categories($args);
				foreach($portcategories as $category){
					$checkedstr="";
					if(in_array($category->slug,$chkvalue)){
						$checkedstr = 'checked="checked"';
					}
					$returnstring .= '<div style="float:left;width:30%;">';
					$returnstring .= '<input type="checkbox" value="'. $category->slug .'" name="'. $field['id']. '[\''.$category->slug.'\']" id="'. $field['id']."-". $category->name . '" '.$checkedstr.' />&nbsp;&nbsp;'. $category->name;
					$returnstring .= '</div>';
				}
				$returnstring .= '<div style="clear:both;"></div><br />'.$field['desc'];
				break;

//If Select Image			
			case 'selectimage':
				$optvalue = $meta ? $meta : $field['std'];

				foreach ($field['options'] as $option => $val){
					$selectedstr = ($optvalue==$option)? 'optselected' : '';
					$checkedstr = ($optvalue==$option)? 'checked="checked"' : '';
					$returnstring .= '<img src="'.$val.'" class="optionimg '.$selectedstr.'" onclick="document.getElementById(\''.$field['id'].$option.'\').checked=true" style="display:inline-block;" />';
					$returnstring .= '<input type="radio" name="'.$field['id'].'" id="'.$field['id'].$option.'" value="'.$option.'" '.$checkedstr.' style="display:none;"/>';
				}
				$returnstring .= '<br />'.$field['desc'];
				break;

//If Checkbox			
			case 'checkbox':
				$chkvalue = $meta ? true : $field['std'];
				$checkedstr = ($chkvalue)? 'checked="checked"' : '';
				$returnstring .= '<input type="checkbox" name="'. $field['id']. '" id="'. $field['id']. '" '.$checkedstr.' />';
				$returnstring .= '<br />'.$field['desc'];
				break;
				 
//If Button	
			case 'button':
				$buttonvalue = $meta ? $meta : $field['std'] ;
				$returnstring .= '<input type="button" name="'. $field['id']. '" id="'. $field['id']. '"value="'. $buttonvalue. '" />';
				$returnstring .= '<br />'.$field['desc'];
				break;

 
				
		}
		$returnstring .= 	'</td>'.
						'</tr>';
	}
 
	$returnstring .= '</table>';
	
	return $returnstring;

}//END : mytheme_create_metabox
 
 
add_action('save_post', 'mytheme_save_data');
 
 
// Save data from meta box
function mytheme_save_data($post_id) {
	global $meta_boxes;
 
	// verify nonce
	if(isset($_POST['mytheme_meta_box_nonce'])){
		if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
			return $post_id;
		}
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == isset($_POST['post_type'])) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 	
	foreach($meta_boxes as $meta_box){
		foreach ($meta_box['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = (isset($_POST[$field['id']]))? $_POST[$field['id']] : "";
			
			
			if($field['type']=='checkbox-portfolio-categories'){ 
				if(isset($_POST[$field['id']]) && is_array($_POST[$field['id']]) && count($_POST[$field['id']])>0){
					$values = array_values($_POST[$field['id']]);
					$valuestring = implode(",",$values);
					$new = $valuestring;
					
				}else{
					$_POST[$field['id']] = $new = "";
				}
			}
			
			if($field['type']=='checkbox'){
				if(!isset($_POST[$field['id']])){
					$_POST[$field['id']] = $new = false;
				}
			}
			
			if (isset($_POST[$field['id']]) && $new != $old && (!isset($_POST['_inline_edit']) && !isset($_GET['bulk_edit']))) {
				update_post_meta($post_id, $field['id'], $new);
			}
		}
	}
}