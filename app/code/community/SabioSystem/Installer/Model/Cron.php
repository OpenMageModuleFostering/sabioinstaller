<?php
class SabioSystem_Installer_Model_Cron{
	public function checkForUpdates(){
		Mage::getResourceModel('sabio_installer/extension_collection')->checkForUpdates();
	}
}
?>
