<?php

class SabioSystem_Installer_Block_Adminhtml_Extension_Edit_Form extends
Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
		)
		);
		 
		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('extension_form',
				array('legend'=>$this->__("Information")));
		$fieldset->addField('key', 'text',
				array(
						'label' => $this->__("Key"),
						'class' => 'required-entry',
						'required' => true,
						'name' => 'key',
				));
		

		if ( Mage::registry('extension_data') )
		{
			$form->setValues(Mage::registry('extension_data')->getData());
		}

		return parent::_prepareForm();
	}
}