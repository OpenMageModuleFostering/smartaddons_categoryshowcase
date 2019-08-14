<?php
/*------------------------------------------------------------------------
 # SM CategoryShowcase - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
 -------------------------------------------------------------------------*/


class Smartaddons_CategoryShowcase_Model_System_Config_Source_ListEffectType
{
	public function toOptionArray()
	{
		return array(
		array('value'=>'fade', 'label'=>Mage::helper('categoryshowcase')->__('Fade')),
		array('value'=>'fadeZoom', 'label'=>Mage::helper('categoryshowcase')->__('Fade Zoom')),
		array('value'=>'zoom', 'label'=>Mage::helper('categoryshowcase')->__('Zoom')),
			
		array('value'=>'shuffle', 'label'=>Mage::helper('categoryshowcase')->__('Shuffle')),
		array('value'=>'toss', 'label'=>Mage::helper('categoryshowcase')->__('Toss')),
		array('value'=>'wipe', 'label'=>Mage::helper('categoryshowcase')->__('Wipe')),
			
		array('value'=>'cover', 'label'=>Mage::helper('categoryshowcase')->__('Cover')),
		array('value'=>'uncover', 'label'=>Mage::helper('categoryshowcase')->__('Uncover')),
		array('value'=>'blindX', 'label'=>Mage::helper('categoryshowcase')->__('Blind X')),
			
		array('value'=>'blindY', 'label'=>Mage::helper('categoryshowcase')->__('Blind Y')),
		array('value'=>'blindZ', 'label'=>Mage::helper('categoryshowcase')->__('Blind Z')),
		array('value'=>'growY', 'label'=>Mage::helper('categoryshowcase')->__('Grow Y')),
			
		array('value'=>'curtainX', 'label'=>Mage::helper('categoryshowcase')->__('Curtain X')),
		array('value'=>'curtainY', 'label'=>Mage::helper('categoryshowcase')->__('Curtain Y')),
		array('value'=>'slideX', 'label'=>Mage::helper('categoryshowcase')->__('Slide X')),
			
		array('value'=>'slideY', 'label'=>Mage::helper('categoryshowcase')->__('Slide Y')),
		array('value'=>'turnUp', 'label'=>Mage::helper('categoryshowcase')->__('Turn Up')),
		array('value'=>'turnDown', 'label'=>Mage::helper('categoryshowcase')->__('Turn Down')),
			
		array('value'=>'turnLeft', 'label'=>Mage::helper('categoryshowcase')->__('Turn Left')),
		array('value'=>'turnRight', 'label'=>Mage::helper('categoryshowcase')->__('Turn Right')),
		array('value'=>'scrollRight', 'label'=>Mage::helper('categoryshowcase')->__('Scroll Right')),
			
		array('value'=>'scrollLeft', 'label'=>Mage::helper('categoryshowcase')->__('Scroll Left')),
		array('value'=>'scrollUp', 'label'=>Mage::helper('categoryshowcase')->__('Scroll Up')),
		array('value'=>'scrollDown', 'label'=>Mage::helper('categoryshowcase')->__('Scroll Down')),	
		
		array('value'=>'random', 'label'=>Mage::helper('categoryshowcase')->__('Random')),
		);
	}
}
