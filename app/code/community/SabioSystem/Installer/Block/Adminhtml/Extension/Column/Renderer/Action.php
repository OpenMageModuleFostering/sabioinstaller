<?php
class SabioSystem_Installer_Block_Adminhtml_Extension_Column_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action{
	public function _getValue(Varien_Object $row)
	{
		
		$format = ( $this->getColumn()->getFormat() ) ? $this->getColumn()->getFormat() : null;
		$defaultValue = $this->getColumn()->getDefault();
		if (is_null($format)) {
			// If no format and it column not filtered specified return data as is.
			$data = parent::_getValue($row);
			$string = is_null($data) ? $defaultValue : $data;
			return $this->escapeHtml($string);
		}
		elseif (preg_match_all($this->_variablePattern, $format, $matches)) {
			
			// Parsing of format string
			$formattedString = $format;
			foreach ($matches[0] as $matchIndex=>$match) {
				$value = $row->getData($matches[1][$matchIndex]);
				$formattedString = str_replace($match, $value, $formattedString);
			}
			return $formattedString;
		} else {
			preg_match("/^http/", $format , $theSame );
			if( !isset($theSame[0]) && $format != "Delete" && $format != "Uninstall" ){
				$currentVersion = $row->getData('current_version');
				$newsetVersion = $row->getData('newest_version');
				if(!$currentVersion){
					$format = "Install";
				}
				else if(version_compare($currentVersion, $newsetVersion , '<')){
					$format = "Update";
				}
				else if(version_compare($currentVersion, $newsetVersion , '=')){
					$format = "Check for updates";
				}
			}
			return $this->escapeHtml($format);
		}
	}
	
	
	public function render(Varien_Object $row)
	{
		$actions = $this->getColumn()->getActions();
		if ( empty($actions) || !is_array($actions) ) {
			return '&nbsp;';
		}
	
		if(sizeof($actions)==1 && !$this->getColumn()->getNoLink()) {
			foreach ($actions as $action) {
				if ( is_array($action) ) {
					$currentVersion = $row->getData('current_version');
					$newsetVersion = $row->getData('newest_version');
					if($action['url']['base'] != "*/*/delete" && $action['url']['base'] != "*/*/uninstall"){
						if(!$currentVersion){
							$action['url']['base']="*/*/install"; 
						}
						else if(version_compare($currentVersion, $newsetVersion , '<')){
							$action['url']['base']="*/*/update";
						}
						else if(version_compare($currentVersion, $newsetVersion , '=')){
							$action['url']['base']="*/*/check";
						}
					}
					if ($action['url']['base'] != "*/*/uninstall" && $install == 1){
						
					}
					return $this->_toLinkHtml($action, $row);
				}
			}
		}
		
		$i = 0;
		foreach ($actions as $action){
			$i++;
			if ( is_array($action) ) {
				$currentVersion = $row->getData('current_version');
				$newsetVersion = $row->getData('newest_version');
				if($action['url']['base'] != "*/*/delete" && $action['url']['base'] != "*/*/uninstall"){
					if( !$currentVersion){
						$action['url']['base']="*/*/install";
						//return $this->_toLinkHtml($action, $row);
						$install=1;
					}
					else if(version_compare($currentVersion, $newsetVersion , '<')){
						$action['url']['base']="*/*/update";
					}
					else if(version_compare($currentVersion, $newsetVersion , '=')){
						$action['url']['base']="*/*/check";
					}
				}
				if ($action['url']['base'] == "*/*/uninstall" && $install == 1){
					$install=0;
				} else {
					$out .= $this->_toLinkHtml($action, $row). "</br> ";
				}
			}
		}
		return $out;
	}
	
}