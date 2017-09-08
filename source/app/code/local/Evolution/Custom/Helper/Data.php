<?php

class Evolution_Custom_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isOrderGrid() {
        return Mage::app()->getRequest()->getControllerName() == 'sales_order';
    }
}