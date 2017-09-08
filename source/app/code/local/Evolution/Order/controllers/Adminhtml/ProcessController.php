<?php

class Evolution_Order_Adminhtml_ProcessController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $orderId = (int)$this->getRequest()->getParam('order_id', false);
        if (
            $orderId
            && ($order = Mage::getModel('sales/order')->load($orderId))
        ) {
            $storeId = $order->getStoreId();
            /** @var $order Mage_Sales_Model_Order */
            if ($order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save()) {
                Mage::getSingleton('core/session')->addSuccess('Status Changed');
            }

            if (Mage::getStoreConfig('sales_email/process_order/enabled', $storeId)) {

                $recipientEmail = $order->getCustomerEmail();

                if ($order->getCustomerIsGuest()) {
                    $templateId = Mage::getStoreConfig('sales_email/process_order/guest_template', $storeId);
                    $recipientName = $order->getBillingAddress()->getName();
                } else {
                    $templateId = Mage::getStoreConfig('sales_email/process_order/template', $storeId);;
                    $recipientName = $order->getCustomerName();
                }

                $senderGroup = Mage::getStoreConfig('sales_email/process_order/identity', $storeId);
                $senderName = Mage::getStoreConfig('trans_email/ident_' . $senderGroup . '/name', $storeId);
                $senderEmail = Mage::getStoreConfig('trans_email/ident_' . $senderGroup . '/email', $storeId);
                $sender = array('name' => $senderName,
                    'email' => $senderEmail);


                // Set variables that can be used in email template
                $vars = array('customerName' => $recipientName,
                    'customerEmail' => $recipientEmail,
                    'order' => $order);

                $translate = Mage::getSingleton('core/translate');

                // Send Transactional Email
                /** @var $mailer Mage_Core_Model_Email_Template */
                $mailer = Mage::getModel('core/email_template');

                if ($copyTo = Mage::getStoreConfig('sales_email/process_order/copy_to', $storeId)) {
                    if (Mage::getStoreConfig('sales_email/process_order/copy_method', $storeId) == 'bcc') {
                        $mailer->addBcc(explode(',', $copyTo));
                    } else {
                        $copyTo = explode(',', $copyTo);
                        foreach ($copyTo as $recipient) {
                            try {
                                $mailer->sendTransactional(
                                    $templateId,
                                    $sender,
                                    $recipient,
                                    $recipientName,
                                    $vars,
                                    $storeId
                                );
                            } catch (Exception $e) {
                                Mage::getSingleton('core/session')->addError($e->getMessage());
                            }
                        }
                    }
                }
                try {
                    $mailer->sendTransactional(
                        $templateId,
                        $sender,
                        $recipientEmail,
                        $recipientName,
                        $vars,
                        $storeId
                    );
                } catch (Exception $e) {
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                }
                Mage::getSingleton('core/session')->addSuccess('Mail Send');
                $translate->setTranslateInline(true);
            }

        }
        $this->_redirectReferer($this->_getRefererUrl());
    }
}