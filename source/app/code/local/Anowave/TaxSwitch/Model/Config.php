<?php
class Anowave_TaxSwitch_Model_Config extends Mage_Tax_Model_Config
{
	public function getPriceDisplayType($store = null)
	{
		if (!Mage::registry('tax_display'))
		{
			if (Mage::app()->getRequest()->getParam('tax_display'))
			{
				$display = Mage::app()->getRequest()->getParam('tax_display');
				
				switch ((int) $display)
				{
					/**
					 * Check if parameter is allowed
					 */
					case self::DISPLAY_TYPE_INCLUDING_TAX:
					case self::DISPLAY_TYPE_EXCLUDING_TAX:
					case self::DISPLAY_TYPE_BOTH:
							Mage::register('tax_display', (int) $display);
						break;
					default:
							/**
							 * Fallback to default configuration
							 */
							Mage::register('tax_display', (int) $this->_getStoreConfig(self::CONFIG_XML_PATH_PRICE_DISPLAY_TYPE, $store));
							break;
				}
				
				Mage::getSingleton("core/session")->setTaxDisplay
				(
					Mage::registry('tax_display')
				);
			}
			else 
			{
				if (Mage::getSingleton('core/session')->getTaxDisplay())
				{
					Mage::register('tax_display', Mage::getSingleton('core/session')->getTaxDisplay());
				}
				else 
				{
					$model = Mage::getModel('taxswitch/group')->load
					(
						Mage::getSingleton('customer/session')->getCustomerGroupId()
					);
					
					if ($model->getTaxDisplaySetting())
					{
						Mage::register('tax_display', $model->getTaxDisplaySetting());	
					}
					else 
					{
						Mage::register('tax_display', (int) $this->_getStoreConfig(self::CONFIG_XML_PATH_PRICE_DISPLAY_TYPE, $store));
					}
				}
			}
		}
		
		if (Mage::registry('tax_display'))
		{
			return Mage::registry('tax_display');
		}
		else 
		{
			return parent::getPriceDisplayType($store);
		}
	}
	
	/**
	 * Retrieve config value for store by path
	 *
	 * @param string $path
	 * @param mixed $store
	 * @return mixed
	 */
	protected function _getStoreConfig($path, $store)
	{
		return Mage::getStoreConfig($path, $store);
	}
}