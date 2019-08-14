<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SabioSystem_Installer_Block_Adminhtml_Extension_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    protected function _construct() {
        parent::_construct();
        //$this->setId('cservice_history_grid');
        $this->setDefaultDir('ASC');
        $this->setDefaultSort('id');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection(){
        $collection = Mage::getModel('sabio_installer/extension')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns(){
        $helper = Mage::helper('sabio_installer');
        
        $this->addColumn('name',array(
           'header' =>  $helper->__('Name'),
           'index'  =>  'name',
           'align'  =>  'left'
        ))
        ->addColumn('key',array(
            'header'    =>  $helper->__('Key'),
            'index'     =>  'key'
        ))
        ->addColumn('current_version	',array(
            'header'    =>  $helper->__('Current Version'),
            'index'     =>  'current_version'
        ))
        ->addColumn('newest_version',array(
            'header'    =>  $helper->__('Newest Version'),
            'index'     =>  'newest_version'
        ));

        $this->addColumn('action',
            array(
                'header'    => $helper->__('Action'),
                'width'     => '140px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
	                    array(
		                        'caption' => $helper->__('Edit'),
		                        'url'     => array(
		                        'base'	  =>'*/*/edit',
		                        'params'  =>array('store'=>$this->getRequest()->getParam('store'))
		                        ),
		                    	'field'   => 'id'
	                    ),
                		array(
                				'caption' => $helper->__('Uninstall'),
                				'url'     => array(
                						'base'	  =>'*/*/uninstall',
                						'params'  =>array('store'=>$this->getRequest()->getParam('store'))
                				),
                				'field'   => 'id'
                		),
                		array(
                				'caption' => $helper->__('Delete'),
                				'url'     => array(
                						'base'	  =>'*/*/delete',
                						'params'  =>array('store'=>$this->getRequest()->getParam('store'))
                				),
                				'field'   => 'id'
                		)
                ),
                'filter'    => false,
            	'renderer'  =>  'sabio_installer/adminhtml_extension_column_renderer_action',
                'sortable'  => false,
                'index'     => 'stores',
        ));
    
    } 
}
