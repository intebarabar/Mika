<?php

class Bar_Checoutklarna_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {

        $customer = Mage::getModel('customer/customer');
        $websiteId = Mage::app()->getWebsite()->getId();
        $params = $this->getRequest()->getParams();

//        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
//
//            $customer = Mage::getSingleton('customer/session')->getCustomer();
//
//            $customerAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling(); //oder getDefaultShipping
//            if ($customerAddressId) {
//                $address = Mage::getModel('customer/address')->load($customerAddressId);
//                $mydatas['name'] = $address->getFirstname().' '.$address->getLastname();
//                $mydatas['company'] = $address->getCompany();
//                $mydatas['zip'] = $address->getPostcode();
//                $mydatas['city'] = $address->getCity();
//                $street = $address->getStreet();
//                $mydatas['street'] = $street[0];
//                $mydatas['telephone'] = $address->getTelephone();
//                $mydatas['fax'] = $address->getFax();
//                $mydatas['country'] = $address->getCountry();
//            }
//        }else{
//
//        }


        $city = $params['city'];
        $country = $params['country'];
        $postcode= $params['postcode'];
//        $region = $params['region'];
        $street = $params['street'];

        $session = Mage::getSingleton("core/session",  array("name"=>"frontend"));

        if($session->getData("kl_city")){
            $session->unsetData('kl_city');
        }
        if($session->getData("kl_country")){
            $session->unsetData('kl_country');
        }
        if($session->getData("kl_postcode")){
            $session->unsetData('kl_postcode');
        }
//        if($session->getData("kl_region")){
//            $session->unsetData('kl_region');
//        }
        if($session->getData("kl_street")){
            $session->unsetData('kl_street');
        }

        $session->setData("kl_city", trim($city));
        $session->setData("kl_country", trim($country));
        $session->setData("kl_postcode", trim($postcode));
//        $session->setData("kl_region", trim($region));
        $session->setData("kl_street", trim($street));

        $myDeviceId = trim($session->getData("kl_city"));

    }
}