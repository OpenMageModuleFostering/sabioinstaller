<?php
class SabioSystem_Installer_Adminhtml_ExtensionController extends Mage_Adminhtml_Controller_Action{
	protected function _getHelper()
	{
		return Mage::helper('sabio_installer');
	}

	public function gridAction()
	{
		
		$this->loadLayout();
		$this->_title($this->__('Extensions list'))->_title($this->__('SABIOinstaller'));
		$this->_setActiveMenu('sabio/instaler');
		$this->renderLayout();
	}
	
	public function updateAction()
	{
		$id = $this->getRequest()->getParam('id');
		Mage::getModel('sabio_installer/extension')->load($id)->update();
		
		$this->_getSession()->addSuccess($this->__('Extension id %s updated successfully',$id));
		
		$this->_getHelper()->clearCache();	
		$this->_redirect('*/*/grid');
		return;
	}
	
	public function checkAction()
	{
		$id = $this->getRequest()->getParam('id');
		Mage::getModel('sabio_installer/extension')->load($id)->checkForUpdates();
		
		$this->_redirect('*/*/grid');
		return;
	}
	public function installAction()
	{
		$id = $this->getRequest()->getParam('id');
		Mage::getModel('sabio_installer/extension')->load($id)->install();
		
		$this->_getSession()->addSuccess($this->__('Extension id %s installed successfully',$id));
		
		$this->_getHelper()->clearCache();	
		$this->_redirect('*/*/grid');
		return;
	}
	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		Mage::getModel('sabio_installer/extension')->load($id)->delete();
		
		$this->_getSession()->addSuccess($this->__('Extension id %s deleted successfully',$id));
		
		$this->_getHelper()->clearCache();	
		$this->_redirect('*/*/grid');
		return;
	}
	public function uninstallAction(){
		$id = $this->getRequest()->getParam('id');
		Mage::getModel('sabio_installer/extension')->load($id)->uninstall();
		
		$this->_getSession()->addSuccess($this->__('Extension id %s uninstalled successfully',$id));
		
		$this->_getHelper()->clearCache();	
		$this->_redirect('*/*/grid');
		return;
	}
	
	public function formAction(){
		$testId = $this->getRequest()->getParam('id');
		$testModel = Mage::getModel('sabio_installer/extension')->load($testId);
		if ($testModel->getId() || $testId == 0)
		{
		
			Mage::register('extension_data', $testModel);
			$this->loadLayout();
			$this->_setActiveMenu('sabio/instaler');
			$this->renderLayout();
		}
		else
		{
			Mage::getSingleton('adminhtml/session')
			->addError('Test does not exist');
			$this->_redirect('*/*/grid');
		}
	}
	
   	public function saveAction()
    {
         if ($this->getRequest()->getPost())
         {
           try {
                 $postData = $this->getRequest()->getPost();
                 $testModel = Mage::getModel('sabio_installer/extension');
                  $testModel
                    ->addData($postData)
                    ->save();
                 Mage::getSingleton('adminhtml/session')
                               ->addSuccess('successfully saved');
                 Mage::getSingleton('adminhtml/session')
                                ->settestData(false);
                 $this->_redirect('*/*/grid');
                return;
          } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')
                                  ->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')
                 ->settestData($this->getRequest()
                                    ->getPost()
                );
                $this->_redirect('*/*/form',
                            array('id' => $this->getRequest()
                                                ->getParam('id')));
                return;
          }
       }
       $this->_redirect('*/*/grid');
    }
    
    public function newAction()
    {
    	$this->_forward('edit');
    }
} 
