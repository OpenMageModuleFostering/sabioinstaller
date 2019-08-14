<?php
abstract class SabioSystem_Utilities_Model_Resource_Db_Abstract extends Mage_Core_Model_Resource_Db_Abstract{
	protected function _getLoadSelect($field,$value,$object){
		if (!is_array($field)){
			$field = array($field);
		}
		if (!is_array($value)){
			$value = array($field[0]=>$value);
		}
		if (count($value) != count($field)){
			Mage::throwException('Field and value arrays have different length');
		}
		$select = $this->_getReadAdapter()->select() 
			->from($this->getMainTable());
		foreach($field as $k=>$f){
			$quote = $this->_getReadAdapter()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $f));
			$select->where($quote.'=?',$value[$f]);
		}
		return $select;
	}
}
