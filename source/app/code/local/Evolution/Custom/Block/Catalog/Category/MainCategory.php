<?php

class Evolution_Custom_Block_Catalog_Category_MainCategory extends Mage_Core_Block_Template
{
    public function getLeftBarCategory($_category)
    {
       return $_category->load(Mage::app()->getStore()->getRootCategoryId());
    }
}