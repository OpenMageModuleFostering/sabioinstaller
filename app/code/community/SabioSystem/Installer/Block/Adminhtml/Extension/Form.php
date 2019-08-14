<?php

class SabioSystem_Installer_Block_Adminhtml_Extension_Form extends
Mage_Adminhtml_Block_Widget_Form_Container{
	public function __construct()
	{
		$data = array(
				'label' =>  'Back',
				'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/grid') . '\')',
				'class'     =>  'back'
		);
		$this->addButton ('my_back', $data, 100);
		parent::__construct();
		//$this->_objectId = 'id';
		//vwe assign the same blockGroup as the Grid Container
		$this->_blockGroup = 'sabio_installer';
		//and the same controller
		$this->_controller = 'adminhtml_extension';
		//define the label for the save and delete button

		$this->_updateButton('save', 'label','Save item');
		$this->_updateButton('delete', 'label', 'Delete item');
		$this->_headerText = Mage::helper('sabio_installer')->__('Sabio Edit Products');
		$this->_removeButton('back');
	}
	/* Here, we're looking if we have transmitted a form object,
	 to update the good text in the header of the page (edit or add) */

}