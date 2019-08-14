<?php
/*------------------------------------------------------------------------
 # SM CategoryShowcase - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_CategoryShowcase_Model_System_Config_Source_OrderBy
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'position',	'label' => Mage::helper('categoryshowcase')->__('Position')),
			array('value' => 'created_at', 	'label' => Mage::helper('categoryshowcase')->__('Date Created')),
			array('value' => 'name', 		'label' => Mage::helper('categoryshowcase')->__('Name')),
			array('value' => 'price', 		'label' => Mage::helper('categoryshowcase')->__('Price')),
			array('value' => 'random', 		'label' => Mage::helper('categoryshowcase')->__('Random')),
			array('value' => 'top_rating', 	'label' => Mage::helper('categoryshowcase')->__('Top Rating')),
			array('value' => 'most_reviewed',	'label' => Mage::helper('categoryshowcase')->__('Most Reviews')),
			array('value' => 'most_viewed',	'label' => Mage::helper('categoryshowcase')->__('Most Visited')),
			array('value' => 'best_sales',	'label' => Mage::helper('categoryshowcase')->__('Most Selling')),
		);
	}
}
