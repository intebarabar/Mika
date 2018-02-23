<?php

class Bar_OrderStatus_Model_Observer
{

    /**
     *
     * @return Varien_Event_Observer $observer
     */

    public function _changesStatusOrder(Varien_Event_Observer $observer)
    {

        $order = $observer->getOrder();

        $orderItems = $order->getAllItems();
        if ($order['status'] == 'ground_order_received') {
            $this->sendEmilChangesStatusOrder($order, $orderItems);
        } elseif ($order['status'] == 'ground_handling_started') {
            $this->sendEmailChangesStatusOrderTwo($order);
        } elseif ($order['status'] == 'mark_orders_sent') {
            $this->sendEmailChangesStatusOrderThree($order);
        }
    }

    public function getOrderItemsAll($items)
    {

        $items_array[] = array();

        $items_array[] .= '<table style="width: 100%">';
        $items_array[] .= '<tr>
                                <td style="color: #ffffff; padding: 10px 0;">Artiklenummer:</td>
                                <td style="color: #ffffff; padding: 10px 0;">Beskrivning:</td>
                                <td style="color: #ffffff; padding: 10px 0;">Antal:</td>
                                <td style="color: #ffffff; padding: 10px 0;">Pris:</td>
                            </tr>';

        foreach ($items as $item) {
            $items_array[] .= '<tr>';
            $items_array[] .= '<td style="color: #ffffff; border-top: solid 2px #ececec; padding: 10px 0;">' . $item->getSku() . '</td>';
            $items_array[] .= '<td style="color: #ffffff; border-top: solid 2px #ececec; padding: 10px 0;">' . $item->getName() . '</td>';
            $items_array[] .= '<td style="color: #ffffff; border-top: solid 2px #ececec; padding: 10px 0;">' . (int)$item->getQtyOrdered() . '</td>';
            $items_array[] .= '<td style="color: #ffffff; border-top: solid 2px #ececec; padding: 10px 0;">' . $item->getPrice() . '</td>';
            $items_array[] .= '</tr>';
        }

        $items_array[] .= '</table>';
        return $items_array;
    }

    public function sendEmilChangesStatusOrder($order, $items)
    {

        $emailTemplate = Mage::getModel('core/email_template');

        $emailTemplate->loadDefault('sale_order_email_changes_status_bar');
        $emailTemplate->setTemplateSubject('Your order # ' . $order->getIncrementId());

        $saleData['email'] = Mage::getStoreConfig('trans_email/ident_general/email');
        $saleData['name'] = Mage::getStoreConfig('trans_email/ident_general/name');

        $emailTemplate->setSenderName($saleData['name']);
        $emailTemplate->setSenderEmail($saleData['email']);

        $emailTemplateVariables['username'] = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
        $emailTemplateVariables['order_id'] = $order->getIncrementId();
        $emailTemplateVariables['store_name'] = $order->getStoreName();
        $emailTemplateVariables['store_url'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

        $itemsProduct = $this->getOrderItemsAll($items);
        $itemsProduct = implode(' ', $itemsProduct);

        $emailTemplateVariables['items'] = $itemsProduct;

        $emailTemplateVariables['orderbar'] = $order;

        $emailTemplate->send($order->getCustomerEmail(), $order->getStoreName(), $emailTemplateVariables);

    }

    public function sendEmailChangesStatusOrderTwo($order)
    {

        $emailTemplate = Mage::getModel('core/email_template');

        $emailTemplate->loadDefault('sale_order_email_changes_status_bar_two');
        $emailTemplate->setTemplateSubject('Message email Bargrossisten');

        $saleData['email'] = Mage::getStoreConfig('trans_email/ident_general/email');
        $saleData['name'] = Mage::getStoreConfig('trans_email/ident_general/name');

        $emailTemplate->setSenderName($saleData['name']);
        $emailTemplate->setSenderEmail($saleData['email']);

        $emailTemplateVariables['username'] = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
        $emailTemplateVariables['order_id'] = $order->getIncrementId();
        $emailTemplateVariables['store_name'] = $order->getStoreName();
        $emailTemplateVariables['store_url'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

        $emailTemplate->send($order->getCustomerEmail(), $order->getStoreName(), $emailTemplateVariables);

    }

    public function sendEmailChangesStatusOrderThree($order)
    {

        $emailTemplate = Mage::getModel('core/email_template');

        $emailTemplate->loadDefault('sale_order_email_changes_status_bar_three');
        $emailTemplate->setTemplateSubject('Message email');

        $saleData['email'] = Mage::getStoreConfig('trans_email/ident_general/email');
        $saleData['name'] = Mage::getStoreConfig('trans_email/ident_general/name');

        $emailTemplate->setSenderName($saleData['name']);
        $emailTemplate->setSenderEmail($saleData['email']);

        $emailTemplateVariables['username'] = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
        $emailTemplateVariables['order_id'] = $order->getIncrementId();
        $emailTemplateVariables['store_name'] = $order->getStoreName();
        $emailTemplateVariables['store_url'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);

        $emailTemplate->send($order->getCustomerEmail(), $order->getStoreName(), $emailTemplateVariables);
    }

}