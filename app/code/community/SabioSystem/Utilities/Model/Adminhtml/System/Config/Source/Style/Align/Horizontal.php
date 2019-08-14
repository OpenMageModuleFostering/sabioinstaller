<?php

class SabioSystem_Utilities_Model_Adminhtml_System_Config_Source_Style_Align_Horizontal {
	public function toOptionArray(){
		return array(
		array('value'=> 'left'   , 'label'=>Mage::helper('sabio_util')->__('Left')),
		array('value'=> 'right'  , 'label'=>Mage::helper('sabio_util')->__('Right')),
		array('value'=> 'center' , 'label'=>Mage::helper('sabio_util')->__('Center')),
		array('value'=> 'justyfy', 'label'=>Mage::helper('sabio_util')->__('Justify'))
		);
	}
}

?>
