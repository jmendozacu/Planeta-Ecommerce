<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Alert
 */    
class Amasty_Alert_Block_Adminhtml_Price_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('priceGrid');
        $this->setDefaultSort('cnt');
    }
    
    protected function _prepareCollection()
    {
        $productsTable = Mage::getSingleton('core/resource')->getTableName('catalog/product');
        $c = Mage::getModel('productalert/price')->getCollection();
        $c->getSelect()
            ->columns(array('cnt' => 'count(*)', 'last_d'=>'MAX(add_date)', 'first_d'=>'MIN(add_date)', 'min_p'=>'MIN(price)', 'max_p'=>'MAX(price)'))
            ->joinInner(array('e'=> $productsTable), 'e.entity_id = product_id', array('sku'))
            ->group(array('website_id', 'product_id'))
        ;
        
        $this->setCollection($c);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $hlp =  Mage::helper('amalert'); 
    
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('websites',
                array(
                    'header'=> Mage::helper('catalog')->__('Websites'),
                    'width' => '100px',
                    'sortable'  => false,
                    'index'     => 'websites',
                    'type'      => 'options',
                    'options'   => Mage::getModel('core/website')->getCollection()->toOptionHash(),
            ));
        } 
        
        $this->addColumn('sku', array(
            'header'    => $hlp->__('SKU'),
            'index'     => 'sku',
        ));
        
        $this->addColumn('cnt', array(
            'header'      => $hlp->__('Count'),
            'index'       => 'cnt',
            'filter'  => false,
        ));
        
        $this->addColumn('min_p', array(
            'header'        => $hlp->__('Min Price'),
            'index'         => 'min_p',
            'filter'        => false,
            'type'          => 'price',
            'currency_code' => Mage::app()->getStore(0)->getBaseCurrency()->getCode(), 
        ));
        
        $this->addColumn('max_p', array(
            'header'        => $hlp->__('Max Price'),
            'index'         => 'max_p',
            'filter'        => false,
            'type'          => 'price',
            'currency_code' => Mage::app()->getStore(0)->getBaseCurrency()->getCode(), 
        ));
       
        $this->addColumn('first_d', array(
            'header'    => $hlp->__('First Subscription'),
            'index'     => 'first_d',
            'type'      => 'datetime', 
            'width'     => '150px',
            'gmtoffset' => true,
            'default'	=> ' ---- ',
            'filter'  => false,
        ));
        
        $this->addColumn('last_d', array(
            'header'    => $hlp->__('Last Subscription'),
            'index'     => 'last_d',
            'type'      => 'datetime', 
            'width'     => '150px',
            'gmtoffset' => true,
            'default'	=> ' ---- ',
            'filter'  => false,
        ));

        
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/catalog_product/edit', array('id' => $row->getProductId())); 
    }
}