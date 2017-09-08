<?php

/**
 * Class Bar_OrderInventory_Block_Adminhtml_OrderInventory_Grid_Render_Inventory
 */
class Bar_OrderInventory_Block_Adminhtml_Ordermanager_Grid_Renderer_Target extends Magedev_Ordermanager_Block_Adminhtml_Ordermanager_Grid_Renderer_Target
{

    /**
     * @param Varien_Object $row
     * @return string
     *
     */

    public function render(Varien_Object $row)
    {
        //echo '<pre>';print_r($row);die;
        $order_id = $row['increment_id'];
        $result = "";

        $orderId = $row->getId();

        //$order = Mage::getModel('sales/order')->load($order_id);echo '<pre>';print_r($order);die;
        $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);

        $items = $order->getAllVisibleItems();
        //echo '<pre>';print_r($items);die;

        $viewImage = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/btn_show-hide_icon.gif';
        $customerViewImage = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/fam_user.gif';
        $customerSpeak = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/speak.gif';
        $adminNoteforOrder = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/fam_user_edit.gif';
        $productItemOk = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/fam_bullet_success.gif';
        $productItemOff = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/error_msg_icon.gif';

        $closeImage = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'adminhtml/default/default/images/rule_component_remove.gif';

        $itemcount = count($items);
        $name = array();
        $unitPrice = array();
        $sku = array();
        $ids = array();
        $qty = array();

        $block = $this->getLayout()->createBlock('ordermanager/adminhtml_ordermanager')
            ->setData('order', $order)
            ->setTemplate('orderinventory/detail.phtml');
        echo $block->renderView();


        /*		$customerBlock = $this->getLayout()->createBlock('ordermanager/adminhtml_ordermanager')
                       ->setData('order',$order)
                       ->setTemplate('ordermanager/customerdetail.phtml');
                 echo $customerBlock->renderView();

                 $adminSpeakBlock = $this->getLayout()->createBlock('ordermanager/adminhtml_ordermanager')
                       ->setData('order',$order)
                       ->setTemplate('ordermanager/customer_talk.phtml');
                 echo $adminSpeakBlock->renderView();

                 $adminCommentBlock = $this->getLayout()->createBlock('ordermanager/adminhtml_ordermanager')
                       ->setData('order',$order)
                       ->setTemplate('ordermanager/admin_comment.phtml');
                 echo $adminCommentBlock->renderView();*/


        $stockItemInventory = false;

        foreach ($items as $itemId => $item) {
            $_productId = $item->getProductId();
            $_product = Mage::getModel('catalog/product')->load($_productId);
            $boll = $_product->getStockItem()->getQty();
            if ($boll <= 0) {
                $stockItemInventory = true;
                break;
            }

        }

        $jsOrderId = "'d_" . $orderId . "'";
        $jsCusOrderId = "'c_" . $orderId . "'";
        $jsSpeakOrderId = "'s_" . $orderId . "'";
        $jsEditOrderId = "'e_" . $orderId . "'";
        $jsInventory = "'in_" . $orderId . "'";
        $jsOnventory = "'on_" . $orderId . "'";

        $result .= '<a href="javascript:void(0);"><div style="width:200px;"><img style="margin-left:5px;"  alt="Products Detail" title="Products Detail"  onclick="showDetail(' . $jsOrderId . ');" src="' . $viewImage . '" />';
        $result .= '<img style="margin-left:5px;" onclick="hideDetail(' . $jsOrderId . ')" src="' . $closeImage . '" />';

        $result .= '<img style="margin-left:5px;" alt="Order Detail" title="Order Detail" onclick="showCusDetail(' . $jsCusOrderId . ');" src="' . $customerViewImage . '" />';
        $result .= '<img style="margin-left:5px;" onclick="hideCusDetail(' . $jsCusOrderId . ')" src="' . $closeImage . '" />';

        $result .= '<img style="margin-left:5px;height:18px;" alt="Speak To Client" title="Speak To Client" onclick="showSpeakDetail(' . $jsSpeakOrderId . ');" src="' . $customerSpeak . '" />';
        $result .= '<img style="margin-left:5px;" onclick="hideSpeakDetail(' . $jsSpeakOrderId . ')" src="' . $closeImage . '" />';

        $result .= '<img style="margin-left:5px;" alt="Order Special Note" title="Order Special Note"  onclick="showEditDetail(' . $jsEditOrderId . ');" src="' . $adminNoteforOrder . '" />';
        $result .= '<img style="margin-left:5px;" onclick="hideEditDetail(' . $jsEditOrderId . ')" src="' . $closeImage . '" />';

        if ($stockItemInventory) {
            $result .= '<img style="margin-left:5px;" alt="Inventory off stock" title="Inventory off stock"  onclick="showInventoryDetail(' . $jsInventory . ');" src="' . $productItemOff . '" />';
            $result .= '<img style="margin-left:5px;" onclick="hideEditDetail(' . $jsInventory . ')" src="' . $closeImage . '" /></div></a>';

        } else {
            $result .= '<img style="margin-left:5px;" alt="Inventory on stock" title="Inventory on stock"  onclick="showInventoryDetail(' . $jsOnventory . ');" src="' . $productItemOk . '" />';
            $result .= '<img style="margin-left:5px;" onclick="hideEditDetail(' . $jsOnventory . ')" src="' . $closeImage . '" /></div></a>';
        }
        $itemOnGrid = Mage::getStoreConfig('orderview/general/hide_product_view');

        if ($itemOnGrid == 0) {

            //$result .='<td style="font-weight:bold;">Image</td> <td style="font-weight:bold;">Qty</td>
            //	   <td style="font-weight:bold;">Product</td><td style="font-weight:bold;">Status</td> <td style="font-weight:bold;">Price</td></tr>';
            //	$result .='<td style="font-weight:bold;">Image</td>  <td style="font-weight:bold;">Product</td> </tr>';
        }

        $i = 1;
        $_coreHelper = Mage::helper('core');

        $imageSize = Mage::getStoreConfig('orderview/general/product_thumb_size');
        $productCountOnGrid = Mage::getStoreConfig('orderview/general/product_count');

        foreach ($items as $itemId => $item) {
            //echo '<pre>';print_r($item);die;
            $productName = $item->getName();
            $_productId = $item->getProductId();
            $_product = Mage::getModel('catalog/product')->load($_productId);

//            Zend_Debug::dump($item->getStockItem()); die;

            if ($_product->getImage() != 'no_selection') {
                $productImage = Mage::helper('catalog/image')->init($_product, 'image')->resize($imageSize);
                $imgHeightWidth = "";
            } else {
                $productImage = Mage::getDesign()->getSkinUrl('images/placeholder/thumbnail.jpg');
                $imgHeightWidth = " width='50px;' height='50px;' ";
            }

            //$productImage = Mage::helper('catalog/image')->init($_product, 'image')->resize($imageSize);

            if ($itemOnGrid == 0) {
                $result .= '<div style="clear:both;"><div style="float:left;width:29%"><img ' . $imgHeightWidth . ' src="' . $productImage . '" /></div><div style="margin:3px;">' . $productName . '</div></div>';
            }
            if ($i >= $productCountOnGrid) break;
            $i++;
        }
        return $result;
    }
}