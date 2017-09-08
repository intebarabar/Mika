<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Create order status form
 */
class Magedev_Ordermanager_Block_Adminhtml_Order_Status_New_Form extends Mage_Adminhtml_Block_Sales_Order_Status_New_Form
{
     /**
     * Prepare form fields and structure
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
         $model  = Mage::registry('current_status');
        $labels = $model ? $model->getStoreLabels() : array();

        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('sales')->__('Order Status Information')
        ));

        $fieldset->addField('is_new', 'hidden', array('name' => 'is_new', 'value' => 1));

        $fieldset->addField('status', 'text',
            array(
                'name'      => 'status',
                'label'     => Mage::helper('sales')->__('Status Code'),
                'class'     => 'required-entry validate-code',
                'required'  => true,
            )
        );

        $fieldset->addField('label', 'text',
            array(
                'name'      => 'label',
                'label'     => Mage::helper('sales')->__('Status Label'),
                'class'     => 'required-entry',
                'required'  => true,
            )
        );

      $eventElem = $fieldset->addField('colour', 'text',
            array(
                'name'      => 'colour',
                'label'     => Mage::helper('sales')->__('Colour Code'),
               // 'class'     => 'required-entry',
                'required'  => false,
				//'class'     => 'colorpicker',
            )
        );
		
		$jsPath = Mage::getBaseUrl('js');
		$eventElem->setAfterElementHtml("<script>   ProColor.prototype.attachButton( 'colour' ,{ imgPath:'$jsPath/cjscolor/img/procolor_win_', showInField: true }); </script>");
		

        $fieldset = $form->addFieldset('store_labels_fieldset', array(
            'legend'       => Mage::helper('sales')->__('Store View Specific Labels'),
            'table_class'  => 'form-list stores-tree',
        ));
        $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset');
        $fieldset->setRenderer($renderer);

        foreach (Mage::app()->getWebsites() as $website) {
            $fieldset->addField("w_{$website->getId()}_label", 'note', array(
                'label'    => $website->getName(),
                'fieldset_html_class' => 'website',
            ));
            foreach ($website->getGroups() as $group) {
                $stores = $group->getStores();
                if (count($stores) == 0) {
                    continue;
                }
                $fieldset->addField("sg_{$group->getId()}_label", 'note', array(
                    'label'    => $group->getName(),
                    'fieldset_html_class' => 'store-group',
                ));
                foreach ($stores as $store) {
                    $fieldset->addField("store_label_{$store->getId()}", 'text', array(
                        'name'      => 'store_labels['.$store->getId().']',
                        'required'  => false,
                        'label'     => $store->getName(),
                        'value'     => isset($labels[$store->getId()]) ? $labels[$store->getId()] : '',
                        'fieldset_html_class' => 'store',
                    ));
                }
            }
        }

        if ($model) {
            $form->addValues($model->getData());
        }
        $form->setAction($this->getUrl('*/sales_order_status/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return Mage_Adminhtml_Block_Widget_Form::_prepareForm();
    }
}
