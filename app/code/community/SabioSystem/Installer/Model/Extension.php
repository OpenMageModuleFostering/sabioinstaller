<?php
class SabioSystem_Installer_Model_Extension extends Mage_Core_Model_Abstract{
	const REPORT_PRIORITY_NOTICE = 4;
	const REPORT_PRIORITY_MINOR = 3;
	const REPORT_PRIORITY_MAJOR = 2;
	const REPORT_PRIORITY_CRITICAL = 1;

	protected function _construct(){
		$this->_init('sabio_installer/extension');
		return parent::_construct();
	}

	public function checkForUpdates(){
		$this->getResource()->checkForUpdates($this);
		return $this;
	}

	public function update(){
		$this->getResource()->update($this);
		return $this;
	}

	public function install(){
		$this->getResource()->install($this);
	}

	public function uninstall(){
		$this->getResource()->uninstall($this);
	}

	public function report($priority,$message){
		$this->getResource()->report($this,$priority,$message);
	}

	public function loadByKey($key){
		return $this->load($key,'key');
	}
}
?>
