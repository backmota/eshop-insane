<?php

global $wpdb;

$table_name = $wpdb->prefix . "layerslider";
$sliders = $wpdb->get_results( "SELECT * FROM $table_name
							WHERE flag_hidden = '0' AND flag_deleted = '0'
							ORDER BY id ASC LIMIT 200" );

$optlayerslider = array( '' => __('Select Layerslider', THE_LANG) );
if(!empty($sliders)){
	foreach($sliders as $key => $item){
		$name = empty($item->name) ? 'Unnamed' : $item->name;
		$layersliderid = $item->id;
		$optlayerslider["$layersliderid"] = '[layerslider id="'.$item->id.'"] - ' . $name;
	}
}				


/* Option */
$optonoff = array(
	'true' => 'On',
	'false' => 'Off'
);

$optslidertype = array(
	'flexslider' => 'Flexslider',
	'layerslider' => 'LayerSlider'
);

$optlayout = array(
	'' => 'Default',
	'left' => 'Left',
	'right' => 'Right'
);

$opttextalign = array(
	'left' => 'Left',
	'right' => 'Right'
);

$optpcolumns = array(
	'' => 'Default',
	'2' => 'Two Columns',
	'3' => 'Three Columns',
	'4' => 'Four Columns'
);

$optarrange = array(
	'ASC' => 'Ascending',
	'DESC' => 'Descending'
);

$optbgrepeat = array(
	'' => 'Default',
	'repeat' => 'repeat',
	'no-repeat' => 'no-repeat',
	'repeat-x' => 'repeat-x',
	'repeat-y' => 'repeat-y'
);

$optbgattch = array(
	'' => 'Default',
	'scroll' => 'scroll',
	'fixed' => 'fixed'
);

$imagepath =  get_template_directory_uri() . '/images/backendimage/';
$optlayoutimg = array(
	'default' => $imagepath.'mb-default.png',
	'one-col' => $imagepath.'mb-1c.png',
	'two-col-left' => $imagepath.'mb-2cl.png',
	'two-col-right' => $imagepath.'mb-2cr.png'
);
// Create meta box slider
global $meta_boxes;
$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'post-option-meta-box',
	'title' => __('Post Options',THE_LANG),
	'page' => 'post',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Layout','klasik'),
			'desc' => '<em>'.__('Select the layout you want on this specific post/page. Overrides default site layout.','klasik').'</em>',
			'options' => $optlayoutimg,
			'id' => 'klasik_layout',
			'type' => 'selectimage',
			'std' => ''
		),
		array(
			'name' => __('Thumbnail Image URL',THE_LANG),
			'desc' => '<em>'.__('<strong>(optional)</strong> Input the image URL for the post\'s thumbnail image on this post. This URL will overrides featured image.',THE_LANG).'</em>',
			'id' => 'image_url',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'page-option-meta-box',
	'title' => __('Page Options',THE_LANG),
	'page' => 'page',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Layout','klasik'),
			'desc' => '<em>'.__('Select the layout you want on this specific post/page. Overrides default site layout.','klasik').'</em>',
			'options' => $optlayoutimg,
			'id' => 'klasik_layout',
			'type' => 'selectimage',
			'std' => ''
		),
		array(
			'name' => __('Show Breadcrumbs',THE_LANG),
			'desc' => '<em>'.__('Choose \'On\' if you want to show the breadcrumbs.',THE_LANG).'</em>',
			'id' => 'show_breadcrumb',
			'type' => 'select',
			'options' => $optonoff,
			'std' => ''
		),
		array(
			'name' => __('Before Content Text',THE_LANG),
			'desc' => '<em>'.__('Input the text to be located on top of the content',THE_LANG).'</em>',
			'id' => 'beforecontent_text',
			'type' => 'textarea',
			'std' => ''
		),
		array(
			'name' => __('After Content Text',THE_LANG),
			'desc' => '<em>'.__('Input the text to be located in the bottom of the content',THE_LANG).'</em>',
			'id' => 'aftercontent_text',
			'type' => 'textarea',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'page-header-option-meta-box',
	'title' => __('Page Header Options',THE_LANG),
	'page' => 'page',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Header BG Image',THE_LANG),
			'desc' => '<em>'.__('Input the background Header Image URL to change the default header background image from appearance &gt;&gt; theme options.',THE_LANG).'</em>',
			'id' => 'bg_header',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Header BG Repeat',THE_LANG),
			'desc' => '<em>'.__('Select the background repeat to change the default header background repeat from appearance &gt;&gt; theme options.',THE_LANG).'</em>',
			'id' => 'bg_repeat',
			'options' => $optbgrepeat,
			'type' => 'select',
			'std' => ''
		),
		array(
			'name' => __('Header BG Position',THE_LANG),
			'desc' => '<em>'.__('Input the background position to change the default header background position from appearance &gt;&gt; theme options.<br />Example : \'left top\' or \'10px 20px\'',THE_LANG).'</em>',
			'id' => 'bg_pos',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Header BG Attachment',THE_LANG),
			'desc' => '<em>'.__('Select the background attachment to change the default header background attachment from appearance &gt;&gt; theme options.',THE_LANG).'</em>',
			'id' => 'bg_attch',
			'options' => $optbgattch,
			'type' => 'select',
			'std' => ''
		),
		array(
			'name' => __('Header BG Color',THE_LANG),
			'desc' => '<em>'.__('Input the background color to change the default header background color from appearance &gt;&gt; theme options.<br />Example : \'#f0f0f0\'',THE_LANG).'</em>',
			'id' => 'bg_color',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'page-footer-option-meta-box',
	'title' => __('Page Footer Options',THE_LANG),
	'page' => 'page',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Footer BG Image',THE_LANG),
			'desc' => '<em>'.__('Input the background Header Image URL to change the default footer background image from appearance &gt;&gt; theme options.',THE_LANG).'</em>',
			'id' => 'bg_footer',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Footer BG Repeat',THE_LANG),
			'desc' => '<em>'.__('Select the background repeat to change the default footer background repeat from appearance &gt;&gt; theme options.',THE_LANG).'</em>',
			'id' => 'bg_repeat_footer',
			'options' => $optbgrepeat,
			'type' => 'select',
			'std' => ''
		),
		array(
			'name' => __('Footer BG Position',THE_LANG),
			'desc' => '<em>'.__('Input the background position to change the default footer background position from appearance &gt;&gt; theme options.<br />Example : \'left top\' or \'10px 20px\'',THE_LANG).'</em>',
			'id' => 'bg_pos_footer',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Footer BG Color',THE_LANG),
			'desc' => '<em>'.__('Input the background color to change the default footer background color from appearance &gt;&gt; theme options.<br />Example : \'#f0f0f0\'',THE_LANG).'</em>',
			'id' => 'bg_color_footer',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'page-slider-option-meta-box',
	'title' => __('Page Slider Options',THE_LANG),
	'page' => 'page',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Enable Slider',THE_LANG),
			'desc' => '<em>'.__('Choose \'On\' if you want to show the slider.',THE_LANG).'</em>',
			'id' => 'enable_slider',
			'type' => 'select',
			'options' => $optonoff,
			'std' => 'false'
		),
		array(
			'name' => __('Slider Type',THE_LANG),
			'desc' => '<em>'.__('Choose the slider type that you want to use for your slider.',THE_LANG).'</em>',
			'id' => 'slider_type',
			'type' => 'select',
			'options' => $optslidertype,
			'std' => 'flexslider'
		),
		array(
			'name' => __('Slider Category',THE_LANG),
			'desc' => '<em>'.__('You need to select the slider category to make the slider works.',THE_LANG).'</em>',
			'id' => 'slider_category',
			'type' => 'select-slider-category',
			'std' => ''
		),
		array(
			'name' => __('Layer Slider Post',THE_LANG),
			'desc' => '<em>'.__('You need to select the layer slider post to make the layerslider works.',THE_LANG).'</em>',
			'id' => 'slider_layerid',
			'type' => 'select',
			'options' => $optlayerslider,
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'page-portfolio-option-meta-box',
	'title' => __('Page Portfolio Options',THE_LANG),
	'page' => 'page',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Portfolio Columns',THE_LANG),
			'desc' => '<em>'.__('Select the columns of your portfolio.',THE_LANG).'</em>',
			'id' => 'p_column',
			'type' => 'select',
			'options' => $optpcolumns,
			'std' => '3'
		),
		array(
			'name' => __('Portfolio Category',THE_LANG),
			'desc' => '<em>'.__('Select the portfolio category to make the portfolio works.',THE_LANG).'</em>',
			'id' => 'p_category',
			'type' => 'select-portfolio-category',
			'std' => ''
		),
		array(
			'name' => __('Portfolio Categories',THE_LANG),
			'desc' => '<em>'.__('Select more than one portfolio category to make the portfolio filter works.',THE_LANG).'</em>',
			'id' => 'p_categories',
			'type' => 'checkbox-portfolio-categories',
			'std' => ''
		),
		array(
			'name' => __('Portfolio Showposts',THE_LANG),
			'desc' => '<em>'.__('Input the number of portfolio items that you want to show per page.',THE_LANG).'</em>',
			'id' => 'p_showpost',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Portfolio Order By',THE_LANG),
			'desc' => '<em>'.__('(optional). Sort retrieved portfolio items by parameter. Defaults to \'date\'',THE_LANG).'</em>',
			'id' => 'p_orderby',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Portfolio Order',THE_LANG),
			'desc' => '<em>'.__('(optional). Designates the ascending or descending order of the \'Portfolio Order By\' parameter. Defaults to \'DESC\'.',THE_LANG).'</em>',
			'id' => 'p_sort',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'portfolio-option-meta-box',
	'title' => __('Portfolio Options',THE_LANG),
	'page' => 'portofolio',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Layout','klasik'),
			'desc' => '<em>'.__('Select the layout you want on this specific post/page. Overrides default site layout.','klasik').'</em>',
			'options' => $optlayoutimg,
			'id' => 'klasik_layout',
			'type' => 'selectimage',
			'std' => ''
		),
		array(
			'name' => __('Custom Thumbnail',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the custom image URL to override the \'Set Featured Image\'',THE_LANG).'</em>',
			'id' => 'custom_thumb',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('External Link',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the URL if you want to link the portfolio item to another website.',THE_LANG).'</em>',
			'id' => 'external_link',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'testimonial-option-meta-box',
	'title' => __('Testimonial Options',THE_LANG),
	'page' => 'testimonialpost',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Testimonial Thumbnail',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the custom image URL to override the \'Set Featured Image\'',THE_LANG).'</em>',
			'id' => 'testi_thumb',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Testimonial Info',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the additional information (like : employer info or current jobs)in your testimonial.',THE_LANG).'</em>',
			'id' => 'testi_info',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'brand-option-meta-box',
	'title' => __('Brand Options',THE_LANG),
	'page' => 'brand',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Carousel Thumbnail',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the custom image URL to override the \'Set Featured Image\' in [brand_carousel] shortcode',THE_LANG).'</em>',
			'id' => 'carousel_thumb',
			'type' => 'text',
			'std' => ''
		)
	)
);

