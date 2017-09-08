<?php

class PG_CustomColumn_Block_Customcolumn extends Mage_Core_Block_Template
{
    public function getCategoriesList()
    {
        $store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
        $categoryId = $store->getRootCategoryId();
        $cat = Mage::getModel('catalog/category')->load($categoryId);
        $subcategoryIds = $cat->getChildren();
        $categoryCollection = Mage::getModel('catalog/category')->getCollection();
        $categoryCollection->addAttributeToSelect('*');
        $categoryCollection->addIdFilter($subcategoryIds);
        $categoryCollection->addIsActiveFilter();
        $categoryCollection->addAttributeToFilter('include_in_menu', 1)
        ->addAttributeToSort('position');
        return $categoryCollection;

    }
}