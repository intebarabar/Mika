<?php

class Evolution_Custom_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected function _prepareCollection()
    {
        $store = $this->_getStore();

        /**
         * @var Mage_Catalog_Model_Resource_Product_Collection $collection
         */
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id');

        if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left');
        }
        $collection->joinField('is_in_stock',
            'cataloginventory/stock_item',
            'is_in_stock',
            'product_id=entity_id',
            '{{table}}.stock_id=1',
            'left');
        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
            $collection->joinAttribute(
                'custom_name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'visibility',
                'catalog_product/visibility',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'price',
                'catalog_product/price',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
        }
        else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }

        $this->setCollection($collection);

        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('stock_status',
            array(
                'header'=> 'Stock Status',
                'width' => '60px',
                'index' => 'is_in_stock',
                'type'  => 'options',
                'filter_condition_callback' => array($this, 'filter_street'),
                'options' => array(
                    '1'=>'In Stock',
                    '0'=>'Out Of Stock'
                ),
            ));

        return parent::_prepareColumns();
    }

    public function filter_street($collection, $column)
    {
        if (!$column->getFilter()->getCondition()) {
            return;
        }
        $collection->addFieldToFilter('is_in_stock',$column->getFilter()->getCondition());
    }

}