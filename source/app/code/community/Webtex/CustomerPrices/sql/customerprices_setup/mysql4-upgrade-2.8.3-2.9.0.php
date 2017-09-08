<?php
/**
 * Webtex
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Webtex EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.webtex.com/LICENSE-1.0.html
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@webtex.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.webtex.com/ for more information
 * or send an email to sales@webtex.com
 *
 * @category   Webtex
 * @package    Webtex_CustomerPrices
 * @copyright  Copyright (c) 2010 Webtex (http://www.webtex.com/)
 * @license    http://www.webtex.com/LICENSE-1.0.html
 */

/**
 * Customer Prices extension
 *
 * @category   Webtex
 * @package    Webtex_CustomerPrices
 * @author     Webtex Dev Team <dev@webtex.com>
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('customerprices/prices')} add constraint `FK_CUSTOMER_PRICES_PRODUCT_ID` foreign key (`product_id`)
           REFERENCES `{$this->getTable('catalog/product')}` (`entity_id`) ON DELETE CASCADE;

ALTER TABLE {$this->getTable('customerprices/prices')} add constraint `FK_CUSTOMER_PRICES_CUSTOMER_ID` foreign key (`customer_id`)
           REFERENCES `{$this->getTable('customer/entity')}` (`entity_id`) ON DELETE CASCADE;
");

$installer->endSetup();
