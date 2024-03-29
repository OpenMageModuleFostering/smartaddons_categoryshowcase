<?php
/*------------------------------------------------------------------------
 # SM CategoryShowcase - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_CategoryShowcase_Model_System_Config_Source_ListTheme
{
	public function toOptionArray()
	{	
		return array(
		array('value'=>'theme1', 'label'=>Mage::helper('categoryshowcase')->__('Theme 01')),
		array('value'=>'theme2', 'label'=>Mage::helper('categoryshowcase')->__('Theme 02')),
		array('value'=>'theme3', 'label'=>Mage::helper('categoryshowcase')->__('Theme 03')),
		array('value'=>'theme4', 'label'=>Mage::helper('categoryshowcase')->__('Theme 04')),
		);
	}
}
