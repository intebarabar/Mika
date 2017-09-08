<?php
/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;
$installer->startSetup();
$installer->getConnection()->insertArray(
    $installer->getTable('sales/order_status'),
    array('status', 'label'),
    array(
        array('unprocessed', 'Unprocessed')
    )
);


$installer->getConnection()->insertArray(
    $installer->getTable('sales/order_status_state'),
    array('status', 'state', 'is_default'),
    array(
        array('unprocessed',  'processing',  '0')
    )
);
$installer->endSetup();