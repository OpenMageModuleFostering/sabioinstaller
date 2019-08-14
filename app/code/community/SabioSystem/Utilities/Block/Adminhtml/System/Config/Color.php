<?php

class SabioSystem_Utilities_Block_Adminhtml_System_Config_Color extends  Mage_Adminhtml_Block_System_Config_Form_Field{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $element->addClass('colorpicker')->getElementHtml();
    }
}
