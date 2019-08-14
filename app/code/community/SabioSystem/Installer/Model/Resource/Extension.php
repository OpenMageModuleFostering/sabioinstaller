<?php
class SabioSystem_Installer_Model_Resource_Extension extends Mage_Core_Model_Resource_Db_Abstract{
	const TMP_DIR = '/ext_manager';

	protected $_extensionMap=array();

	protected function _construct(){
		$this->_init('sabio_installer/extension','id');
		$this->_serializableFields['map'] = array(null,array());
	}
	protected function _addExtension($object){
		$xmlRpc = Mage::getSingleton('sabio_installer/xmlRpc');
		$object->setName($xmlRpc->getName($object->getKey()));
		$object->setNewestVersion($xmlRpc->getVersion($object->getKey()));

		return $this;
	}
	protected function _merge($parent=null,$target=null){
		$dir = opendir($parent);
		while($name = readdir($dir)){
			if ($name == '..' || $name == '.'){
				continue;
			}
			$entry = $parent.$name;
			$entry_target = $target.$name;
			if ($_isDir=is_dir($entry)){
				$entry = $entry.'/';
				$entry_target = $entry_target.'/';
			}

			if($_isDir){
				if(!is_dir($entry_target)){
					mkdir($entry_target);
				}
			}else{
				if(is_file($entry_target)){
					unlink($entry_target);
				}
				rename($entry,$entry_target);
			}
			$this->_extensionMap[] = $entry_target;

			if ($_isDir){
				$this->_merge($entry,$entry_target);
				rmdir($entry);
			}
			
		}

		rmdir(Mage::getBaseUrl().self::TMP_DIR);

		return $this;
	}
	protected function _unpack($archive){
		$dir = Mage::getBaseDir().'/tmp.tgz';

		$f = fopen($dir,'w');
		fwrite($f,$archive);
		fclose($f);
		$p = new PharData($dir);
		$p->decompress();
		unlink($dir);
		$dir = Mage::getBaseDir().'/tmp.tar';
		$p = new PharData($dir);
		$p->extractTo(Mage::getBaseDir().self::TMP_DIR);
		unlink($dir);

		$this->_extensionMap = array();

		return $this;
	}
	protected function _beforeSave($object){
		if(!$object->getId()){
			$this->_addExtension($object);
		}
		if($object->getMap()){
			$object->setMap(serialize($object->getMap()));
		}
		return parent::_beforeSave();
	}
	protected function _beforeDelete($object){
		if($object->getCurrentVersion()){
			$this->uninstall($object);
		}
		return parent::_beforeDelete();
	}

	public function excludeUsedFromMap($object){
		$map = unserialize($object->getMap());
		foreach ($map as $path){
			if(($key=array_search($path,$this->_extensionMap)) !== false){
				unset($this->_extensionMap[$key]);
			}
		}

		return $this;
	}

	public function install($object){
		$xmlRpc = Mage::getSingleton('sabio_installer/xmlRpc');
		$object->setNewestVersion($xmlRpc->getVersion($object->getKey()));

		$this->_unpack(base64_decode($xmlRpc->install($object->getKey(),Mage::getBaseUrl())))
			->_merge(Mage::getBaseDir().self::TMP_DIR.'/',Mage::getBaseDir().'/');

		$object->setCurrentVersion($object->getNewestVersion());
		$object->setMap($this->_extensionMap);
		$object->save();

		return $this;
	}

	public function update($object){
		$this->checkForUpdates($object);
		if(version_compare($object->getNewestVersion(),$object->getCurrentVersion(),'>')){
			$xmlRpc = Mage::getSingleton('sabio_installer/xmlRpc');
			$this->_unpack(base64_decode($xmlRpc->update($object->getKey(),Mage::getBaseUrl())))
				->_merge(Mage::getBaseDir().self::TMP_DIR.'/',Mage::getBaseDir().'/');

			$object->setCurrentVersion($object->getNewestVersion());
			$object->setMap($this->_extensionMap);
			$object->save();
		}

		return $this;
	}

	public function checkForUpdates($object){
		$xmlRpc = Mage::getSingleton('sabio_installer/xmlRpc');

		$newest = $xmlRpc->checkForUpdates($object->getKey(),Mage::getBaseUrl());
		if(version_compare($newest,$object->getNewestVersion(),'>')){
			$object->setNewestVersion($newest);
			$object->save();
		}

		return $this;
	}

	public function uninstall($object){
		if(true || $object->getCurrentVersion()){
			$xmlRpc = Mage::getSingleton('sabio_installer/xmlRpc');
			$xmlRpc->uninstall($object->getKey(),Mage::getBaseUrl());

			$this->_extensionMap = $object->getMap();

			Mage::getResourceModel($this->_resourceModel.'/'.$this->_mainTable.'_collection')
				->addFieldToFilter('id',array('neq'=>$object->getId()))
				->walk(array($this,'excludeUsedFromMap'));

			foreach($this->_extensionMap as $path){
				if(is_file($path)){
					unlink($path);
				}
			}

			$object->setMap(null);
			$object->setCurrentVersion(null);
			$object->save();
		}
		return $this;
	}

	public function report($object,$priority,$message){
		$xmlRpc = Mage::getSingleton('sabio_installer/xmlRpc');
		$xmlRpc->reportError($object->getKey(),Mage::getBaseUrl(),$priority,$message);

		return $this;
	}
}
?>
