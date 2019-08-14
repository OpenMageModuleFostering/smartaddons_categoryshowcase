<?php
/*------------------------------------------------------------------------
 # SM CategoryShowcase - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_CategoryShowcase_Helper_Data extends Mage_Core_Helper_Abstract {
	public function __construct(){
		$this->defaults = array(
			/* General setting */
			'isenabled'		=> '1',
			'title' 		=> 'SM CategoryShowcase',
			/* Module options */
			'module_width' 		=> '650',							//content_box_width
			'theme' 			=> 'theme1',	
			'num_cols'			=> '1',								// num_products		for theme3 theme4
			'width_cols'		=> '200',							// width_items
			'auto_play'			=> '1',						
			'animation'			=> 'fade',							// effect	
			'interval'			=> '2000',							// timer_speed
			'duration'			=> '600',							// slideshow_speed	

			/* product query */
			//'product_source'				=> 'catalog',
			'product_category' 				=> array(),					// 
			//'product_ids'					=> '',
			'product_order_by'				=> '',						// 
			'product_order_dir' 			=> '',						// 
			'product_limitation' 			=> '6',  					// limit_products
			
			/* product details */
			'product_image_disp'			=> '1',						//show_thumb_image
			'product_image_linkable'		=> '1',						//link_thumb_image
			'product_image_width'			=> '100',					//small_thumb_width
			'product_image_height'			=> '100',					//small_thumb_height
			
			'product_title_disp'			=> '1',						// show_title
			'product_title_linkable'		=> '1',						// link_caption
			'product_title_color'			=> '#000000',				// title_color
			'product_title_max_characters'	=> '15',					// limit_title, count_character
			
			/* category details*/
			//'category_image_disp'			=> '1',						
			'category_image_linkable'		=> '1',						//link_image		
			'category_image_width'			=> '300',					//thumb_width
			'category_image_height'			=> '300',					//thumb_height	
			
			'category_title_disp'			=> '1',						// caption_show
			'category_title_linkable'		=> '1',						// 
			'category_title_color'			=> '#000000',				// 
			//'category_title_max_characters'	=> '15',				// limit_title, count_character			
			
			'product_description_disp' 				=> '1',				//show_description
			'product_description_color'				=> '#000000',				
			'product_description_max_characters' 	=> '100',			//description_max
			
			'product_details_page_link_disp' 		=> '1',				//show_read_more_link
			'product_details_page_link_text' 		=> 'See details',	//read_more_text
			'product_links_target'					=> '_self',			//target
			'product_price_disp'					=> '1',				//show_price
			
			//'count_character'						=> '1',	
			'product_view_all_link_disp'			=> '1',				//show_all_products
			'product_view_all_link_text'			=> '++View all',		//view_all_text
			
			'include_jquery'	=> '1',
			'pretext'			=> '',
			'posttext'			=> ''
			
			/**config_fields**/
		);
	}

	function get($attributes=array())
	{
		$data = $this->defaults;
		$general 					= Mage::getStoreConfig("categoryshowcase_cfg/general");
		$module_setting				= Mage::getStoreConfig("categoryshowcase_cfg/module_setting");
		$product_selection 			= Mage::getStoreConfig("categoryshowcase_cfg/product_selection");
		$product_display_setting 	= Mage::getStoreConfig("categoryshowcase_cfg/product_display_setting");
		$advanced 					= Mage::getStoreConfig("categoryshowcase_cfg/advanced");
		if (!is_array($attributes)) {
			$attributes = array($attributes);
		}
		if (is_array($general))					$data = array_merge($data, $general);
		if (is_array($module_setting)) 			$data = array_merge($data, $module_setting);
		if (is_array($product_selection)) 		$data = array_merge($data, $product_selection);
		if (is_array($product_display_setting)) $data = array_merge($data, $product_display_setting);
		if (is_array($advanced)) 				$data = array_merge($data, $advanced);
		
		return array_merge($data, $attributes);;
	}
}
?>