$meta_boxes[] = array(
	'id' => 'slider-option-meta-box',
	'title' => __('Slider Options',THE_LANG),
	'page' => 'slider',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('External Link',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the URL if you want to link the slider image to another website.',THE_LANG).'</em>',
			'id' => 'external_link',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Custom Image URL',THE_LANG),
			'desc' => '<em>'.__('(optional). You can input the custom image URL to override the \'Set Featured Image\'',THE_LANG).'</em>',
			'id' => 'image_url',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Subtitle',THE_LANG),
			'desc' => '<em>'.__('Input the subtitle of your slider text.',THE_LANG).'</em>',
			'id' => 'subtitle',
			'type' => 'text',
			'std' => ''
		),array(
			'name' => __('Text Align',THE_LANG),
			'desc' => '<em>'.__('Select the text align for your text slider.',THE_LANG).'</em>',
			'id' => 'text_align',
			'type' => 'select',
			'options' => $opttextalign,
			'std' => 'left'
		),
		array(
			'name' => __('Slider BG Image',THE_LANG),
			'desc' => '<em>'.__('(optional). Input the background Slider Image URL to override the \'Set Featured Image\'.',THE_LANG).'</em>',
			'id' => 'bgslide_img',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Slider BG Repeat',THE_LANG),
			'desc' => '<em>'.__('Select the background repeat for your slider.',THE_LANG).'</em>',
			'id' => 'bgslide_repeat',
			'options' => $optbgrepeat,
			'type' => 'select',
			'std' => ''
		),
		array(
			'name' => __('Slider BG Position',THE_LANG),
			'desc' => '<em>'.__('Input the background position for your slider.<br />Example : \'left top\' or \'10px 20px\'',THE_LANG).'</em>',
			'id' => 'bgslide_pos',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Slider BG Attachment',THE_LANG),
			'desc' => '<em>'.__('(optional). Select the background attachment for your slider.',THE_LANG).'</em>',
			'id' => 'bgslide_attch',
			'options' => $optbgattch,
			'type' => 'select',
			'std' => ''
		),
		array(
			'name' => __('Slider BG Color',THE_LANG),
			'desc' => '<em>'.__('(optional). Input the background color for your slider.',THE_LANG).'</em>',
			'id' => 'bgslide_color',
			'type' => 'text',
			'std' => ''
		),
	)
);

$meta_boxes[] = array(
	'id' => 'product-option-meta-box',
	'title' => __('Product Layout',THE_LANG),
	'page' => 'product',
	'showbox' => 'meta_option_show_box',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Layout','klasik'),
			'desc' => '<em>'.__('Select the layout you want on this specific post/page. Overrides default site layout.','klasik').'</em>',
			'options' => $optlayoutimg,
			'id' => 'klasik_layout',
			'type' => 'selectimage',
			'std' => ''
		)
	)
);