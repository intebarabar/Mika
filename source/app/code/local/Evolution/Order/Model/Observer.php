<?php

class Evolution_Order_Model_Observer
{
    public function adminhtmlBlockHtmlBefore($observer)
    {
        $key = Mage::helper('core')->getHash('process' . 'index' . Mage::getSingleton('core/session')->getFormKey());
        if ($observer->getEvent()->getBlock()->getNameInLayout() == 'sales_order_edit') {
            $massActionBlock = $observer->getEvent()->getBlock();
            $massActionBlock->addButton('process', array(
                'label' => Mage::helper('core')->__('Process'),
                'onclick' => "javascript:window.setLocation('" .Mage::helper("adminhtml")->getUrl("*/process/index" , array('key' =>  $key, 'order_id' => Mage::app()->getRequest()->getParam('order_id'))) . "')",
                'class' => 'button'
            ));
        }
    }

}