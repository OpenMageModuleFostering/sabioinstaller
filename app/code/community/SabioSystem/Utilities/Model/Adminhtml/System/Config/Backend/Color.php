<?php

class SabioSystem_Utilities_Model_Adminhtml_System_Config_Backend_Color extends Mage_Core_Model_Config_Data{
    
    public function _beforeSave() {
        
        $color = $this->getValue();  //get colour value from config
        $match = preg_match('/[0-9A-F]+$/i', $color);
        
        if((strlen($color) == 3 || strlen($color) == 6) && $match){
            parent::_beforeSave();
        }
        else{
            Mage::throwException(Mage::helper('sabio_util')->__('Color number contains from 4 or 7 chars. Should strt from "#", and then digits from 0 to 9 and letters from a to f. '));
        }
        
    }
}
