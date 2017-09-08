<?php

class Evolution_Checkout_Block_Checkout_Switcher extends Mage_Core_Block_Template
{

    public $currentStore = false;

    protected function _construct()
    {
        $this->currentStore = Mage::app()->getStore()->getId();
        parent::_construct();
    }


    public function getUrls() {
        $result = array();

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getWebsite()->getStores() as $store) {
            $name = Mage::getStoreConfig('payment/vaimo_klarna_checkout/checkout_tab_name', $store)?: $store->getCode();
            if(Mage::getStoreConfig('payment/vaimo_klarna_checkout/active',$store->getId())) {
                $result[$store->getId()] = array(
                    'url' => $store->getUrl('checkout/'),
                    'name' => $name
                );
            } else {
                $result[$store->getId()] = array(
                    'url' => $store->getUrl('onestepcheckout/'),
                    'name' => $name
                );
            }

        }

        return $result;
    }

}