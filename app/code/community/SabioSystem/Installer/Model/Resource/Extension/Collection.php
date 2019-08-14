<?php
class SabioSystem_Installer_Model_Resource_Extension_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected function _construct(){
		$this->_init('sabio_installer/extension');
		parent::_construct();
	}

	public function update(){
		$this->walk('update');
		return $this;
	}

	public function checkForUpdates(){
		$this->walk('checkForUpdates');
		return $this;
	}

	public function loadUpgradeable(){
		$this->getSelect()->where('`main_table`.`current_version` <> `main_table`.`newest_version`');
		return $this;
	}
}
?>
