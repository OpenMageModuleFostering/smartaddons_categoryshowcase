<?php
/*------------------------------------------------------------------------
 # SM CategoryShowcase - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_CategoryShowcase_Model_System_Config_Source_LinkTargets
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'_self',	'label'=>Mage::helper('categoryshowcase')->__('Same Window')),
        	array('value'=>'_blank','label'=>Mage::helper('categoryshowcase')->__('New Window')),
			array('value'=>'_popup','label'=>Mage::helper('categoryshowcase')->__('Popup Window'))
		);
	}
}
