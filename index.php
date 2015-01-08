<?php
/**
* Plugin Name: Nitea Category Image
* Plugin URI: http://www.nitea.se/
* Description: Add image to wordpress category 
* Version: 1.0
* Author: Claes Norén
* Author URI: http://www.nitea.se/
**/
function nitea_category_image_html($term){
	wp_enqueue_media();
	wp_enqueue_script('nitea-category-image-function-js', plugin_dir_url( __FILE__ ).'assets/script/function.js');
	wp_enqueue_style('nitea-category-image-style-css', plugin_dir_url( __FILE__ ).'assets/css/style.css');
	$term_id = $term->term_id;
	$term_meta = get_option('taxonomy_'.$term_id);
	return ('
				<div class="nitea-category-image_uploader">
					<img class="nitea-category-image_current-image" src="'.((esc_attr($term_meta['nitea_category_image'])) ? esc_attr($term_meta['nitea_category_image']) : plugin_dir_url( __FILE__ ).'/assets/image/no-image.png').'">
					<input type="hidden" class="nitea-category-image_input" name="term_meta[nitea_category_image]" value="" />
					<input class="button" value="Byt bild" /><br />
					<span class="nitea-category-image_info-text"></span>
				</div>
	');
}
function nitea_category_image_add(){
	echo('
		<label for="term_meta[nitea_category_image]">Kategoribild</label>
		'.nitea_category_image_html($term).'
	');
}
function nitea_category_image_update($term){
	echo('
		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_meta[nitea_category_image]">Kategoribild</label></th>
			<td>
				'.nitea_category_image_html($term).'
			</td>
		</tr>
	');
}

function nitea_category_image(){
	add_action('category_add_form_fields', 'nitea_category_image_add', 10, 2);
	add_action('category_edit_form_fields', 'nitea_category_image_update', 10, 2);
}
add_action('init', 'nitea_category_image', 10, 2);

function nitea_category_image_save($term_id){
	if (isset($_POST['term_meta'])){
		$term_id = $term_id;
		$term_meta = get_option('taxonomy_'.$term_id);
		$cat_keys = array_keys($_POST['term_meta']);
		foreach ($cat_keys AS $key){
			if (isset($_POST['term_meta'][$key])){
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		update_option('taxonomy_'.$term_id, $term_meta);
	}
}
add_action('edited_category', 'nitea_category_image_save', 10, 2);
add_action('create_category', 'nitea_category_image_save', 10, 2);
?>