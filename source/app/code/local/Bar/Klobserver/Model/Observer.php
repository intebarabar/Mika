<?php

class Bar_Klobserver_Model_Observer
{

    public function customOrderAdd(Varien_Event_Observer $observer)
    {
        $session = Mage::getSingleton("core/session", array("name" => "frontend"));
        if($session->getData("kl_city")) {
            $id = Mage::getSingleton('checkout/session')->getLastOrderId();
            $order = Mage::getModel('sales/order')->load($id);

            $order->getShippingAddress()->getId();

            $shippingAddress = Mage::getModel('sales/order_address')->load($order->getShippingAddress()->getId());

            $shippingAddress
                ->setStreet($session->getData("kl_street"))
                ->setCity($session->getData("kl_city"))
                ->setCountry_id($session->getData("kl_country"))
                ->setRegion($session->getData("kl_region"))
//                ->setPostcode($session->getData("kl_postcode"))
                ->save();
        }
        if($session->getData("kl_city")){
            $session->unsetData('kl_city');
        }
        if($session->getData("kl_country")){
            $session->unsetData('kl_country');
        }
//        if($session->getData("kl_postcode")){
//            $session->unsetData('kl_postcode');
//        }
        if($session->getData("kl_region")){
            $session->unsetData('kl_region');
        }
        if($session->getData("kl_street")){
            $session->unsetData('kl_street');
        }

    }

}
