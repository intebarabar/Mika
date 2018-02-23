<?php

class SmashingMagazine_MyCarrier_Model_Fract extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface{

    protected $_code = 'privatkunds_fract';

    public function collectRates(Mage_Shipping_Model_Rate_Request $request){
        $result = Mage::getModel('shipping/rate_result');
        /* @var $result Mage_Shipping_Model_Rate_Result */

        $result->append($this->_getFractShippingRate());

        $expressWeightThreshold =
            $this->getConfigData('express_weight_threshold');

        $eligibleForExpressDelivery = true;
        foreach ($request->getAllItems() as $_item) {
            if ($_item->getWeight() > $expressWeightThreshold) {
                $eligibleForExpressDelivery = false;
            }
        }

        if ($eligibleForExpressDelivery) {
            $result->append($this->_getExpressShippingRate());
        }

        if ($request->getFreeShipping()) {
            /**
             *  If the request has the free shipping flag,
             *  append a free shipping rate to the result.
             */
            $freeShippingRate = $this->_getFreeShippingRate();
            $result->append($freeShippingRate);
        }

        return $result;
    }

    protected function _getFractShippingRate() {
        $rate = Mage::getModel('shipping/rate_result_method');
        /* @var $rate Mage_Shipping_Model_Rate_Result_Method */

        $rate->setCarrier($this->_code);
        /**
         * getConfigData(config_key) returns the configuration value for the
         * carriers/[carrier_code]/[config_key]
         */
        $rate->setCarrierTitle($this->getConfigData('title'));

        $rate->setMethod('fract');
        $rate->setMethodTitle($this->getConfigData('title'));

        $rate->setPrice($this->getConfigData('price'));
//        $rate->setPrice(77.05);
        $rate->setCost(0);

        return $rate;
    }


    public function getAllowedMethods() {
        return array(
            'fract' => 'Fract',
        );
    }
}