<?php
class SabioSystem_Installer_Block_Adminhtml_Extension extends Mage_Adminhtml_Block_Widget_Grid_Container{
	
	protected $_blockGroup = 'sabio_installer';
	protected $_controller = 'adminhtml_extension';
	
	public function __construct(){
		parent::__construct();
	}
	
	public function _construct(){
		$this->_headerText = Mage::helper('sabio_installer')->__('SABIO extension');
		parent::_construct();
	}
	
	public function getCreateUrl()
	{
		return $this->getUrl('*/*/form');
	}
}