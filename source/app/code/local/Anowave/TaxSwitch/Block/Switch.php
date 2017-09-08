<?php
class Anowave_TaxSwitch_Block_Switch extends Mage_Core_Block_Template 
{
	public function _construct()
	{
		parent::_construct();
		
		$this->setTemplate('taxswitch/switch.phtml');
	}
	
	public function getOptions()
	{
		$current = (Mage::app()->getRequest()->getParam('tax_display') ? Mage::app()->getRequest()->getParam('tax_display') : Mage::getSingleton('core/session')->getTaxDisplay());
		
		if (!$current)
		{
			if (Mage::getSingleton("customer/session")->isLoggedIn())
			{
				$model = Mage::getModel('taxswitch/group')->load
				(
					Mage::getSingleton('customer/session')->getCustomerGroupId()
				);
				
				if ($model->getTaxDisplaySetting())
				{
					$current = $model->getTaxDisplaySetting();
				}
				else 
				{
					$current = Mage::getStoreConfig('tax/display/type',Mage::app()->getStore());
				}
			}
			else 
			{
				$current = Mage::getStoreConfig('tax/display/type',Mage::app()->getStore());
			}
		}
		return array
		(
			new Varien_Object(array
			(
				'value' 	=> Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX,
				'label' 	=> $this->__('Ink. moms'),
				'checked'	=> $current ==  Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX ? 1 : 0
			)),
			new Varien_Object(array
			(
				'value' 	=> Mage_Tax_Model_Config::DISPLAY_TYPE_EXCLUDING_TAX,
				'label' 	=> $this->__('Ex. moms'),
				'checked' 	=> $current ==  Mage_Tax_Model_Config::DISPLAY_TYPE_EXCLUDING_TAX ? 1 : 0
			))
			/* ,
			new Varien_Object(array
			(
				'value' 	=> Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH,
				'label' 	=> $this->__('Both'),
				'checked' 	=> $current ==  Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH ? 1 : 0
			)) */
		);
	}
}