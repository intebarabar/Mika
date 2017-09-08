<?php
class Anowave_TaxSwitch_Block_Form extends Mage_Adminhtml_Block_Customer_Group_Edit_Form
{
	const USE_SYSTEM = 0;
	
	public function _prepareLayout()
	{
		parent::_prepareLayout();
		
		$collection = Mage::getModel('taxswitch/group')->getCollection()->addFieldToFilter
		(
			'tax_group_id', $this->getRequest()->getParam('id')
		);
		
		$value = self::USE_SYSTEM;
		
		if ($collection->getSize())
		{
			$value = (int) $collection->getFirstitem()->getTaxDisplaySetting();
		}
		
		$fieldset = $this->getForm()->addFieldset('tax_fieldset', array
		(
			'legend' => Mage::helper('customer')->__('Tax display settings'))
		);
		
		$values = array
		(
			self::USE_SYSTEM => 'Use System'
		);
		
		if (0 != (int) $this->getRequest()->getParam('id'))
		{
			$values[Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX] = 'Incl. tax';
			$values[Mage_Tax_Model_Config::DISPLAY_TYPE_EXCLUDING_TAX] = 'Excl. tax';
			$values[Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH] 		   = 'Both. tax';
		}
		
		$fieldset->addField('tax_display_setting', 'select',array
		(
				'name'  	=> 'tax_display_setting',
				'label' 	=> Mage::helper('customer')->__('Tax display'),
				'title' 	=> Mage::helper('customer')->__('Tax display'),
				'values' 	=> $values,
				'value' 	=> $value
			)
		);
	}
}