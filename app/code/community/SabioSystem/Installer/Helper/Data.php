<?php
class SabioSystem_Installer_Helper_Data extends Mage_Core_Helper_Data{
	public function clearCache(){
		Mage::app()->cleanCache();
		return $this;
	}
}
?>
