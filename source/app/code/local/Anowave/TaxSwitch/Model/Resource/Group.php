<?php
class Anowave_TaxSwitch_Model_Resource_Group extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
    {
        $this->_init('taxswitch/group','tax_group_id');
        
        $this->_isPkAutoIncrement = false;
    }
}