<?php
class Anowave_TaxSwitch_Model_Observer
{
	public function modify(Varien_Event_Observer $observer)
	{
		if ('page/html_welcome' == $observer->getBlock()->getType())
		{
			$content = $observer->getTransport()->getHtml();
			
			/**
			 * Update transport layer
			 */
			$observer->getTransport()->setHtml($content . Mage::app()->getLayout()->createBlock('taxswitch/switch')->toHtml());
		}

		return true;
	}
	
	public function save(Varien_Event_Observer $observer)
	{
		$group 	 = (int) Mage::app()->getRequest()->getParam('id');
		$display = (int) Mage::app()->getRequest()->getParam('tax_display_setting');
		
		try 
		{
			$config = Mage::getModel('taxswitch/group')->load($group);
			
			$config->setTaxGroupId($group);
			$config->setTaxDisplaySetting($display);
			$config->save();
		}
		catch (Exception $e)
		{
			return true;
		}
	}
}