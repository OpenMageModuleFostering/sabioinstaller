<?php
class SabioSystem_Installer_Model_XmlRpc{
	const API_CONTROLLER = 'ext_manager';

	protected $_client;
	protected $_session;

	protected function _underscore($cameled){
		return implode('_',array_map('strtolower',preg_split('/([A-Z]{1}[^A-Z]*)/',$cameled,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY)));
	}

	public function __construct(){
		try{
			$this->_client = new Zend_XmlRpc_Client(Mage::getStoreConfig('sabio_installer/api_config/url'));
			$this->_session = $this->_client->call('login',array(Mage::getStoreConfig('sabio_installer/api_config/login'),Mage::getStoreConfig('sabio_installer/api_config/password')));
		}catch(Zend_XmlRpc_Client_HttpException $e){
			Mage::throwException(Mage::helper('sabio_installer')->__('Wrong API URL. Please check SABIOinstaller\'s configuration'));
		}catch(Zend_XmlRpc_Client_FaultException $e){
			Mage::throwException(Mage::helper('sabio_installer')->__('Access to API denied. Please check SABIOinstaller\'s configuration'));
		}
	}	

	public function __call($name, $args){
		try{
			return $this->_client->call('call',array(
				$this->_session,
				self::API_CONTROLLER.'.'.$this->_underscore($name),
				$args			
			));
		}catch(Zend_XmlRpc_Client_FaultException $e){
			Mage::throwException(Mage::helper('sabio_installer')->__($e->getMessage()));
		}
	}
}
?>
